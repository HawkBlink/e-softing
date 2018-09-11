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
      <th scope="col"></th>
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
			      	<td id="suppr">
			      		<button type="button" class="btn btn-outline-danger" data-toggle="modal" <?php echo 'data-target="#exampleModalCenter'.$i.'"'; ?>>
		                	supprimer
		              	</button>
			      	</td>
				</tr> 
				<!-- Modal -->
			              <div class="modal fade" <?php echo 'id="exampleModalCenter'.$i.'"'; ?> tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			                <div class="modal-dialog modal-dialog-centered" role="document">
			                  <div class="modal-content">
			                    <div class="modal-header">
			                      <h3 class="modal-title" style="text-align: center;">Voulez vous vraiment supprimer cette évènement ?</h3>
			                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span>
			                      </button>
			                    </div>
			                      <div class="modal-body">
			                      	<p>La suppression de l'évènement : <br /><h3><?php echo $donnees['nom_event']; ?></h3><br /> sera irréversible vous ne pourrais pas récupérer son contenu</p>
			                      </div>
			                      <div class="modal-footer">
			                      	<form method="POST" action="">
			                      		<input name="id_event_suppr" <?php echo 'value="'.$donnees['id'].'"'; ?> type="hidden"/>
				                      	<input type="submit" value="supprimer" name="suppr_event" class="btn btn-outline-danger">
			                  		</form> 
			                  	</div>
			                  </div>
			                </div>
			              </div>
		<?php } ?>
	</tbody>
</table>
	
<?php  
		$event->closeCursor();
	}else{
		echo'</tbody></table><div class="alert alert-warning" role="alert"><strong>Aucun évènement éxistant</strong></div>';
		$event->closeCursor();
	}

