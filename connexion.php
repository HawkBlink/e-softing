<?php
require_once 'controleur/liens.php';
    include 'controleur/connexion/session_starter.php';
    $_GET['nb'] = 0;
?>

<!DOCTYPE.PHP>
<html>
    <head>
        <meta charset="utf-8" lang="fr">
        <meta name="viewport" content="width=device-width, initial-scale=1" shrink-to-fit="no"/>
            <title>Connexion | Praxis Admin</title>
            <link rel="shortcut icon" href="vue/css/img/logo.png">
            <link rel="stylesheet" href="vue/css/style_connexion.css">
            <link rel="stylesheet" href="vue/css/bootstrap/dist/css/bootstrap.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    </head>
        <body>
            <div class="container">
                <div class="row">
                    <form method="POST" action="connexion.php" class="form-connect col-lg-4 offset-lg-4 col-md-6 offset-md-4 col-sm-8 offset-sm-3">
                        <fieldset class="form-group">
                            <h3 class="">Connexion</h3><hr>

                                    <input  id="email" type="email" name="email" aria-describedby="emailHelp" placeholder="e-mail@outlook.fr" class="form-control"/>
                                    <div class="col-lg-8 col-md-8 col-sm-7 offset-sm-2 offset-lg-2 offset-md-2"><hr></div>
                                    <input id="pass" type="password" name="pass" placeholder="mot de passe" class="form-control"/>

                                    <hr><input type="submit" name="co" value="Connexion" class="btn btn-primary float-left padding_inter">
                                    <a <?php echo 'href="'.$liens_internet.'/index.php"'; ?> class="btn btn-primary float-right padding_inter">Accueil</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </body>
            <script src="vue/js/jquery-3.3.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="vue/css/bootstrap/dist/js/bootstrap.min.js"></script>
</html>

<?php
include 'controleur/connexion/connexion_begin.php';

?>