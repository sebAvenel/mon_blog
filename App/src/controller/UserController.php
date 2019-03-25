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
    private $serverHost;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new UserDAO();
        $this->sessionArray = array('errorAuthUser', 'errorsRegisterUser', 'inputsRegisterUser', 'successSendmailRegisterUser');
        $this->serverHost = $_SERVER['HTTP_HOST'];
    }

    /**
     * User Authentication
     *
     * @param $emailUser
     * @param $pwdUser
     * @param $rememberUser
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function authUser($emailUser, $pwdUser, $rememberUser = null)
    {
        $dataUser = $this->userDAO->authUser($emailUser, $pwdUser);
        if ($dataUser && $dataUser['isActivateUser'] == 1) {
            if ($rememberUser) {
                session_cache_limiter('private');
                session_cache_expire(1);
            }
            $_SESSION['infosUser'] = $dataUser;
            return header('Location: ../public/index.php');
        } else {
            echo $this->Twig->render('user/signIn.twig', [
                'errorAuthUser' => 'Email ou mot de passe incorrect'
            ]);
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
     * Send a link to update password
     *
     * @param $emailUser
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendmailForgotPassword($emailUser)
    {
        if (DataControl::emailControl($emailUser)) {
            echo $this->Twig->render('user/forgotPassword.twig', [
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
 
http://$this->serverHost/PHP_OCR/mon_blog/App/public/index.php?route=forgotPassword&keyActivateUpdatePassword=$activatingKey

---------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
            $headers = 'FROM: Service_client_SAvenel_blog';
            $sent = mail($to, $subject, $message, $headers);
            if ($sent) {
                echo $this->Twig->render('user/forgotPassword.twig', [
                    'successSendMailForgotPassword' => 'Un lien vous a été envoyé afin de mettre à jour votre mot de passe.'
                ]);
            } else {
                $this->errorViewDisplay("erreur lors de l'envoi de l'email!");
            }
        } else {
            echo $this->Twig->render('user/forgotPassword.twig', [
                'successSendMailForgotPassword' => 'Un lien vous a été envoyé afin de mettre à jour votre mot de passe.'
            ]);
        }
    }

    /**
     * Diplay the update forgot password page
     *
     * @param $keyActivate
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function updateForgotPasswordPage($keyActivate)
    {
        if ($this->userDAO->getUserByKeyActivate($keyActivate)) {
            $user = $this->userDAO->getUserByKeyActivate($keyActivate);
            if ($user->getKeyActivate() === $keyActivate) {
                echo $this->Twig->render('user/updatePassword.twig', [
                    'email' => $user->getEmail()
                ]);
            } else {
                $this->errorViewDisplay('Ce lien semble périmé');
            }
        } else {
            $this->errorViewDisplay('Ce lien semble périmé');
        }
    }

    /**
     * Update password's user
     *
     * @param string $email
     * @param string $password
     * @param $passwordConfirm
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function updatePassword($email, $password, $passwordConfirm)
    {
        $error = '';
        if (DataControl::passwordControl($password, $passwordConfirm)) {
            $error = DataControl::passwordControl($password, $passwordConfirm);
        }
        if ($error !== '') {
            echo $this->Twig->render('user/updatePassword.twig', [
                'errorUpdatePassword' => $error,
                'inputs' => $_POST
            ]);
        } else {
            $this->userDAO->updatePasswordUser($password, $email);
            $this->userDAO->updateKeyActivateUser($email);
            echo $this->Twig->render('user/updatePassword.twig', [
                'successUpdatePassword' => 'Votre mot de passe a bien été mis à jour. Vous pouvez maintenant vous connecter'
            ]);
        }
    }

    /**
     * Send an user account activation email
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $passwordConfirm
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendmailRegisterUser($name, $email, $password, $passwordConfirm)
    {
        $errors = [];
        $this->sessionCleaner($this->sessionArray);

        if (DataControl::stringControl($name, 'nom', 3, 25)) {
            $errors['name'] = DataControl::stringControl($name, 'nom', 3, 25);
        }

        /*
        if (DataControl::emailControl($email, true)){
            $errors['email'] = DataControl::emailControl($email, true);
        }*/
        if (!array_key_exists('inputRegisterUserMail', $_POST) || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Vous n'avez pas renseigné un email valide";
        } elseif ($this->userDAO->checkMailUser($email)) {
            $errors['email'] = "Cet email est déjà pris";
        }

        if (DataControl::passwordControl($password, $passwordConfirm)) {
            $errors['password'] = DataControl::passwordControl($password, $passwordConfirm);
        }

        if (!empty($errors)) {
            echo $this->Twig->render('user/register.twig', [
                'errorsRegisterUser' => $errors,
                'inputsRegisterUser' => $_POST
            ]);
        } else {
            $this->userDAO->registerUser($name, $email, $password);
            $keyActivateUser = $this->userDAO->getActivateKeyUser($email);
            $to = $email;
            $subject = 'Activation de votre compte SAvenel';
            $message = "Bienvenue sur VotreSite,
 
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://$this->serverHost/PHP_OCR/mon_blog/App/public/index.php?route=registerUser&keyActivationUserAccount=$keyActivateUser

---------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
            $headers = 'FROM: SAvenel_blog';
            $sent = mail($to, $subject, $message, $headers);
            if ($sent) {
                echo $this->Twig->render('user/register.twig', [
                    'successSendmailRegisterUser' => 'Un email a été envoyé à '.$email.' afin d\'activer votre compte'
                ]);
            } else {
                $this->errorViewDisplay('Erreur lors de l\'envoi de l\'email');
            }
        }
    }

    /**
     *
     *
     * @param $keyActivate
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function userActivationAccount($keyActivate)
    {
        if ($this->userDAO->getUserByKeyActivate($keyActivate)) {
            $user = $this->userDAO->getUserByKeyActivate($keyActivate);
            if ($user->getKeyActivate() === $keyActivate) {
                $this->userDAO->updateUserActivation($keyActivate);
                echo $this->Twig->render('user/signIn.twig');
            } else {
                $this->errorViewDisplay('Ce lien semble périmé');
            }
        } else {
            $this->errorViewDisplay('Ce lien semble périmé');
        }
    }

    /**
     * Change the role of a user
     *
     * @param $roleUser
     * @param $idUser
     */
    public function changeRoleUser($roleUser, $idUser)
    {
        $this->userDAO->updateRoleUser($roleUser, $idUser);
        header('Location: ../public/index.php?route=adminProfiles#containerTable');
    }
}
