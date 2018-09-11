<?php
//Si la variable $list_doss n'est pas vide
if(!empty($list_doss)){
//On créer un select
?>
	<select class="selectDoss form-control" name="upload">
	<?php
		//On parcours $list_doss et on place le contenu dans $value	($value vos le nom du dossier) et on place $value dans l'option du select			
	  	foreach ($list_doss as $value) {
	  		echo '<option>'.$value.'</option>';
		}
	?>	
	</select>
	<?php

}else{
		//Si la variable est vide c'est qu'il n'y aucun dossier dans ce cas on affiche une erreur.
		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		  <strong>Vous n\'avez aucun dossier</strong></div>';
		
	}

?>
