<?php 
//on inclut les class;
include $liens_absolu.'/controleur/class/loadclass.php';

if(!empty($_POST['change_info'])){
	if(!empty($_POST['nom2'])){
		$nom2 = str_replace(' ', '', htmlspecialchars($_POST['nom2']));
			$content = array('nom' => $nom2);
				$liens = array('liens_absolu' => $liens_absolu, 'liens_internet' => $liens_internet);


			$Create = new CreateChange($content, $liens);
	}

	if(!empty($_POST['prenom2'])){
		$prenom2 = str_replace(' ', '', htmlspecialchars($_POST['prenom2']));
			$content = array('prenom' => $prenom2);
				$liens = array('liens_absolu' => $liens_absolu, 'liens_internet' => $liens_internet);

			$Create = new CreateChange($content, $liens);

	}

	if(!empty($_POST['email2'])){
		$email2 = htmlspecialchars($_POST['email2']);
			$content = array('email2' => $email2);
				$liens = array('liens_absolu' => $liens_absolu, 'liens_internet' => $liens_internet);

			$Create = new CreateChange($content, $liens);
	}

	if(!empty($_POST['date_born2'])){
		$date_born2 = htmlspecialchars($_POST['date_born2']);
			$content = array('date_born2' => $date_born2);
				$liens = array('liens_absolu' => $liens_absolu, 'liens_internet' => $liens_internet);

			$Create = new CreateChange($content, $liens);
	}  
}


			