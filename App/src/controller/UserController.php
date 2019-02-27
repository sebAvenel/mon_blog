<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;

/**
 * Class UserController
 * @package App\src\controller
 */
class UserController extends Controller
{
    private $userDAO;
    private $sessionArray;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new UserDAO();
        $this->sessionArray = array('errorAuthUser', 'errorsRegisterUser', 'inputsRegisterUser', 'successSendmailRegisterUser');
    }

    /**
     * User Authentication
     *
     * @param string $emailUser
     * @param string $pwdUser
     * @param bool $rememberUser
     */
    public function authUser($emailUser, $pwdUser, $rememberUser)
    {
        $this->sessionCleaner($this->sessionArray);
        if ($rememberUser){
            setcookie('email', $emailUser, time() + 365*24*3600, null, null, false, true);
            setcookie('password', $pwdUser, time() + 365*24*3600, null, null, false, true);
        }
        $this->userDAO->authUser($emailUser, $pwdUser);
        if (isset($_SESSION['infosUser'])){
            return header('Location: ../public/index.php');
        } elseif (isset($_SESSION['errorAuthUser'])){
            return header('Location: ../public/index.php?route=signIn');
        }
    }

    /**
     * User disconnection
     */
    public function disconnectUser()
    {
        session_destroy();
        return header('Location: ../public/index.php');
    }

    /**
     * Send a new password
     *
     * @param $emailUser
     */
    public function forgotPassword($emailUser)
    {
        if ($this->userDAO->checkMailUser($emailUser)){
            $randomPassword = $this->randomString();
            $hashedRandomPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            $this->userDAO->updatePasswordUser($hashedRandomPassword, $emailUser);
            $to = $emailUser;
            $subject = 'Mot de passe oublié';
            $message = "Madame, monsieur\n\n Vous nous avez fait part de l'oublie de votre mot de passe. Voici votre nouveau mot de passe: " . $randomPassword;
            $headers = 'FROM: Service client SAvenel';
            $sent = mail($to, $subject, $message ,$headers);
            if ($sent){
                $_SESSION['successSendMailForgotPassword'] = 'Votre email a bien été envoyé';

                return header('Location: ../public/index.php?route=forgotPassword');
            } else {
                echo "erreur lors de l'envoi de l'email!";
            }
        } else {
            $_SESSION['errorCheckEmailForgotPassword'] = 'Email inconnu';

            return header('Location: ../public/index.php?route=forgotPassword');
        }
    }

    /**
     * Send a user account activation email
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $passwordConfirm
     */
    public function sendmailRegisterUser($name, $email, $password, $passwordConfirm)
    {
        $errors = [];
        $this->sessionCleaner($this->sessionArray);

        if (!array_key_exists('inputRegisterUserName', $_POST) || $name === '') {
            $errors['name'] = "Vous n'avez pas renseigné votre nom";
        }elseif (strlen($name) < 3 || strlen($name) > 25) {
            $errors['name'] = "Votre nom doit contenir entre 3 et 25 caractères";
        }
        if (!array_key_exists('inputRegisterUserMail', $_POST) || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Vous n'avez pas renseigné un email valide";
        } elseif ($this->userDAO->checkMailUser($email)){
            $errors['email'] = "Cet email est déjà pris";
        }
        if (!array_key_exists('inputRegisterUserPassword', $_POST)) {
            $errors['password'] = "Vous n'avez pas renseigné de mot de passe";
        } elseif (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=(.*[0-9]){2,}).{6,15}$#", $password)){
            $errors['password'] = "Votre mot de passe doit comporter entre 6 et 15 caractères dont au moins 1 majuscule et 2 chiffres";
        } elseif ($password != $passwordConfirm){
            $errors['password'] = "Votre mot de passe et votre mot de passe de confirmation doivent être identique";
        }
        if (!empty($errors)) {
            $_SESSION['errorsRegisterUser'] = $errors;
            $_SESSION['inputsRegisterUser'] = $_POST;
            header('Location: ../public/index.php?route=registerUser');
        } else {
            $to = $email;
            $subject = 'Activation de votre compte SAvenel';
            $message = 'Bienvenue sur VotreSite,
 
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://localhost/PHP_OCR/mon_blog/App/public/index.php?route=registerUser&nameActivationUserAccount='.$name.'&emailActivationUserAccount='.$email.'&passwordActivationUserAccount='.password_hash($password, PASSWORD_DEFAULT).'

---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';
            $headers = 'FROM: SAvenel blog';

            $sent = mail($to, $subject, $message ,$headers);
            if ($sent){
                $_SESSION['successSendmailRegisterUser'] = 'Un email a été envoyé à '.$email.' afin d\'activer votre compte';
                header('Location: ../public/index.php?route=registerUser');
            } else {
                echo "erreur lors de l'envoi de l'email!";
            }
        }
    }

    /**
     * Save a user in DB
     *
     * @param $name
     * @param $email
     * @param $password
     */
    public function registerUser($name, $email, $password)
    {
        $this->userDAO->registerUser($name, $email, $password);
        header('Location: ../public/index.php?route=signIn');
    }
}
