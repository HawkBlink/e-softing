<?php

class GestArticle{
	private $liens_internet;
    private $liens_absolu;
	private $files_img; //Correspond à l'image uploader pour l'entête
	private $content_art; //Correspond au contenu de l'article
	private $objet_art; //Correspond au grand titre de l'article
	private $extension_upload;//Correspond à l'extension du fichier uploadé	
	private $extensions_valides;//Correspond aux extensions autorisés
	private $pathing;//Correspond au chemin du fichier uploadé
	private $maxsize;//Correspond à la taille du fichier uploadé
	private $img_id;//Correspond à l'id du fichier dans la BDD (Table imge_text);
	private $img_path_edit;
	private $returnFunction; //Corresponde à l'edition d'un article ou la créatrion d'un article
	private $id_billets;
	private $id_edit;
	private $img_path;
	private $code_error;
	private $code_success;
	//-------------------------------------------------------------------------------------------------DEBUT-----------------------------------------------------------------------------
	public function __construct($content){
		//Si l'hydratation est vrai on continu
		if($this->hydrate($content) == true){
			//Si le retour de la fonction est vrai c'est un succès
			if($this->ReturnFunction() == true){
				$this->SuccessError();
			}else{
				//Si non on signal une erreur
				$this->SuccessError();
			}
		}else{
			//Si les données sont mal hydraté on retourne une erreur.
            $this->code_error = 'Une erreur est survenu veuillez réssayer';
            $this->SuccessError();
		}
		
	}

	//Cette fonction permet de fournir tous les objets avec les données reçus
	private function hydrate($content){
		$this->liens_internet = $content['liens_internet'];
		$this->liens_absolu = $content['liens_absolu'];
		$this->code_erreur = null;
		$this->code_success = null;
		//On teste les variables Si les objets sont bien hydraté on retourne vrai
		if(isset($content['files_img']) && isset($content['content_art']) && isset($content['objet_art'])){
			$this->files_img = $content['files_img'];
			$this->content_art = $content['content_art'];
			$this->objet_art = $content['objet_art'];
			$this->maxsize = $content['maxsize'];
			$this->extensions_valides = $content['extensions_valides'];
			$this->returnFunction = 1;
			return true;
		}elseif(isset($content['content_art_edit']) && isset($content['objet_art_edit']) && isset($content['id_edit']) && isset($content['files_img']) && $content['extensions_valides'] &&  $content['maxsize']){
			$this->files_img = $content['files_img'];
			$this->id_edit = $content['id_edit'];
			$this->content_art = $content['content_art_edit'];
			$this->objet_art = $content['objet_art_edit'];
			$this->maxsize = $content['maxsize'];
			$this->extensions_valides = $content['extensions_valides'];
			$this->returnFunction = 2;
			return true;
		}elseif(isset($content['content_art_edit']) && isset($content['objet_art_edit']) && isset($content['id_edit'])){
			$this->id_edit = $content['id_edit'];
			$this->content_art = $content['content_art_edit'];
			$this->objet_art = $content['objet_art_edit'];
			$this->returnFunction = 3;
			return true;
		}elseif(isset($content['img_id']) && isset($content['id'])){
			$this->id_billets = $content['id'];
			$this->img_id = $content['img_id'];
			$this->returnFunction = 4;
			return true;
		}else{
			return false;
		}
	}

	private function ReturnFunction(){
		if($this->returnFunction == 1){
			if($this->GestNewArticle() == true){
				return true;
			}else{
				return false;
			}
		}elseif($this->returnFunction == 2 || $this->returnFunction == 3){
			if($this->GestEditArticle() == true){
				return true;
			}else{
				return false;
			}
		}elseif($this->returnFunction == 4){
			if($this->SupprArticle() == true){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
//------------------------------------------------------------------------------------Gestion du fichier DEBUT-------------------------------------------------------------------------------------
	private function GestNewArticle(){
		if($this->GestImgText() == true){
			$this->SeparatedExtensionUpload();
				if(in_array($this->extension_upload,$this->extensions_valides)){
			        if($this->MoveToUpload()){			                
						if($this->InsertPathImgBdd()){
							if($this->InsertBddArticle()){
								return true;
							}else{
								return false;
							}
			            }else{
			                return false;
			            }          
			        }else{
			           	return false;
			        }
			    }else{
			        $this->code_error = 'Ce type de fichier n\'est pas autorisé';
			        return false;
			    }
		}else{
			return false;
		}
	}

	private function GestEditArticle(){
		if($this->returnFunction == 2){
			if($this->GestImgText() == true){
				$this->SeparatedExtensionUpload();
					if(in_array($this->extension_upload,$this->extensions_valides)){
						
				        if($this->ReplaceFiles()){			                
							if($this->ReplaceBddArticle()){
								if($this->ReplacePathImgBdd()){
									return true;
								}else{
									return false;
								}
				            }else{
				                return false;
				            }          
				        }else{
				           	return false;
				        }
				    }else{
				        $this->code_error = 'Ce type de fichier n\'est pas autorisé';
				        return false;
				    }
			}else{		                
				return false;
			}
		}else{
			if($this->ReplaceBddArticle() == true){
				return true;
			}else{
				return false;
			}
		}
	}
	
	//Cette fonction permet de texté toutes les données de FILES
	private function GestImgText(){
		if(!empty($this->files_img['img'])){
			//On hydrate l'objet Pathing
			$this->pathing =  $this->liens_absolu.'/vue/img_art/'.$this->files_img['img']['name'];
		}else{
			$this->pathing =  $this->liens_absolu.'/vue/img_art/'.$this->files_img['img_edit']['name'];		
		}
		//Si Le fichier ressort une erreur on stop tout
		if(!empty($this->files_img['img']['error']) > 0){
			$this->code_error = "Erreur de réception du fichier : code d'erreur FILES : ".$this->files_img['img']['error']."";
			return false;
		}elseif(!empty($this->files_img['img_edit']['error']) > 0){
			$this->code_error = "Erreur de réception du fichier : code d'erreur FILES : ".$this->files_img['img_edit']['error']."";
			return false;
		}else{
			//On test la taille du fichier
			if(!empty($this->files_img['img']['size']) > $this->maxsize || !empty($this->files_img['img_edit']['size']) > $this->maxsize){
			   	$this->code_error = "Le fichier est trop lourd"; 
			   	return false;
			}else{
			    return true;
			}
		}
	}

	private function SupprArticle(){
		include $this->liens_absolu.'/modele/bdd.php';

			$lecImg = $profil->prepare("SELECT * FROM image_text WHERE img_id = ?");
				$lecImg->execute(array($this->img_id));
					 while($suppr = $lecImg->fetchAll()){
					 	$this->img_path = $suppr['0']['img_path'];
					 }

				$lecImg->closeCursor();

			if($this->img_path == true){
				$image_suppr_doss = unlink($this->img_path); //suppression de l'image d'entête dans le dossier 
					if($image_suppr_doss == true){

						$supprImg = $profil->prepare("DELETE FROM image_text WHERE img_id = ?"); 
							$execSupprImg = $supprImg->execute(array($this->img_id));

								if($execSupprImg){

									$supprImg->closeCursor();

									$supprArt = $profil->prepare("DELETE FROM billets WHERE id = :id"); 
										$execSuppr = $supprArt->execute(array('id' => $this->id_billets));
											if($execSuppr){
												echo'<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
												        <strong>L\'article à bien été supprimé !</strong>
												            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												                <span aria-hidden="true">&times;</span>
												            </button>
												     </div>';
												$supprArt->closeCursor();
												return true;
											}else{
												echo'<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
									                  <strong>L\'article que vous essayer de supprimé n\'existe pas</strong>
									                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									                    <span aria-hidden="true">&times;</span>
									                  </button>
									                </div>';
												$supprArt->closeCursor();
												return false;
											}
								}else{
									echo'<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
									                  <strong>L\'article que vous essayer de supprimé n\'existe pas</strong>
									                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									                    <span aria-hidden="true">&times;</span>
									                  </button>
									                </div>';
									$supprImg->closeCursor();
									return false;
								}
					}else{
						echo'<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
						        <strong>Une erreur est survenue lors de la suppression de l\'image d\'entête</strong>
						            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						                <span aria-hidden="true">&times;</span>
						            </button>
						    </div>';
						    return false;
					}
			}
	}
//------------------------------------------------------------------------------------Gestion du fichier FIN---------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------Upload du fichier DEBUT----------------------------------------------------------------------------------------------------
	//Cette fonction sert à télécharger le fichier
	private function MoveToUpload(){
		include $this->liens_absolu.'/modele/bdd.php';
		$moveAut = false;
			$array = file_exists($this->pathing);
			if($array){
				$moveAut = true;
			}

        if($moveAut == false){
			if(move_uploaded_file($this->files_img['img']['tmp_name'], $this->pathing)){
				return true;
			}else{
				$this->code_error = "Une erreur est survenue lors du téléchargement de votre fichier";
				return false;
			}
		}else{
			$supprImg = $profil->prepare("DELETE FROM image_text WHERE img_id = ?"); 
							$execSupprImg = $supprImg->execute(array($this->img_id));
								if($execSupprImg){
									$this->code_error = "Une image d'entête porte déjà ce nom, veuillez renommer votre fichier avant de l'envoyer";
								}
			$supprImg->closeCursor();
			return false;
		}
	}

	private function ReplaceFiles(){
		if($this->SearchImgId()){

			if(unlink($this->img_path)){
				move_uploaded_file($this->files_img['img_edit']['tmp_name'], $this->pathing);
				return true;
			}else{
				$this->code_error = 'Une erreur lors du remplacement de l\'image d\'entête est survenu, veuillez réssayer';
				return false;
			}
		}else{
			$this->code_error = 'Une erreur lors de la lecture de la base de données est survenu, veuillez réssayer';
			return false;
		}
	}
//------------------------------------------------------------------------------------Upload du fichier FIN-----------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------Insertion du chemin de l'image dans la BDD DEBUT-----------------------------------------------------------------------------
    //Cette fonction pert d'insérer le chemin de l'image dans la TABLE image_text img_path
    private function InsertPathImgBdd(){
    	//On inclu la bdd
    	include $this->liens_absolu.'/modele/bdd.php';
    	//On insert dans le champ img_path de la table image_text le chemin de l'image uploadé
    	$imgInsert = $profil->prepare("INSERT INTO image_text(img_path) VALUES(:pathing)");
    		//Si l'exécution ne retourne pas d'erreur
            if($imgInsert->execute(array('pathing' => $this->pathing))){
            	//Si la récuparation de l'id c'est bien passé
              	if($this->LectureBddPathimg()){
              		//On ferme la requête et on retourne vrai
              		$imgInsert->closeCursor();
              		return true;
              	}else{
              		//Si non on retourne faux et on ferme la requête
              		$imgInsert->closeCursor();
              		return false;
              	}
            }else{
            	//Si non retourne faux et on ferme la requête
            	$imgInsert->closeCursor();
            	return false;
            }
    }

	private function ReplacePathImgBdd(){
		//On hydrate l'objet Pathing
		$this->pathing =  $this->liens_absolu.'/vue/img_art/'.$this->files_img['img_edit']['name'];
		//On inclu la bdd
    	include $this->liens_absolu.'/modele/bdd.php';
    	//On insert dans le champ img_path de la table image_text le chemin de l'image uploadé
    	$imgInsert = $profil->prepare("UPDATE image_text SET img_path = :pathing WHERE img_id = :img_id");
    		//Si l'exécution ne retourne pas d'erreur
            if($imgInsert->execute(array('pathing' => $this->pathing, 'img_id' => $this->img_id))){
              		//On ferme la requête et on retourne vrai
              		$imgInsert->closeCursor();
              		return true;
            }else{
            	//Si non retourne faux et on ferme la requête
            	$imgInsert->closeCursor();
            	return false;
            }
	}
//------------------------------------------------------------------------------------Insertion du chemin de l'image dans la BDD FIN------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------Insertion du chemin du contenu de l'article dans la BDD DEBUT---------------------------------------------------------------------
    private function InsertBddArticle(){
    	//On inclu la bdd la class profil et la page profil
    	include $this->liens_absolu.'/modele/bdd.php';		
		//On récupère le nom et le prénom
		$auteur = $_SESSION['prenom'].' '.$_SESSION['nom'];
		$date = date("Y-m-d H:i:s");//On récupère la date du jour (Formate US)
		//On insert dans la table billets l'id de l'image, l'auteur le titres le contenu et la date du jour
 		$billets = $profil->prepare('INSERT INTO billets(img_id, auteur, titres, contenu, date_creation) VALUES(:img_id, :auteur, :titres, :contenu, NOW())');
 		//Si l'éxecution c'est bien passé
        $billets2 = $billets->execute(array('img_id' => $this->img_id, 'auteur' => $auteur, 'titres' => $this->objet_art, 'contenu' => $this->content_art));          
		if($billets2){ 
			//Alor son retourne vrai et l'article est bien ajouté à la bdd
			$this->code_success = 'Nouvel article ajouté !';		
			return true;
		}else{
			//Si non on retourne faux et une erreur
			$this->code_error = 'Un problème est survenu lors de l\'intégration de l\'article';
			return false;
		}
	}

	private function ReplaceBddArticle(){
		//On inclu la bdd
		include $this->liens_absolu.'/modele/bdd.php';
		$date = date("Y-m-d H:i:s");//On récupère la date du jour (Format US)
		$editArt = $profil->prepare('UPDATE billets SET titres = :titres, contenu = :contenu, date_edit = NOW() WHERE id = :id_edit');
		$editArt2 = $editArt->execute(array(
						'titres' => $this->objet_art,
						'contenu' => $this->content_art,
						'id_edit' => $this->id_edit
					));
		if($editArt2){
			$this->code_success = 'La modification à bien été prise en compte !';
			return true;
		}else{
			$this->code_erreur = 'La modification n\'a pas été prise en compte réssayer';
			return false;
		}
	}
//------------------------------------------------------------------------------------Insertion du chemin du contenu de l'article dans la BDD FIN---------------------------------------------------------------------
//------------------------------------------------------------------------------------Récupération ID de l'image DEBUT-----------------------------------------------------------------------------------------------
    //Cette fonction permet de récupérer l'id de l'image dans la bdd
    private function LectureBddPathimg(){
    	//On inclu la bdd
    	include $this->liens_absolu.'/modele/bdd.php';
    	//Cette requête permet de cherché dans la table image_text le champ img_id par rapport au liens de l'image stocké dans img_path
    	$imgPath = $profil->prepare("SELECT img_id FROM image_text WHERE img_path = ?");
    		//Si la requête est bien exécuté
            if($imgPath->execute(array($this->pathing))){
            	//Si on peut récupérer les données
            	if($donnees = $imgPath->fetchAll()){
            		//Alors on récupérer l'id de l'image et on ferme la requête
	              	$this->img_id = $donnees['0']['img_id'];
	              	$imgPath->closeCursor();
	              	return true;
              	}else{
              		//Si non on ferme la requête et on retourn faux
              		$imgPath->closeCursor();
              		return false;
              	}
            }else{
            	//Si non on ferme la requête et on retourne faux
            	$this->code_error = 'Une erreur est survenu';
            	$imgPath->closeCursor();
            	return false;
            }
    }

	private function SearchImgId(){
    	//On inclu la bdd
    	include $this->liens_absolu.'/modele/bdd.php';
    	//Cette requête permet de cherché dans la table image_text le champ img_id par rapport au liens de l'image stocké dans img_path
    	$imgPath = $profil->prepare("SELECT * FROM billets WHERE id = ?");
    		//Si la requête est bien exécuté
            if($imgPath->execute(array($this->id_edit))){
            	//Si on peut récupérer les données
            	if($donnees = $imgPath->fetchAll()){
            		//Alors on récupérer l'id de l'image et on ferme la requête
	              	$this->img_id = $donnees['0']['img_id'];
	              	$this->LecEditPathImgBdd();
	              	$imgPath->closeCursor();
	              	return true;
              	}else{
              		//Si non on ferme la requête et on retourn faux
              		$imgPath->closeCursor();
              		return false;
              	}
            }else{
            	//Si non on ferme la requête et on retourne faux
            	$this->code_error = 'Une erreur est survenu';
            	$imgPath->closeCursor();
            	return false;
            }
	}

	//Cette fonction permet de récupérer l'id de l'image dans la bdd
    private function LecEditPathImgBdd(){
    	//On inclu la bdd
    	include $this->liens_absolu.'/modele/bdd.php';
    	//Cette requête permet de cherché dans la table image_text le champ img_id par rapport au liens de l'image stocké dans img_path
    	$imgPath = $profil->prepare("SELECT img_path FROM image_text WHERE img_id = ?");
    		//Si la requête est bien exécuté
            if($imgPath->execute(array($this->img_id))){
            	//Si on peut récupérer les données
            	if($donnees = $imgPath->fetchAll()){
            		//Alors on récupérer l'id de l'image et on ferme la requête
	              	$this->img_path = $donnees['0']['img_path'];
	              	$imgPath->closeCursor();
	              	return true;
              	}else{
              		//Si non on ferme la requête et on retourn faux
              		$imgPath->closeCursor();
              		return false;
              	}
            }else{
            	//Si non on ferme la requête et on retourne faux
            	$this->code_error = 'Une erreur est survenu';
            	$imgPath->closeCursor();
            	return false;
            }
    }
//------------------------------------------------------------------------------------Récupération ID de l'image FIN-----------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------FONCTION ANNEXE DEBUT----------------------------------------------------------------------------------------------------------
	//Cette fonction permet de séparer l'extension d'un fichier de ce nom
    private function SeparatedExtensionUpload(){
    	if(!empty($this->files_img['img'])){
	    	//Si l'extension à bien été retiré on retourne vrai
	    	if($this->extension_upload = strtolower(substr(strrchr($this->files_img['img']['name'],'.'),1))){
	    		return true;
	    	//Si non on retourne FAUX
	    	}else{
	    		return false;
	    	}
	    }elseif(!empty($this->files_img['img_edit'])){
	    	//Si l'extension à bien été retiré on retourne vrai
	    	if($this->extension_upload = strtolower(substr(strrchr($this->files_img['img_edit']['name'],'.'),1))){
	    		return true;
	    	//Si non on retourne FAUX
	    	}else{
	    		return false;
	    	}
	    }
    }
    //Cette fonnction affiche les erreurs
    private function SuccessError(){
        if($this->code_error != null){
        echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>'.$this->code_error.'</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
        }elseif($this->code_success != null){
        echo '<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
                  <strong>'.$this->code_success.'</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
        }
    }
//------------------------------------------------------------------------------------Insertion du chemin du contenu de l'article dans la BDD FIN---------------------------------------------------------------------	
}