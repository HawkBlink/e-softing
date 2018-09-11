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
		      		$dateH = date_format($dateH, 'd/m/Y à H:m:s');
					$contenuDecode = htmlspecialchars_decode($donnees['contenu']);
					$img_id = $donnees['img_id'];
					$titres = $donnees['titres'];
		      	}
		      	// Fin de la boucle des billets
			    $lecArt->closeCursor();
		}else{
			$lecArt->closeCursor();
			header('location: '.$liens_internet.'/vue/admin/Launch_page.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'');
		}
}else{
	header('location: '.$liens_internet.'/vue/admin/Launch_page.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'');
}