<?php
//--------------------------------------------------------------------------------------SUCCESS ERROR DEBUT------------------------------------------------------------------------

if(isset($_GET['success'])){
    echo '<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
                  <strong>'.$_GET['success'].'</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';$_GET['success'] = null;
}elseif(isset($_GET['error'])){
    echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>'.$_GET['error'].'</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
}
//--------------------------------------------------------------------------------------SUCCESS ERROR FIN------------------------------------------------------------------------
//--------------------------------------------------------------------------------------RECHERCHE DE DOSSIER DANS ALBUMS DEBUT------------------------------------------------------------------------
//écriture du chemin du dossier à afficher
$path = $liens_absolu.'/vue/albums/';
//si le dossier existe on l'ouvre
if(is_dir($path)){
    //on place le contenu du dossier dans $ope
    if($ope = opendir($path)){
        //tant que la lecture n'est pas terminé on continu et on place les noms des dossier dans $content
        while (($content = readdir($ope)) !== false) {
            //Si $content contient le dossier avec les nom '.' et '..' on en tient pas compt et on continue
            if( $content != '.' && $content != '..'){
            //On place le contenu de $content dans un un tableau
                $list_doss[] = $content;
            }
        }
        //on ferme le dossier
        closedir($ope);
    }else{
        echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Une erreur est survenu lors de l\'affichage du contenu du dossier</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';

    }
}else{
    echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Vous n\'avez pas encore de dossier personnel créer un nouveau dossier et ajouter un fichier pour continuer</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
}
//--------------------------------------------------------------------------------------RECHERCHE DE DOSSIER DANS ALBUMS FIN------------------------------------------------------------------------
//--------------------------------------------------------------------------------------RECHERCHE D'IMAGE DANS LE DOSSIER DANS ALBUMS DEBUT------------------------------------------------------------------------
//si la variable POST n'est pas vide
if(!empty($_POST['envoie_liens_img'])){
        //si la variable POST Upload n'est pas vide
        if(!empty($_POST['upload'])){
            //Si la variable $List_doss n'es tpas vide
            if(!empty($list_doss)){
                //On place en session la variable POST Upload
                $_SESSION['select'] = $_POST['upload'];
                $path = $liens_absolu.'/vue/albums/'. $_SESSION['select'] .'/*.{jpg,jpeg,gif,png}';//On place le chemin dans la variable $path
                $files = glob($path,GLOB_BRACE); //la fonction glob() permet de chercher un chemin pour des fichiers qu'on souhaites ex : .jpg .jpeg .gif etc.. et les places dans un array ici $files.
                //On parcours $files. $image correspond au liens des différentes images qu'on à retirer à $files
                foreach ($files as $image) {
                        //On place les liens des images dans une variable Array.
                        $liens_img[] = array($image);
                }
                
            }

        }
}
//--------------------------------------------------------------------------------------RECHERCHE DE DOSSIER DANS ALBUMS FIN------------------------------------------------------------------------
//--------------------------------------------------------------------------------------New Dossier DEBUT------------------------------------------------------------------------
    //Si la variable doss_new est vide il ne se passe rien 
    if(!empty($_POST['doss_new'])){
       
        //on include le chargement des classes
        include $liens_absolu.'/controleur/class/loadclass.php';

        //On initialise les variables que l'on va utiliser
        $nom = $_POST['doss_new'];
        $dossier_path = $liens_absolu.'/vue/albums';

        //On les places dans un array
        $content = array('nom' => $nom, 'dossier_path' => $dossier_path, 'liens_internet' => $liens_internet, 'liens_absolu' => $liens_absolu);

        //Et on envoie tous la class GestPhoto
        $NewDoss = new GestPhoto($content);
    }
//--------------------------------------------------------------------------------------New Dossier FIN------------------------------------------------------------------------
//--------------------------------------------------------------------------------------Upload Image DEBUT------------------------------------------------------------------------

   //Si Fichier n'est pas vide on traite l'information
    if(!empty($_FILES['img'])){
        if(!empty(htmlspecialchars(isset($_POST['upload'])))){
            if(!empty(htmlspecialchars($_POST['namefile']))){
            //On vérifi qu'un dossier à bien été sélectionné
           
                //on include le chargement des classes
                include $liens_absolu.'/controleur/class/loadclass.php';

                //on initialise les variables qui serons utilisé
                $namefile = htmlspecialchars($_POST['namefile']);
                $nameFich = $_FILES['img']['name'];
                $dossier = htmlspecialchars($_POST['upload']);
                $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );

                //On place toutes les donnèes dans un array
                $content = array('Fichier' => $_FILES['img'], 'MAX_FILE_SIZE' => $_POST['MAX_FILE_SIZE'], 'dossier'=>$dossier, 'extension'=>$extensions_valides, 'namefile'=>$namefile, 'liens_internet' => $liens_internet, 'liens_absolu' => $liens_absolu);
                
                //et on envoi tous à la class GestPhoto 
                $GestImg = new GestPhoto($content);

            }else{
            echo'<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Veuillez nommer votre fichier avant l\'envoi</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
            }
        }else{
        echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Veuillez choisir un fichier à envoyer</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        }
    }
//--------------------------------------------------------------------------------------Upload Image FIN--------------------------------------------------------------------------
//--------------------------------------------------------------------------------------Dell dossier DEBUT------------------------------------------------------------------------
    if(!empty($_POST['suppr_doss'])){

        if(!empty($list_doss)){
            include $liens_absolu.'/controleur/class/loadclass.php';

            $suppr_doss = $_POST['suppr_doss'];
            $dossier_path = $liens_absolu.'/vue/albums/'.$suppr_doss;

            $content = array('dossier_path'=>$dossier_path, 'suppr_doss'=>$suppr_doss, 'liens_internet' => $liens_internet, 'liens_absolu' => $liens_absolu);

            //et on envoi tous à la class GestPhoto 
            $GestSuppr = new GestPhoto($content);
        }
    }
//--------------------------------------------------------------------------------------DEll dossier FIN------------------------------------------------------------------------
//--------------------------------------------------------------------------------------Dell Image DEBUT------------------------------------------------------------------------
//Si la variable POST selection n'est pas vide
if(!empty($_POST['selection'])){ 
    //On appel les classes   
    include $liens_absolu.'/controleur/class/loadclass.php';
        //on initialise la variable liens_img qui compore tous les liens des images coché dans le select checkbox
        $liens_img = $_POST;
            //On initialise content pour envoyer les données à la class
            $content = array('liens_img'=>$liens_img, 'liens_internet' => $liens_internet, 'liens_absolu' => $liens_absolu);
                //Et on appel la class GestPhoto.
                $GestSupprImg = new GestPhoto($content);
}
//--------------------------------------------------------------------------------------Dell Image DEBUT------------------------------------------------------------------------

