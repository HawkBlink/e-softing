<?php
if(isset($_GET['id_billets'])){
	$i = 0;
	include $liens_absolu.'/modele/bdd.php';
	$lecArt = $profil->prepare("SELECT * FROM billets WHERE id = :id");
	$lecArt->execute(array('id' => $_GET['id_billets']));

	$result = $lecArt->fetchColumn();
		
		if($result != false){
		      	$lecArt->execute();

		      	while($donnees = $lecArt->fetch()){
		      		
		      		$i ++;
		      		$dateH = new Datetime($donnees['date_creation']);
					$dateH = date_format($dateH, 'd/m/Y'.' à '.'H:m:s');
					$contenuDecode = htmlspecialchars_decode($donnees['contenu']);
					$img_id = $donnees['img_id'];
					$titres = $donnees['titres'];
					$auteur = $donnees['auteur'];
					if($donnees['date_edit'] != null){
						$date_edit = new Datetime($donnees['date_edit']);
						$date_edit = date_format($date_edit, 'd/m/Y'.' à '.'H:m:s');
					}

		      	}
		      	// Fin de la boucle des billets
			    $lecArt->closeCursor();
		}else{
			$lecArt->closeCursor();
			header('location: '.$liens_internet.'/index.php');
		}
		      	$lecArt = $profil->prepare("SELECT * FROM image_text WHERE img_id = :id");
				$lecArt->execute(array('id' => $img_id));
				while($donneesImg = $lecArt->fetch()){
					$img_path = $donneesImg['img_path'];
					$img_path = explode($liens_absolu."/vue/", $img_path);
					$img_path = '../../'.implode($img_path);

				}
}else{
	header('location: '.$liens_internet.'/index.php');
}