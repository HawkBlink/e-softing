<?php 

	$Search = $profil->prepare('UPDATE profil SET email = :email WHERE  id = :id');
		$result = $Search->execute(array('email' => $this->email,
										'id' => $this->id
									));

			if($result){
				$Search->closeCursor();
					$Search = $profil->prepare('SELECT email FROM profil WHERE  id = :id');
						$result = $Search->execute(array('id' => $this->id));

						while($contenu = $Search->fetch()){
							$_SESSION['email'] = $contenu['email'];

						}
				$Search->closeCursor();
				return true;
			}else{
				$Search->closeCursor();
				$this->code_error = 'Une erreur est survenu, veuillez réssayer';
				return false;
			}