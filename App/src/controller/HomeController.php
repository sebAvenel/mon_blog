<?php

namespace App\src\controller;

/**
 * Class HomeController
 * @package App\src\controller
 */
class HomeController extends Controller
{
    private $sessionArray;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent:: __construct();
        $this->sessionArray = array('errorAuthUser', 'successSendMailForgotPassword', 'errorCheckEmailForgotPassword', 'errorAuthUser', 'errorsRegisterUser', 'inputsRegisterUser', 'successSendmailRegisterUser');
    }

    /**
     * Diplay the home page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function homePage()
    {
        echo $this->Twig->render('home/home.twig');
    }

    /**
     * Display the sign in page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function signInPage()
    {
        $this->sessionCleaner($this->sessionArray);
        echo $this->Twig->render('user/signIn.twig');
    }

    /**
     * Display the forgot password page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function forgotPasswordPage()
    {
        $this->sessionCleaner($this->sessionArray);
        echo $this->Twig->render('user/forgotPassword.twig');
    }

    /**
     * Display the user registration page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function registerPage()
    {
        $this->sessionCleaner($this->sessionArray);
        echo $this->Twig->render('user/register.twig');
    }

    /**
     * Send an email contact
     *
     * @param string $name
     * @param string $email
     * @param int $phone
     * @param string $message
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendmail($name, $email, $phone, $message)
    {
        $errors = [];

        if (DataControl::stringControl($name, 'nom', 3)) {
            $errors['name'] = DataControl::stringControl($name, 'nom', 3);
        }

        if (DataControl::emailControl($email)) {
            $errors['email'] = DataControl::emailControl($email);
        }

        if (DataControl::phoneControl($phone)) {
            $errors['phone'] = DataControl::phoneControl($phone);
        }

        if (DataControl::stringControl($message, 'message', 30)) {
            $errors['message'] = DataControl::stringControl($message, 'message', 30);
        }

        if (!empty($errors)) {
            echo $this->Twig->render('home/home.twig', [
                'errorSentMail' => $errors,
                'inputsSentMail' => $_POST
            ]);
        } else {
            $to = 'sebastien.avenel@outlook.fr';
            $subject = 'Contact: ' . $name;
            $message2 = $message . "\n\n" . 'Téléphone: ' . $phone;
            $headers = 'FROM: ' . $email;
            $sent = mail($to, $subject, $message2, $headers);
            if ($sent) {
                echo $this->Twig->render('home/home.twig', [
                    'successSentMail' => 'Votre email a bien été envoyé'
                ]);
            } else {
                echo "erreur lors de l'envoi de l'email!";
            }
        }
    }
}
