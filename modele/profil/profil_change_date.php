<?php 
	
	$Search = $profil->prepare('UPDATE profil SET date_born = :date_born WHERE  id = :id');
		$result = $Search->execute(array('date_born' => $this->date_born2,
										'id' => $this->id
									));

			if($result){
				$Search->closeCursor();
					$Search = $profil->prepare('SELECT date_born FROM profil WHERE  id = :id');
						$result = $Search->execute(array('id' => $this->id));

						while($contenu = $Search->fetch()){
							setlocale(LC_TIME, 'fr_FR.utf8','fra');
							$date = strtotime($contenu['date_born']);
							$date1 = strftime('%B', $date);
							$date2 = date('Y', $date);
							$date3 = date('d', $date);
							$_SESSION['date'] = $date3.' '.$date1.' '.$date2;
						}

				$Search->closeCursor();
				return true;
			}else{
				$Search->closeCursor();
				$this->code_error = 'Une erreur est survenu, veuillez réssayer';
				return false;
			}