<?php
//initialisation de $i
$i = 0;
//On ouvre la bdd
require_once $liens_absolu.'/modele/bdd.php';
//On récupère tous dans la talbe billets par date de creation en partant du dernier
$lecArt = $profil->prepare("SELECT * FROM billets ORDER BY date_creation DESC");
	//On exécute la requête
	$lecArt->execute();
		//On vérifie qu'au une colone existe
		$result = $lecArt->fetchColumn();
	//Si une colone existe on peut récupérer les données	
	if($result != false){
		//On éxécute à nouveau la requête
	    $lecArt->execute();
	    	//On récupère toutes les données que l'on va afficher.
	      	while($donnees = $lecArt->fetch()){
	      		$i ++;
	      		$dateH = new Datetime($donnees['date_creation']);
				$dateH = date_format($dateH, 'd/m/Y'.' à '.'H:m:s');
				$contenuDecode = strip_tags(htmlspecialchars_decode($donnees['contenu']));
				$contenuLimiter = tronque($contenuDecode).'...';
				$auteur = $donnees['auteur'];
				$id = $donnees['id'];
				$titres = $donnees['titres'];
				$img_id = $donnees['img_id'];

					//On va chercher l'image d'enête
					$lecImg = $profil->prepare("SELECT * FROM image_text WHERE img_id = :id");
					$lecImg->execute(array('id' => $img_id));
						//On cut le liens pour en récupèrer seulement ce qu'on a besoin
						while($donneesImg = $lecImg->fetch()){
							$img_path = $donneesImg['img_path'];
							$img_path = explode($liens_absolu.'/', $img_path);
							$img_path = '../'.implode($img_path);
						}
						
					//Puis on les affiches en html
				?>

					  <div class="content col-lg-4 col-md-7 col-sm-9 offset-lg-1 offset-md-1 offset-sm-1">
					  	<img class="img-responsive rounded" <?php echo 'src="'.$img_path.'"'; ?> style="max-width:100%; margin-right: 15px;" /><br/><br/>
					    <span class="titres"><?php echo $titres ?></span><hr>
					    <?php echo $contenuLimiter; ?><hr>
					     <?php echo '<a class="liens float-right" href="'.$liens_internet.'/vue/actu/affichage/actualite_page.php?id_billets='.$id.'&type='.$_GET['type'].'">Lire la suite ...</a>'; ?></p>						
					   </div>

							
				<?php

			} 

				// Fin de la boucle des billets
		        $lecArt->closeCursor();
	     	}else{
	     		//Si non on retoune une alerte
	     		echo '<div class="container"><div class="alert alert-warning alert-dismissible fade show text-center" role="alert"><strong>Il n\'y a pas encore d\'articles publiés ici revenez plus tard !</strong></div></div>';
	     		$lecArt->closeCursor();
	     	}

//$contenuDecode est la chaîne de caractères et $nb le nombre de caractères maximum à afficher.
function tronque($contenuDecode, $nb = 200) 
{
    // Si le nombre de caractères présents dans la chaine est supérieur au nombre 
    // maximum, alors on découpe la chaine au nombre de caractères 
    if (strlen($contenuDecode) > $nb) 
    {
        $contenuDecode = substr($contenuDecode, 0, $nb);
        $position_espace = strrpos($contenuDecode, " "); //on récupère l'emplacement du dernier espace dans la chaine, pour ne pas découper un mot.
        $texte = substr($contenuDecode, 0, $position_espace);  //on redécoupe à la fin du dernier mot
    }
    return $contenuDecode; //on retourne la variable modifiée
}   	