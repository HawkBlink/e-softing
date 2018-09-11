<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['nom'])){
	if(isset($_POST['prenom'])){
		if(isset($_POST['email'])){
			if(isset($_POST['content'])){
				if(isset($_POST['objet'])){
					$nom = preg_replace('@<script[^>]*?>.*?</script>@si', '', strip_tags($_POST['nom']));
					$prenom = preg_replace('@<script[^>]*?>.*?</script>@si', '', strip_tags($_POST['prenom']));
					$email = preg_replace('@<script[^>]*?>.*?</script>@si', '', strip_tags($_POST['email']));
					$objet = preg_replace('@<script[^>]*?>.*?</script>@si', '', strip_tags($_POST['objet']));
					$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', strip_tags($_POST['content']));
					$type = preg_replace('@<script[^>]*?>.*?</script>@si', '', strip_tags($_POST['type']));
					$typemin = strtolower($type);
					$success = 0;

						//Load composer's autoloader
						require $liens_absolu.'/controleur/vendor/autoload.php';

						$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
						try {
						    //Server settings
						    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
						    $mail->isSMTP();                                      // Set mailer to use SMTP
						    $mail->Host = 'mx1.hostinger.fr';  					  // Specify main and backup SMTP servers
						    $mail->SMTPAuth = true;                               // Enable SMTP authentication
						    $mail->Username = 'contact@praxis-sans-souci.com';    // SMTP username
						    $mail->Password = 'Conc57@lo';                        // SMTP password
						    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
						    $mail->Port = 587;                                    // TCP port to connect to

						    //Recipients
						    $mail->setFrom('contact@praxis-sans-souci.com', '');
							$mail->addAddress('contact@praxis-sans-souci.com', '');

						    //Content
						    $mail->isHTML(true);                                  // Set email format to HTML
						    $mail->CharSet = 'UTF-8';
						    $mail->Subject = $objet;
						    $mail->Body    = 'Vous avez reçus cette email de '.$nom.' '.$prenom.'<br /> Son adresse email est : '.$email.'<br /><br />Et voici le contenu de son message :<br /><br /><br />'.$text;
						    $mail->send();
						   	$success = 'Le message à bien été envoyé';
						   	echo '<script>document.location.href=\''.$liens_internet.'/vue/'.$typemin.'.php?type='.$type.'&success='.$success.'\'</script>';
						} catch (Exception $e) {
						    $success = 'Le message n\'a pas été reçus';
						    echo '<script>document.location.href=\''.$liens_internet.'/vue/'.$typemin.'.php?type='.$type.'&success='.$success.'\'</script>';
						}

				}
			}

		}
	}

}