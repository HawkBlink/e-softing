<?php

	$Search = $profil->prepare('UPDATE profil SET nom = :nom WHERE  id = :id');

		$result = $Search->execute(array('nom' => $this->nom,
										'id' => $this->id
									));

			if($result){
				$Search->closeCursor();
					$Search = $profil->prepare('SELECT nom FROM profil WHERE  id = :id');
						$result = $Search->execute(array('id' => $this->id));

						while($contenu = $Search->fetch()){
							$_SESSION['nom'] = $contenu['nom'];

						}
				$Search->closeCursor();
				return true;
			}else{
				$Search->closeCursor();
				$this->code_error = 'Une erreur est survenu, veuillez réssayer';
				return false;
			}

