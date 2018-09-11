<?php
if(!empty($_POST['suppr_art'])){
	if(isset($_GET['id_billets']) == true){
			        	echo'<script>document.location.href=\''.$liens_internet.'/vue/admin/Launch_page.php?token='.$_GET['token'].'&id='.$_GET['id'].'\'</script>';
			        }else{
			        }
	//on include le chargement des classes
		include $liens_absolu.'/controleur/class/loadclass.php';
		//On initialise les variables que l'on va utiliser
			        $id = $_POST['id_art'];
			        $img_id = $_POST['img_id'];

			        //On les places dans un array
			        $content = array('id' => $id, 'img_id' => $img_id, 'liens_internet' => $liens_internet, 'liens_absolu' => $liens_absolu);
			        //Et on envoie tous la class GestPhoto
			        $GestArt = new GestArticle($content);

			        
}

