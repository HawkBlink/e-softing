<?php
//on inclut la bdd
include 'bdd.php';
//on lance la requête en vérifiant que l'attribut email existe;
$recup = $profil->prepare('SELECT * FROM profil WHERE email = ?');
//one execute la requête avec l'email envoyer en post
$recup->execute(array($_SESSION['email']));
    $liens[] = array('liens_internet' => $this->liens_internet, 'liens_absolu' => $this->liens_absolu);

    //Si l'e-mail n'est pas bon on retourne une erreur
    if($donnees = $recup->fetch()){
            //Si le mot de passe n'est pas bon on retourne une erreur si non on hydrate avec le contenue de la BDD
            if(password_verify($_SESSION['mdp'], $donnees['mdp'])){
                $this->hydrate($donnees, $liens);

            }else{
                header('refresh:0');
            }         
        
    }else{
        header('refresh:0');
    }