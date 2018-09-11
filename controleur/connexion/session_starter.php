<?php
//Utiliser pour faire un retour en arrière sans tomber sur la page de traitement php;
session_cache_limiter('private_no_expire, must-revalidate');

//ouverture de la session;
session_start();
?>