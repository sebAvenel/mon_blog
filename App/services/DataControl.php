<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;

/**
 * Class DataControl
 * @package App\src\controller
 */
class DataControl
{
    /**
     * string input control function
     *
     * @param $content
     * @param $inputName
     * @param $minLength
     * @param null $maxLength
     * @return null|string
     */
    public static function stringControl($content, $inputName, $minLength, $maxLength = null)
    {
        if ($content == '') {
            return "Vous n'avez pas renseigné votre $inputName";
        } elseif (strlen($content) < $minLength) {
            return "Votre $inputName doit contenir au minimum $minLength caractères";
        } elseif ($maxLength) {
            if (strlen($content) > $maxLength) {
                return "Votre $inputName doit contenir au maximum $maxLength caractères";
            }
        } else {
            return null;
        }
    }

    /**
     * email input control function
     *
     * @param $email
     * @param bool $checkMail
     * @return null|string
     */
    public static function emailControl(string $email, $checkMail = false): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Veuillez renseigner un email valide";
        } elseif ($checkMail) {
            if ((new UserDAO())->checkMailUser($email)) {
                return 'Cette adresse email est déjà enregistrée';
            }
        } else {
            return null;
        }
    }

    /**
     * phone input control function
     *
     * @param $phone
     * @return null|string
     */
    public static function phoneControl($phone)
    {
        if ($phone == '') {
            return "Veuillez renseigner votre numéro de téléphone";
        } elseif (!preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $phone)) {
            return "Veuillez renseigner un numéro de téléphone valide";
        } else {
            return null;
        }
    }

    /**
     * password input control function
     *
     * @param $password
     * @param null $passwordConfirm
     * @return string
     */
    public static function passwordControl($password, $passwordConfirm = null)
    {
        if ($password == '') {
            return 'Veuillez renseigner un mot de passe';
        } elseif (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=(.*[0-9]){2,}).{6,15}$#", $password)) {
            return "Votre mot de passe doit comporter entre 6 et 15 caractères dont au moins 1 majuscule et 2 chiffres";
        } elseif ($passwordConfirm || $passwordConfirm == '') {
            if ($password !== $passwordConfirm) {
                return "Votre mot de passe et votre mot de passe de confirmation doivent être identiques";
            }

            return null;
        } else {
            return null;
        }
    }
}
