# mon_blog
Projet numéro 5 de ma formation PHP/Symfony chez Openclassrooms qui consiste à créer un blog en POO avec architecture MVC.

## Description du projet

Voici les principales fonctionnalités disponibles suivant les différents statuts utilisateur:

  * Le visiteur:
      * Visiter la page d'accueil et ouvrir les différents liens disponibles (compte GitHub, compte Linkedin, CV).
      * Envoyer un message au créateur du blog.
      * Parcourir la liste des blogs et parcourir la liste de ses commentaires.
  * L'utilisateur:
      * **Prérequis:** s'être enregistré via le formulaire d'inscription.
      * Accès aux mêmes fonctionnaités que le visiteur.
      * Ajout de commentaires.
      * Modification/Suppression de ses commentaires.
      * Modification du mot de passe en cas d'oubli.
  * Administrateur:
      * **Prérequis:** avoir le status administrateur.
      * Accès aux mêmes fonctionnalités que le visiteur.
      * Ajout/suppression/modification de blog post.
      * Validation/suppression de commentaires.
      * Changement status utilisateur.
      * Suppression utilisateur.
      
## Informations 

Un thème de base a été choisi pour réaliser ce projet, il s'agit du thème Bootstrap [Freelancer](https://startbootstrap.com/themes/freelancer/).

Une version en ligne est disponible. Pour y accéder, cliquez [ici](http://savenelblog.ovh/).

## Contrôle du code

La qualité du code a été validé par [Code climate](https://codeclimate.com/). Vous pouvez accéder au rapport de contrôle en cliquant sur le badge ci-dessous.

[![Maintainability](https://api.codeclimate.com/v1/badges/85789d7ac71148757183/maintainability)](https://codeclimate.com/github/sebAvenel/mon_blog/maintainability)

## Prérequis

Php ainsi que Composer doivent être installés sur votre ordinateur afin de pouvoir correctement lancé le blog.

## Installation

  * Téléchargez et dézipper l'archive. Installer le contenu dans le répertoire de votre serveur:
      * Wamp : Répertoire 'www'.
      * Mamp : Répertoire 'htdocs'.
      
  * Accéder à votre base de données et importer les différents fichiers présent dans le dossier 'sql' de l'application dans cet ordre:
      * database.sql
      * bdd_blog.sql
      * dataset.sql
      
  * Editez le fichier 'config/dev.php-dist' avec les informations de connexion suivantes:
      * HOST: 'localhost' pour une installation locale, l'adresse de l'hôte pour une installation sur serveur distant.
      * DB_NAME: 'blog_p5'.
      * CHARSET: 'UTF8'.
      * DB_HOST: Ne pas modifier.
      * DB_USER: L'identifiant de connexion à votre base de données.
      * DB_PASS: Le mot de passe de votre base de données.

Ensuite placez-vous dans votre répertoire par le biais de votre console de commande (ou terminal) et renseignez la commande suivante:
   * 'composer install' pour windows.
   * 'php composer.phar install' pour Mac OS.
   
Les différentes dépendances indispensables au bon fonctionnement du site sont maintenant installées.
Renseignez l'url dans votre navigateur jusqu'au fichier 'index.php' situé dans 'App/public'.
Le blog apparaît sur votre écran.

## Outils utilisés

  * [Composer](https://getcomposer.org/)
  * [Bootstrap](https://getbootstrap.com/)
  * [Twig](https://twig.symfony.com/)
  
## Auteur

  * Avenel Sébastien
  
  
  
  
  
