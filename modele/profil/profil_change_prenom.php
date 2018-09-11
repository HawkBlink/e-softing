<?php

	$Search = $profil->prepare('UPDATE profil SET prenom = :prenom WHERE  id = :id');

		$result = $Search->execute(array('prenom' => $this->prenom,
										'id' => $this->id
									));

			if($result){
				$Search->closeCursor();
					$Search = $profil->prepare('SELECT prenom FROM profil WHERE  id = :id');
						$result = $Search->execute(array('id' => $this->id));

						while($contenu = $Search->fetch()){
							$_SESSION['prenom'] = $contenu['prenom'];

						}
				$Search->closeCursor();
				return true;
			}else{
				$Search->closeCursor();
				$this->code_error = 'Une erreur est survenu, veuillez réssayer';
				return false;
			}

