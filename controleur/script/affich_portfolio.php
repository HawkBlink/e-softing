<?php

//écriture du chemin du dossier à afficher
$path = $liens_absolu.'/vue/albums/';
//si le dossier existe on l'ouvre
if(is_dir($path)){
    //on place le contenu du dossier dans $ope
    if($ope = opendir($path)){
        //tant que la lecture n'est pas terminé on continu et on place les noms des dossier dans $content
        while (($content = readdir($ope)) !== false) {
            //Si $content contient le dossier avec les nom '.' et '..' on en tient pas compt et on continue
            if($content != '.' && $content != '..'){
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

if(!empty($_POST['upload'])){


	$select_port = $_POST['upload'];

	if(!empty($erreur)){
		echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$erreur.'</div>';
	}

		if(!empty($_POST['envoie'])){

			if(!empty($list_doss)){

				$path = '../vue/albums/'. $select_port .'/*.{jpg,jpeg,gif,png}';
				$files = glob($path,GLOB_BRACE);

				foreach ($files as $image) {

		   			$liens_img[] = array($image);
				}
				
			}

		}
}