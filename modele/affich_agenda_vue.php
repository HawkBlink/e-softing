<?php 
$i = 0;
//On inclu la bdd
    include 'bdd.php';

$event = $profil->prepare("SELECT * FROM event ORDER BY id DESC");
$event->execute();
$result = $event->fetchColumn();

	if($result != false){
		$event->execute();
		?><div class="cal"> 
			<div class="cal-heading">Evènement à venir</div>
			<?php
		while($donnees = $event->fetch()){
			setlocale(LC_TIME, 'fr_FR.utf8','fra');
			$dateHJ = strtotime($donnees['date_event']);
			$dateHJ = date('d', $dateHJ);
			$dateHM = strtotime($donnees['date_event']);
			$dateHM = strftime('%b', $dateHM);
			$heureH = strtotime($donnees['heure_debut']);
			$heureH = date('H:i', $heureH);
			$date_format = strtotime($donnees['date_event']);
			$date_format2 = strftime('%b', $date_format);
			$date_format1 = date('Y', $date_format);
			$date_format3 = date('d', $date_format);
			$lieu = $donnees['code_postal'].' '.$donnees['name_city'].' '.$donnees['num_rue'].' '.$donnees['name_allee'].' '.$donnees['name_rue'];
			$maps = $donnees['code_postal'].'+'.$donnees['name_city'].'+'.$donnees['num_rue'].'+'.$donnees['name_allee'].'+'.$donnees['name_rue'];
			$i ++;
			 ?>

					  <div class="cal-event">
						    <div class="cal-event-tile" title="afficher sa description" data-toggle="modal" <?php echo 'data-target="#exampleModalCenter'.$i.'"'; ?>>
						      <div class="cal-event-tile-date"><?php echo $dateHJ; ?></div>
						      <div class="cal-event-tile-month"><?php echo $dateHM; ?></div>
						    </div>
						    <div class="cal-event-desc">
						      <div class="cal-event-title">
						        <div><?php echo $donnees['nom_event']; ?></div>
						      </div>
						      <div class="cal-event-time">
						        <icon class="far fa-clock" ></icon> 
						        	<?php echo $heureH; ?>
						      </div>
						      <div class="cal-event-location">
						        <icon  class="fas fa-map-marker-alt" ></icon>
						        <div class="cal-event-location-content">
						          <?php echo $lieu; ?>
						         </div> 
						      </div>
					      <a class="cal-event-map" <?php echo 'href="https://www.google.com/maps/search/'.$maps.'"'; ?> target="_blank"> Voir sur la carte</a>
					    </div>
					  </div>

					  
				<!-- Modal -->
			              <div class="modal fade" <?php echo 'id="exampleModalCenter'.$i.'"'; ?> tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			                <div class="modal-dialog modal-dialog-centered" role="document">
			                  <div class="modal-content">
			                    <div class="modal-header">
			                      <h3 class="modal-title" style="text-align: center;"><?php echo 'Le '.$date_format3.' '.$date_format2.' '.$date_format1.' prévu à '.$heureH; ?></h3>
			                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span>
			                      </button>
			                    </div>
			                      <div class="modal-body" style="word-wrap: break-word;">
			                      	<p><br /><p><?php echo $donnees['descript_event']; ?></p><br /></p>
			                      </div>
			                      <div class="modal-footer">
			                      	
			                  	</div>
			                  </div>
			                </div>
			              </div>

		<?php } ?>
		</div>
		<?php $event->closeCursor();
	}else{
		echo'</tbody></table><div class="alert alert-warning" role="alert"><strong>Aucun évènement éxistant</strong></div>';
		$event->closeCursor();
	}

