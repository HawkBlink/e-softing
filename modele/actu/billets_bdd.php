<?php

$i = 0;
require_once $liens_absolu.'/controleur/script/billets_bdd_header.php';

$lecArt = $profil->prepare("SELECT * FROM billets ORDER BY id DESC");
$lecArt->execute();
$result = $lecArt->fetchColumn();
?>
<table class="table table-dark table-striped table table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col"></th>
      <th scope="col">Auteur</th>
      <th scope="col">Titres</th>
      <th scope="col">Date de création</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php 
	if($result != false){
		$lecArt->execute();
		while($donnees_art = $lecArt->fetch()){
			$dateH = new Datetime($donnees_art['date_creation']);
			$dateH = date_format($dateH, 'd/m/Y H:m:s');
			$i ++;
			 ?>
				<tr>
					<th <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/newactu/modifart.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_billets='.$donnees_art['id'].'\'"'; ?> ><?php echo $i; ?></th>
				    <td <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/newactu/modifart.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_billets='.$donnees_art['id'].'\'"'; ?> ><?php echo $donnees_art['auteur']; ?></td>
				    <td <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/newactu/modifart.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_billets='.$donnees_art['id'].'\'"'; ?> ><?php echo $donnees_art['titres']; ?></td>
				    <td <?php echo 'onclick="document.location.href=\''.$liens_internet.'/vue/admin/newactu/modifart.php?token='.$_GET['token'].'&id='.$_GET['id'].'&id_billets='.$donnees_art['id'].'\'"'; ?> ><?php echo $dateH; ?></td>
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
			                      <h3 class="modal-title" style="text-align: center;">Voulez vous vraiment supprimer cette article ?</h3>
			                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span>
			                      </button>
			                    </div>
			                      <div class="modal-body">
			                      	<p>La suppression de l'article : <br /><h3><?php echo $donnees_art['titres']; ?></h3><br /> sera irréversible vous ne pourrais pas récupérer son contenu</p>
			                      </div>
			                      <div class="modal-footer">
			                      	<form method="POST" action="">
			                      		<input name="id_art" <?php echo 'value="'.$donnees_art['id'].'"'; ?> type="hidden"/>
			                      		<input name="img_id" <?php echo 'value="'.$donnees_art['img_id'].'"'; ?> type="hidden"/>
				                      	<input type="submit" value="supprimer" name="suppr_art" class="btn btn-outline-danger">
			                  		</form> 
			                  	</div>
			                  </div>
			                </div>
			              </div>
		<?php } ?>
	</tbody>
</table>
	
<?php  
		$lecArt->closeCursor();
	}else{
		echo'</tbody></table><div class="alert alert-warning" role="alert"><strong>Aucun article existant</strong></div>';
		$lecArt->closeCursor();
	}
