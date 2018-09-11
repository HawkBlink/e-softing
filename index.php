<?php
 
	require_once 'controleur/liens.php';
	include "controleur/script/redirect_url.php";

?>
<!DOCTYPE php>
<html>
	<!-- Entête -->
	<head>
    	<meta charset="utf-8" lang="fr">
    	<meta name="viewport" content="width=device-width, initial-scale=1" shrink-to-fit="no"/>
			<title>Vous êtes ?</title>
			<meta name="description" content="praxis-sans-souci - trouver vous">
			<meta name="keywords" content="psychologie, psychopédagogie">
			<meta name="robots" content="index,follow">
				<link rel="shortcut icon" href="vue/css/img/logo.png">
    			<link rel="stylesheet" href="vue\css\style_index.css">
				<link rel="stylesheet" href="vue\css\bootstrap\dist\css\bootstrap.min.css">
	</head>
		<!-- Corp de la page -->
  		<body>
        	<div class="container-fluid" id="background">
	          <div class="row justify-content-md-center justify-content-sm-center justify-content-lg-center">
	            <div class="col-sm-6 col-md-4 col-lg-4" id="whois">
					<h3>Vous êtes ?</h3><br />
	              	<form method="POST" action="#">
	                  <select name="choix" class="form-control">
	                    <option value="parents">Parents et enfants</option>
	                    <option value="adulte">Un Adulte</option>
	                    <option value="etudiant">Un Etudiant</option>
	                    <option value="entreprise">Une Entreprise</option>
	                    <option value="association">Une Association</option>
	                  </select>
	                  <hr>
	                  <input type="submit" value="Aller" class="btn btn-primary float-left"/>
	                  <a <?php echo 'href="'.$liens_internet.'/connexion.php"' ?> class="btn btn-primary float-right">Connexion</a>
	                </form>
	            </div>
	          </div>
      		</div>
  		</body>
		<!-- fin Corp de la page -->
			<!-- Pied de page -->
			<!-- Pied de page -->      
<script src="vue\js\jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="vue\css\bootstrap\dist\js\bootstrap.min.js"></script>
</html>