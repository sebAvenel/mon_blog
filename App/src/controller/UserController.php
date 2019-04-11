<?php

namespace App\src\controller;

use App\src\service\DataControl;
use App\src\service\Sanitize;
use App\src\DAO\UserDAO;

/**
 * Class UserController
 * @package App\src\controller
 */
class UserController extends Controller
{
    private $userDAO;
    private $serverHost;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new UserDAO();
        $this->serverHost = $_SERVER['HTTP_HOST'];
    }

    /**
     * User Authentication
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function authUser()
    {
        $emailUser = Sanitize::onString('post', 'signInEmail');
        $pwdUser = Sanitize::onString('post', 'signInPassword');
        $dataUser = $this->userDAO->authUser($emailUser, $pwdUser);
        if ($dataUser && $dataUser['isActivateUser'] == 1) {
            $_SESSION['infosUser'] = $dataUser;

            return header('Location: ../public/index.php');
        }

        echo $this->twig->render('user/signIn.twig', [
            'errorAuthUser' => 'Email ou mot de passe incorrect'
        ]);

        return;
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
     * Delete a user
     */
    public function deleteUser()
    {
        $id = Sanitize::onString('post', 'idDeleteUser');
        $this->userDAO->deleteById($id);

        return header('Location: ../public/index.php?route=adminProfiles');
    }

    /**
     * Send a link to update password
     *
     * @return string|void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendmailForgotPassword()
    {
        $emailUser = Sanitize::onString('post', 'inputEmailForgotPassword');
        if (DataControl::emailControl($emailUser)) {
            echo $this->twig->render('user/forgotPassword.twig', [
               'error' =>  DataControl::emailControl($emailUser)
            ]);

            return;
        }

        if ($this->userDAO->checkMailUser($emailUser)) {
            $user = $this->userDAO->getUserByEmail($emailUser);
            $activatingKey = $user->getKeyActivate();
            $to = $emailUser;
            $subject = 'Oublie mot de passe';
            $message = "Madame, monsieur\n\n Vous nous avez fait part de l'oublie de votre mot de passe.
        
Pour mettre à jour votre mot de passe, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://$this->serverHost/PHP_OCR/mon_blog/App/public/index.php?route=updatePasswordPage&keyActivateUpdatePassword=$activatingKey

---------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
            $headers = 'FROM: Service_client_SAvenel_blog';
            $sent = mail($to, $subject, $message, $headers);
            if ($sent) {
                echo $this->twig->render('user/forgotPassword.twig', [
                    'successSendMailForgotPassword' => 'Si votre adresse e-mail est associée à un compte, vous recevrez un e-mail avec des instructions en cas d’oubli de mot de passe.'
                ]);

                return;
            }

            return $this->errorViewDisplay("erreur lors de l'envoi de l'email!");
        }

        echo $this->twig->render('user/forgotPassword.twig', [
            'successSendMailForgotPassword' => 'Si votre adresse e-mail est associée à un compte, vous recevrez un e-mail avec des instructions en cas d’oubli de mot de passe.'
        ]);

        return;
    }

    /**
     * Diplay the update password page
     *
     * @return string|void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updatePasswordPage()
    {
        $keyActivate = Sanitize::onString('get', 'keyActivateUpdatePassword');
        if ($this->userDAO->getUserByKeyActivate($keyActivate)) {
            $user = $this->userDAO->getUserByKeyActivate($keyActivate);
            if ($user->getKeyActivate() === $keyActivate) {
                echo $this->twig->render('user/updatePassword.twig', [
                    'email' => $user->getEmail()
                ]);

                return;
            }

            echo $this->errorViewDisplay('Ce lien semble périmé');
        }

        echo $this->errorViewDisplay('Ce lien semble périmé');
    }

    /**
     * Update password's user
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updatePassword()
    {
        $email = Sanitize::onString('get', 'email');
        $password = Sanitize::onString('post', 'inputUpdatePassword');
        $passwordConfirm = Sanitize::onString('post', 'inputConfirmUpdatePassword');
        $error = '';

        if (DataControl::passwordControl($password, $passwordConfirm)) {
            $error = DataControl::passwordControl($password, $passwordConfirm);
        }

        if ($error !== '') {
            echo $this->twig->render('user/updatePassword.twig', [
                'errorUpdatePassword' => $error,
                'inputs' => $_POST
            ]);

            return;
        }

        $this->userDAO->updatePasswordUser($password, $email);
        $this->userDAO->updateKeyActivateUser($email);
        echo $this->twig->render('user/updatePassword.twig', [
            'successUpdatePassword' => 'Votre mot de passe a bien été mis à jour. Vous pouvez maintenant vous connecter'
        ]);

        return;
    }

    /**
     * Send an user account activation email
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendmailRegisterUser()
    {
        $name = Sanitize::onString('post', 'inputRegisterUserName');
        $email = Sanitize::onString('post', 'inputRegisterUserMail');
        $password = Sanitize::onString('post', 'inputRegisterUserPassword');
        $passwordConfirm = Sanitize::onString('post', 'inputRegisterUserPasswordConfirm');
        $errors = [];

        if (DataControl::stringControl($name, 'nom', 3, 25)) {
            $errors['name'] = DataControl::stringControl($name, 'nom', 3, 25);
        }

        if (DataControl::emailControl($email, true)) {
            $errors['email'] = DataControl::emailControl($email, true);
        }

        if (DataControl::passwordControl($password, $passwordConfirm)) {
            $errors['password'] = DataControl::passwordControl($password, $passwordConfirm);
        }

        if (!empty($errors)) {
            echo $this->twig->render('user/register.twig', [
                'errorsRegisterUser' => $errors,
                'inputsRegisterUser' => $_POST
            ]);

            return;
        }

        $this->userDAO->registerUser($name, $email, $password);
        $keyActivateUser = $this->userDAO->getActivateKeyUser($email);
        $to = $email;
        $subject = 'Activation de votre compte SAvenel';
        $message = "Bienvenue sur VotreSite,

Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.

http://$this->serverHost/PHP_OCR/mon_blog/App/public/index.php?route=confirmRegisterUser&keyActivationUserAccount=$keyActivateUser

---------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
        $headers = 'FROM: SAvenel_blog';
        $sent = mail($to, $subject, $message, $headers);
        if ($sent) {
            echo $this->twig->render('user/register.twig', [
                'successSendmailRegisterUser' => 'Un email a été envoyé à '.$email.' afin d\'activer votre compte'
            ]);

            return;
        }

        echo $this->errorViewDisplay('Erreur lors de l\'envoi de l\'email');
    }

    /**
     * Activate a user account
     *
     * @return string|void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function userActivationAccount()
    {
        $keyActivate = Sanitize::onString('get', 'keyActivationUserAccount');
        if ($this->userDAO->getUserByKeyActivate($keyActivate)) {
            $user = $this->userDAO->getUserByKeyActivate($keyActivate);
            if ($user->getKeyActivate() === $keyActivate) {
                $this->userDAO->updateUserActivation($keyActivate);
                echo $this->twig->render('user/signIn.twig');

                return;
            }

            echo $this->errorViewDisplay('Ce lien semble périmé');
        }

        echo $this->errorViewDisplay('Ce lien semble périmé');
    }

    /**
     * Change the role of a user
     *
     * @return void
     */
    public function changeRoleUser()
    {
        $roleUser = Sanitize::onString('get', 'roleUser');
        $idUser = Sanitize::onInteger('get' , 'idUser');
        $this->userDAO->updateRoleUser($roleUser, $idUser);

        return header('Location: ../public/index.php?route=adminProfiles#containerTable');
    }
}
