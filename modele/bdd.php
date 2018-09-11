<?php
try{
    $profil = new PDO('mysql:host=localhost;
                             dbname=u653649649_praxi;
                             charset=utf8', 'u653649649_esoft', 'Lorr5869@-');
    $profil->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e){

    die('Erreur : ' . $e->getMessage());

}