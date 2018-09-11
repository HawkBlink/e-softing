<?php
$i = 0;
include'D:/wamp64/www/projet-bojoly/modele/bdd.php';

$lecArt = $profil->prepare("SELECT * FROM billets ORDER BY id DESC LIMIT 10");
$lecArt->execute();
$result = $lecArt->fetchColumn();
?>
<table class="table table-dark table-striped table table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col"></th>
      <th scope="col">Auteur</th>
      <th scope="col">Titres</th>
      <th scope="col">Date de creation</th>
    </tr>
  </thead>
  <tbody>
<?php 
	if($result != false){
		$lecArt->execute();
		while($donnees = $lecArt->fetch()){
			$dateH = new Datetime($donnees['date_creation']);
			$dateH = date_format($dateH, 'd/m/Y H:m:s');
			$i ++; ?>
				<tr>
			      <th><?php echo $i; ?></th>
			      <td><?php echo $donnees['auteur']; ?></td>
			      <td><?php echo $donnees['titres']; ?></td>
			      <td><?php echo $dateH; ?></td>
			    </tr>
				
		<?php } ?>
	</tbody>
</table>
<?php  
		$lecArt->closeCursor();
	}else{
		echo'</tbody></table><div class="alert alert-warning" role="alert"><strong>Aucun article existant</strong></div>';
		$lecArt->closeCursor();
	}
?>