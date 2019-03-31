<?php

namespace App\src\controller;

use App\src\service\DataControl;
use App\src\service\Sanitize;

/**
 * Class HomeController
 * @package App\src\controller
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent:: __construct();
    }

    /**
     * Diplay the home page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function homePage()
    {
        echo $this->twig->render('home/home.twig');

        return;
    }

    /**
     * Display the sign in page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function signInPage()
    {
        echo $this->twig->render('user/signIn.twig');

        return;
    }

    /**
     * Display the forgot password page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function forgotPasswordPage()
    {
        echo $this->twig->render('user/forgotPassword.twig');

        return;
    }

    /**
     * Display the user registration page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function registerPage()
    {
        echo $this->twig->render('user/register.twig');

        return;
    }

    /**
     * Send an email contact
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendmail()
    {
        $name = Sanitize::onString('post', 'sendMailName');
        $email = Sanitize::onString('post', 'sendMailEmail');
        $phone = Sanitize::onString('post', 'sendMailPhone');
        $message = Sanitize::onString('post', 'sendMailMessage');
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
            echo $this->twig->render('home/home.twig', [
                'errorSentMail' => $errors,
                'inputsSentMail' => $_POST
            ]);

            return;
        }

        $to = 'sebastien.avenel@outlook.fr';
        $subject = 'Contact: ' . $name;
        $message2 = $message . "\n\n" . 'Téléphone: ' . $phone;
        $headers = 'FROM: ' . $email;
        $sent = mail($to, $subject, $message2, $headers);
        if ($sent) {
            echo $this->twig->render('home/home.twig', [
                'successSentMail' => 'Votre email a bien été envoyé'
            ]);

            return;
        }

        return $this->errorViewDisplay('Erreur lors de l\'envoi de l\'email');
    }
}
