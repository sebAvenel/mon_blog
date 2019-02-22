<?php

session_start();

$errors = [];

if (!array_key_exists('name', $_POST) || $_POST['name'] === ''){
    $errors['name'] = "Vous n'avez pas renseigné votre nom";
}elseif (strlen($_POST['name']) < 3){
    $errors['name'] = "Votre nom doit contenir au moins 3 caractères";
}

if (!array_key_exists('email', $_POST) || $_POST['email'] === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Vous n'avez pas renseigné un email valide";
}

if (!array_key_exists('phone', $_POST) || $_POST['phone'] === '' || !preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['phone'])){
    $errors['phone'] = "Vous n'avez pas renseigné un numéro de téléphone valide";
}

if (!array_key_exists('message', $_POST) || $_POST['message'] === ''){
    $errors['message'] = "Vous n'avez pas renseigné votre message";
}elseif (strlen($_POST['message']) < 30){
    $errors['name'] = "Votre message doit contenir au moins 30 caractères";
}

if (!empty($errors)){
    $_SESSION['errors'] = $errors;
    $_SESSION['inputs'] = $_POST;
    //var_dump($_SESSION['errors']);
    //var_dump($_SESSION['inputs']);
    header('Location: ../public/index.php?route=homeContact');
} else {
    $to = 'sebastien.avenel@outlook.fr';
    $subject = 'Contacté par ' . $_POST['name'];
    $message = $_POST['message'] . '<br><br>Téléphone: ' . $_POST['phone'];
    $headers = 'FROM: ' . $_POST['email'];

    $sent = mail($to, $subject, $message ,$headers);
    if($sent){
        $_SESSION['success'] = 'Votre email a bien été envoyé';
        header('Location: ../public/index.php?route=homeContact');
    }else{
        echo "erreur lors de l'envoi de l'email!";
    }
}

