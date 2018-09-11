<?php

class CreateChange{
	private $liens_internet;
    private $liens_absolu;
    private $ReturnFunction;
    private $nom;
    private $email;
    private $id;
    private $prenom;
    private $date_born2;
    public $code_error;
    public $code_success;

	public function __construct($content, $liens){

		//Si l'hydratation est vrai on continu
		if($this->hydrate($content, $liens) == true){
			//Si le retour de la fonction est vrai c'est un succès
			if($this->ReturnFunction() == true){
				$this->SuccessError();
			}else{
				//Si non on signal une erreur
				$this->SuccessError();
			}
		}else{
			//Si les données sont mal hydraté on retourne une erreur.
            $this->code_error = 'Une erreur est survenu veuillez réssayer';
            $this->SuccessError();
		}

	}

	private function hydrate($content, $liens){
		$this->liens_internet = $liens['liens_internet'];
		$this->liens_absolu = $liens['liens_absolu'];
		$this->id = $_SESSION['id'];
		if(!empty($content['nom'])){
			$this->ReturnFunction = 1;
			$this->nom = $content['nom'];
			return true;
		}
		if(!empty($content['prenom'])){
			$this->ReturnFunction = 2;
			$this->prenom = $content['prenom'];
			return true;
		}
		if(!empty($content['email2'])){
			$this->ReturnFunction = 3;
			$this->email = $content['email2'];
			return true;
		}
		if(!empty($content['date_born2'])){
			$this->ReturnFunction = 4;
			$this->date_born2 = $content['date_born2'];
			return true;
		}
	}

	private function ReturnFunction(){
		if($this->ReturnFunction == 1){
			if($this->ChangeNom()){
				$this->code_success = 'Le nom à bien été changé !';
				return true;
			}else{
				return false;
			}
		}
		if($this->ReturnFunction == 2){
			if($this->ChangePrenom()){
				$this->code_success = 'Le prenom à bien été changé !';
				return true;
			}else{
				return false;
			}
		}
		if($this->ReturnFunction == 3){
			if($this->ChangeEmail()){
				$this->code_success = 'L\'adresse email à bien été changé !';
				return true;
			}else{
				return false;
			}
		}
		if($this->ReturnFunction == 4){
			setlocale(LC_TIME, 'fr_FR.utf8','fra');
			$this->date_born2 = strtotime($this->date_born2);
			$this->date_born2 = date('Y-m-d', $this->date_born2);
			if($this->ChangeDate()){
				$this->code_success = 'La date de naissance à bien été changé';
				return true;
			}else{
				return false;
			}
		}
	}

	private function ChangeNom(){
		include $this->liens_absolu.'/modele/bdd.php';
			require $this->liens_absolu.'/modele/profil/profil_change_nom.php';
	}

	private function ChangePrenom(){
		include $this->liens_absolu.'/modele/bdd.php';
			require $this->liens_absolu.'/modele/profil/profil_change_prenom.php';
	}

	private function ChangeEmail(){
		include $this->liens_absolu.'/modele/bdd.php';
			require $this->liens_absolu.'/modele/profil/profil_change_email.php';
	}

	private function ChangeDate(){
		include $this->liens_absolu.'/modele/bdd.php';
			require $this->liens_absolu.'/modele/profil/profil_change_date.php';
	}


	//Cette fonnction affiche les erreurs
    private function SuccessError(){
        if($this->code_error != null){
        echo '<div class="col-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>'.$this->code_error.'</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
        }elseif($this->code_success != null){
        echo '<div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
                  <strong>'.$this->code_success.'</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
        }
    }
}