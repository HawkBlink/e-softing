<?php
if(!empty($_GET['id_event'])){
	$id_event = $_GET['id_event'];
		$event = $profil->prepare("SELECT * FROM event WHERE :id_event");
			$event->execute(array('id_event' => $id_event));
			if($event){
				while($donnees = $event->fetch()){

					$date_into = $donnees['date_event'];
					$name_event_into = $donnees['nom_event'];
					$descript_event_into = $donnees['descript_event'];
					$name_rue_into = $donnees['name_rue'];
					$name_city_into = $donnees['name_city'];
					$code_postal_into = $donnees['code_postal'];
					$heure_debut_into = $donnees['heure_debut'];
					$name_allee_into = $donnees['name_allee'];
					$num_rue_into = $donnees['num_rue'];
				}
				$event->closeCursor();

				if(!empty($_POST['name_event'])){
					if(!empty($_POST['date_event'])){
						if(!empty($_POST['descript_event'])){
							if(!empty($_POST['name_allee'])){
								if(!empty($_POST['name_rue'])){
									if(!empty($_POST['code_postal'])){
										if(!empty($_POST['heure_debut'])){
											if(!empty($_POST['num_rue'])){
												require '../../../modele/bdd.php';

												$code_postal = intval($_POST['code_postal']);
												 	$name_event = htmlspecialchars($_POST['name_event']);
												 	$descript_event = htmlspecialchars($_POST['descript_event']);
										           	$date = date('Y-m-d', strtotime($_POST['date_event']));
										           	$name_rue = htmlspecialchars($_POST['name_rue']);
													$name_city = htmlspecialchars($_POST['name_city']);
													
													$heure_debut = date('H:i', strtotime($_POST['heure_debut']));
													$name_allee = htmlspecialchars($_POST['name_allee']);
													$num_rue = htmlspecialchars($_POST['num_rue']);
													$num_rue = str_replace(' ', '', $num_rue);


													$event = $profil->prepare("UPDATE event SET date_event = :date_event, nom_event = :nom_event, descript_event = :descript_event, name_city = :name_city, name_rue = :name_rue, name_allee = :name_allee, code_postal = :code_postal, heure_debut = :heure_debut, num_rue = :num_rue WHERE id = :id_event");
										    		//Si l'exécution ne retourne pas d'erreur
										            $event->execute(array(
										            					  'date_event' => $date,
										            					  'nom_event' => $name_event,
										            					  'descript_event' => $descript_event,
										            					  'id_event' => $id_event,
										            					  'name_city' => $name_city,
										            					  'name_rue' => $name_rue,
										            					  'name_allee' => $name_allee,
										            					  'code_postal' => $code_postal,
										            					  'heure_debut' => $heure_debut,
										            					  'num_rue' => $num_rue
										            					));
										            if($event){
										            	echo'<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
											                  <strong>La mise à jour de l\'évènement à bien été effectué à votre agenda !</strong>
											                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											                    <span aria-hidden="true">&times;</span>
											                  </button>
											                </div>';
											                $event->CloseCursor();
										            }else{
										            	echo'<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
											                  <strong>L\'evenement n\'a pas pus être mis à jour suite à une erreur</strong>
											                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											                    <span aria-hidden="true">&times;</span>
											                  </button>
											                </div>';
											                $event->CloseCursor();
										            }
									        }
						        		}
						    		}
								}
							}		
						}
					}
				}

			}else{
				header('Location: '.$liens_internet.'/vue/admin/event/agenda.php?token='.$_GET['token'].'&id='.$_GET['id'].'');
				$event->closeCursor();
			}
}else{

	if(!empty($_POST['name_event'])){
		if(!empty($_POST['date_event'])){
			if(!empty($_POST['descript_event'])){
				include'../../../modele/bdd.php';
					 	$name_event = htmlspecialchars($_POST['name_event']);
					 	$descript_event = htmlspecialchars($_POST['descript_event']);
			            $date = date('Y-m-d', strtotime($_POST['date_event']));
						$name_rue = htmlspecialchars($_POST['name_rue']);
						$name_city = htmlspecialchars($_POST['name_city']);
						$code_postal = intval($_POST['code_postal']);
						$heure_debut = date('H:i', strtotime($_POST['heure_debut']));
						$name_allee = htmlspecialchars($_POST['name_allee']);
						$num_rue = htmlspecialchars($_POST['num_rue']);
						$num_rue = str_replace(' ', '', $num_rue);

					$event = $profil->prepare("INSERT INTO event(date_event, nom_event, descript_event, name_city, name_rue, name_allee, code_postal, heure_debut, num_rue) VALUES(:date_event, :name_event, :descript_event, :name_city, :name_rue, :name_allee, :code_postal, :heure_debut, :num_rue)");
			    		//Si l'exécution ne retourne pas d'erreur
			            $event->execute(array(
			            					  'date_event' => $date,
			            					  'name_event' => $name_event,
			            					  'descript_event' => $descript_event,
			            					  'name_city' => $name_city,
						            		  'name_rue' => $name_rue,
						            		  'name_allee' => $name_allee,
						            		  'code_postal' => $code_postal,
						            		  'heure_debut' => $heure_debut,
						            		  'num_rue' => $num_rue
			            					));
			            if($event){
			            	echo'<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
				                  <strong>L\'evenement à bien été ajouté à votre agenda !</strong>
				                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                    <span aria-hidden="true">&times;</span>
				                  </button>
				                </div>';
				                $event->CloseCursor();
			            }else{
			            	echo'<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
				                  <strong>L\'evenement n\'a pas pus être ajouté suite à une erreur</strong>
				                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                    <span aria-hidden="true">&times;</span>
				                  </button>
				                </div>';
				                $event->CloseCursor();
			            }

						
			}
		}
	}
}

if(!empty($_POST['suppr_event'])){
	if(!empty($_POST['id_event_suppr'])){
		$id_event_suppr = htmlspecialchars($_POST['id_event_suppr']);
		$supprEvent = $profil->prepare("DELETE FROM event WHERE id = ?"); 
			$execSupprEvent = $supprEvent->execute(array($id_event_suppr));
				if($execSupprEvent){
					echo'<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
				                  <strong>L\'evenement à bien été supprimé de votre agenda !</strong>
				                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                    <span aria-hidden="true">&times;</span>
				                  </button>
				                </div>';
				    $supprEvent->closeCursor();           
				    header('Location: '.$liens_internet.'/vue/admin/event/agenda.php?token='.$_GET['token'].'&id='.$_GET['id'].'');	
				}else{
					echo'div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
				                  <strong>L\'evenement n\'a pas pus être supprimé suite à une erreur</strong>
				                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                    <span aria-hidden="true">&times;</span>
				                  </button>
				                </div>';
				    $supprEvent->closeCursor();
				    header('Location: '.$liens_internet.'/vue/admin/event/agenda.php?token='.$_GET['token'].'&id='.$_GET['id'].'');	
				}
	}
}