<?php 
require '../modele/bdd.php';
$event = $profil->prepare("SELECT * FROM event");
$event->execute();
$result = $event->fetchColumn();

if($result != false){
		$event->execute();
		while($donnees = $event->fetch()){
			
			date_default_timezone_set('Europe/Paris');
			$date_actuel = date('Y-m-d');

			if($date_actuel > $donnees['date_event']){
				$event = $profil->prepare("DELETE FROM event WHERE id = ?");
					$event->execute(array($donnees['id']));
	
			}else{
				$event->closeCursor();
			}
		}
	$event->closeCursor();
}

