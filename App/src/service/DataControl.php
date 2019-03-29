<?php

namespace App\src\service;

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
     * @param string $content
     * @param string $inputName
     * @param int $minLength
     * @param int $maxLength
     * @return null|string
     */
    public static function stringControl(string $content, string $inputName, int $minLength, int $maxLength = null): ?string
    {
        if ($content == '') {
            return "Vous n'avez pas renseigné votre $inputName";
        }

        if (strlen($content) < $minLength) {
            return "Votre $inputName doit contenir au minimum $minLength caractères";
        }

        if ($maxLength) {
            if (strlen($content) > $maxLength) {
                return "Votre $inputName doit contenir au maximum $maxLength caractères";
            }

            return null;
        }

        return null;
    }

    /**
     * email input control function
     *
     * @param string $email
     * @param bool $checkMail
     * @return null|string
     */
    public static function emailControl(string $email, $checkMail = false): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Veuillez renseigner un email valide";
        }

        if ($checkMail) {
            if ((new UserDAO())->checkMailUser($email)) {
                return 'Cette adresse email est déjà enregistrée';
            }

            return null;
        }

        return null;
    }

    /**
     * phone input control function
     *
     * @param string $phone
     * @return null|string
     */
    public static function phoneControl(string $phone): ?string
    {
        if ($phone == '') {
            return "Veuillez renseigner votre numéro de téléphone";
        }

        if (!preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $phone)) {
            return "Veuillez renseigner un numéro de téléphone valide";
        }

        return null;
    }

    /**
     * password input control function
     *
     * @param string $password
     * @param string $passwordConfirm
     * @return string
     */
    public static function passwordControl(string $password, string $passwordConfirm = null): ?string
    {
        if ($password == '') {
            return 'Veuillez renseigner un mot de passe';
        }

        if (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=(.*[0-9]){2,}).{6,15}$#", $password)) {
            return "Votre mot de passe doit comporter entre 6 et 15 caractères dont au moins 1 majuscule et 2 chiffres";
        }

        if ($passwordConfirm || $passwordConfirm == '') {
            if ($password !== $passwordConfirm) {
                return "Votre mot de passe et votre mot de passe de confirmation doivent être identiques";
            }

            return null;
        }

        return null;
    }
}
