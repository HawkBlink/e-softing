<?php
	require_once 'controleur/liens.php';
?>
<!DOCTYPE php>
<html>
	<!-- Entête -->
	<head>
    	<meta charset="utf-8" lang="fr">
    	<meta name="viewport" content="width=device-width, initial-scale=1" shrink-to-fit="no"/>
			<title>E-softing</title>
			<meta name="description" content="praxis-sans-souci - trouver vous">
			<meta name="keywords" content="psychologie, psychopédagogie">
			<meta name="robots" content="index,follow">
				<link rel="shortcut icon" href="vue/css/img/logo2.png">
    			<link rel="stylesheet" href="vue/css/style_index.css">
    			<link rel="stylesheet" href="vue/css/style_footer.css">
    			<link rel="stylesheet" href="vue/css/style_menu.css"> 
				<link rel="stylesheet" href="vue/css/bootstrap/dist/css/bootstrap.min.css">
				<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
				<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
	</head>
		<!-- Corp de la page -->
  		<body>
  			<div class="container-fluid">
  				<div class="row">
		  			<?php include 'vue/include/menu/menu.php'; ?>
					<div class="content">

					</div>
				</div>
			</div>
      		<script src="vue/js/jquery-3.3.1.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
			<script src="vue/css/bootstrap/dist/js/bootstrap.min.js"></script>
			<script src="vue/js/jquery.paroller.min.js"></script>
			<script src="vue/js/scriptAddClassMenu.js"></script>
			<script src="vue/js/validcontact.js"></script>
			<script>
				$('.ancre').click(function() {
			    $('.ancre').removeClass('active');
			    $(this).addClass('active')
			});
			</script>
  		</body>
		<!-- fin Corp de la page -->
   

</html>