<?php
//on test la variable co pour éviter les erreurs à l'ouverture de la page;
if(htmlspecialchars(isset($_POST['co']))){
    //On test si les champs sont tous remplits
    if(!empty(htmlspecialchars(strip_tags($_POST["email"])))){
            $verif_si_vide = 1;
            $_SESSION['email'] = $_POST['email'];
        if(!empty(htmlspecialchars(strip_tags($_POST["pass"])))){
            $verif_si_vide = 1;
            $_SESSION['mdp'] = $_POST['pass'];
            
        

            if($verif_si_vide == 1){
            //creation d'un token aléatoire basé sur un nombre entre 1 et 32752;
                $_SESSION['token'] = sha1(time()*rand());
                //on charge les class;
                    require 'controleur/class/loadclass.php';

                    //on initialise une variable tableau avec les donnees entrées et on appel la class de verif;
                    $email_pass = array('email'=>$_POST['email'], 'pass'=>$_POST['pass'], 'liens_internet' => $liens_internet, 'liens_absolu' => $liens_absolu);
                    new SessionVerif($email_pass);
                                
            }
        }else{
            $verif_si_vide = 0;
            $_SESSION['erreur'] = 'Le champs mot de passe est vide';
            header('refresh:0');
        }
        
    }else{
        $verif_si_vide = 0;
        $_SESSION['erreur'] =  'Veuillez entrez votre adresse e-mail';
        header('refresh:0');
    }
}
    else{
        return false;
    }
?>