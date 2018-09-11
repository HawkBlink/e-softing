<?php
//On initialise la variable dossier avec le chemin absolu du répertoire qui loge tous les dossier photos.
$dossier = $liens_absolu.'/vue/albums/';

//Si La variable suppr_doss est contient des données on continu.
if(!empty($_POST['suppr_doss'])){
	//Si la variable $list_doss contient des donnèes on continu.
		if(!empty($list_doss)){
			//on initialise la varibale $path avec le chemin absolu en ajoutant le nom du dossier 
			$path = $liens_absolu.'/vue/albums/'.$value;

				//on supprime le dossier et si tous ce passe bien  on initilise la variable success et on rafraichi la page en javascript
				if(@!rmdir($path)){
					
					$_SESSION['success'] = 'Le dossier à bien été supprimé !';
					
				}else{//sinon on initialise erreur
					$_SESSION['erreur'] = 'Une erreur est survenue au moment de la suppression du dossier.';
				}
		}
	}
