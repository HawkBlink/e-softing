<?php 
$i = 0;
//On inclu la bdd
    include 'bdd.php';


$event = $profil->prepare("SELECT * FROM event ORDER BY id DESC");
$event->execute();
$result = $event->fetchColumn();
?>
<table class="table table-dark table-striped table table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col"></th>
      <th scope="col">Nom de l'évènement</th>
      <th scope="col">Date de l'évènement</th>
    </tr>
  </thead>
  <tbody>
<?php 
	if($result != false){
		$event->execute();
		while($donnees = $event->fetch()){
			$dateH = new Datetime($donnees['date_event']);
			$dateH = date_format($dateH, 'd/m/Y');
			$i ++;
			 ?>
				<tr>
					<th <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/event/agenda.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_event='.$donnees['id'].'\'"'; ?> ><?php echo $i; ?></th>
				    <td <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/event/agenda.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_event='.$donnees['id'].'\'"'; ?> ><?php echo $donnees['nom_event']; ?></td>
				    <td <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/event/agenda.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_event='.$donnees['id'].'\'"'; ?> ><?php echo $dateH; ?></td>
				</tr> 
		<?php } ?>
	</tbody>
</table>
	
<?php  
		$event->closeCursor();
	}else{
		echo'</tbody></table><div class="alert alert-warning" role="alert"><strong>Aucun évènement éxistant</strong></div>';
		$event->closeCursor();
	}

