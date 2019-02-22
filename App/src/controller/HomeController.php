<?php

namespace App\src\controller;

/**
 * Class HomeController
 * @package App\src\controller
 */
class HomeController extends Controller
{

    /**
     * Displays the home page view
     */
    public function homePage()
    {
        echo $this->getTwig->render('frontOffice/home.twig');
    }

    /**
     * Displays the sign in page view
     */
    public function signInPage()
    {
        if (isset($_SESSION['errorAuthUser'])){
            unset($_SESSION['errorAuthUser']);
        }
        echo $this->getTwig->render('frontOffice/signIn.twig');
    }

    public function forgotPasswordPage()
    {
        echo $this->getTwig->render('frontOffice/forgotPassword.twig');
    }

    /**
     * Send an email
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

        if (!array_key_exists('sendMailName', $_POST) || $name === '') {
            $errors['name'] = "Vous n'avez pas renseigné votre nom";
        }elseif (strlen($name) < 3) {
            $errors['name'] = "Votre nom doit contenir au moins 3 caractères";
        }
        if (!array_key_exists('sendMailEmail', $_POST) || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Vous n'avez pas renseigné un email valide";
        }
        if (!array_key_exists('sendMailPhone', $_POST) || $phone === '' || !preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $phone)) {
            $errors['phone'] = "Vous n'avez pas renseigné un numéro de téléphone valide";
        }
        if (!array_key_exists('sendMailMessage', $_POST) || $message === '') {
            $errors['message'] = "Vous n'avez pas renseigné votre message";
        } elseif (strlen($message) < 30) {
            $errors['message'] = "Votre message doit contenir au moins 30 caractères";
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['inputs'] = $_POST;
            echo $this->getTwig->render('frontOffice/home.twig', [
                'errorSentMail' => $_SESSION['errors'],
                'inputsSentMail' => $_SESSION['inputs']
            ]);
        } else {
            $to = 'sebastien.avenel@outlook.fr';
            $subject = 'Contacté par ' . $name;
            $message = $message . 'Téléphone: ' . $phone;
            $headers = 'FROM: ' . $email;

            $sent = mail($to, $subject, $message ,$headers);
            if ($sent){
                $_SESSION['success'] = 'Votre email a bien été envoyé';
                echo $this->getTwig->render('frontOffice/home.twig', [
                    'successSentMail' => $_SESSION['success']
                ]);
            } else {
                echo "erreur lors de l'envoi de l'email!";
            }
        }
    }
}

