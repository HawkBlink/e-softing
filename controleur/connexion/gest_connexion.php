<?php
//Utiliser pour faire un retour en arrière sans tomber sur la page de traitement php;
session_cache_limiter('private_no_expire, must-revalidate');
//ouverture de la session;
session_start();

//on test la variable co pour éviter les erreurs à l'ouverture de la page;
if(htmlspecialchars(isset($_POST['co']))){

    //mise en session de l'email;
    $_SESSION['email'] = $_POST['email'];
        //inclusion de la verification des champs;
            include'controleur/verif_connexion.php';
}
    else{
        //si non rien ne ce passe et la session est détruite;
        session_destroy();
    }
?>