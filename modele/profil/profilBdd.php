<?php
//on inclut la bdd;
require $this->liens_absolu.'/modele/bdd.php';
//on veirifie que l'email existe dans la bdd si non on détruit la session et on retourne au formulaire de connexion;
if($recup = $profil->prepare('SELECT * FROM profil WHERE email ="' . $this->email . '"')){
    $donnees = 0;//on initilise données pour éviter les erreurs et on execute la requête;
                    $recup->execute(array($donnees));
                        //tant que donnée n'est pas égale à une valeur données on cherche;
                      while ($donnees = $recup->fetch())
                      {
                        //si des données sont trouvé on hydrate;
                        if($donnees['email'] == $this->email)
                        {
                            $this->hydrate($donnees);
                            //si non on renvoit un attribut erreur;
                        }else{
                            $this->erreur_bdd = 1;
                                return false;
                        }
                        
                      }
}else{
    $this->erreur_bdd = 1;
        session_destroy();
            header('location: '.$liens_internet.'/connexion.php');
    return false;
}