<?php
if(!empty($_POST['new_art'])){
	if(!empty($_POST['objet_art'])){
		if(!empty($_POST['editor'])){
			if($_FILES['img']['error'] != UPLOAD_ERR_NO_FILE){ ?>
<?php

				//on include le chargement des classes
			        include $liens_absolu.'/controleur/class/loadclass.php';
			        //On initialise les variables que l'on va utiliser
			        $content_art = htmlspecialchars($_POST['editor']);
			        $objet_art = htmlspecialchars($_POST['objet_art']);
			        $files_img = $_FILES;
			        $maxsize = $_POST['MAX_FILE_SIZE'];
			        $extension_valide = $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );

			        //On les places dans un array
			        $content = array('files_img' => $files_img, 'objet_art' => $objet_art, 'content_art' => $content_art, 'maxsize' => $maxsize, 'extensions_valides' => $extension_valide, 'liens_absolu' => $liens_absolu, 'liens_internet' => $liens_internet);
			        
			        //Et on envoie tous la class GestPhoto
			        $GestArt = new GestArticle($content);


			}else{
				 echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Veuillez ajouter une image d\'entête à votre article !</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
			}
		}else{
			 echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Ajouté du contenu à votre article !</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
		}
	}else{
		 echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Ajouté un titre à votre article !</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
	}
}

