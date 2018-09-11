<?php
//Utiliser $this->code_erreur pour afficher les succès et les erreur
class GestPhoto{
    private $liens_internet;
    private $liens_absolu;
    private $nom; //Correspond au nom d'un fichier
    private $dossier; //Correspond au nom d'un dossier
    private $path; //Correspond au chemin d'un dossier
	private $maxsize; //Correspond la taille du fichier
    private $pathing; //Correspond au chemin avec le nom du dossier ajouté
    private $extensions_valides; //Correspond au extensions valides que l'on souhaite
    private $extension_upload; //Correspond à l'extension du fichier
    private $dossier_path; //Correspond au chemin d'un dossier
    private $namefile;
    protected $files_img; // Correspond au données du fichier
    protected $code_error; //Correspond à la valeur si il y a une erreur
    protected $code_success; // correspond à la valeur si il y a un succès
    protected $appel_get; // 1 : Si on veut ajouter une photo ; 2 si on veut créer un nouveau dossier; 3 Suppression d'un dossier ; 4 Suppression de fichier

	//---------------------------------------------------------------------On démarre ici------------------------------------------------------------------------ 
    //On envoi réceptionne les donnèes de l'array $content[]
    public function __construct($content){
    	//Si les données sont hydraté correctement on continu
        if($this->hydrate($content) == true){
            $this->appel_function();
            $this->SuccessError();
        }else{

        	//Si les données sont mal hydraté on retourne une erreur.
            $this->code_erreur = 'Une erreur est survenu veuillez réssayer';
        }
    }

    //Cette fonction fourni tous les objets avec les données reçus
    private function hydrate($content){
    	//on initialise les objets erreur est success avec null pour être sur quelle soit vide
        $this->liens_internet = $content['liens_internet'];
        $this->liens_absolu = $content['liens_absolu'];
        $this->code_error = null;
        $this->code_success = null;

        //On test les chaque donnèes possible à traité dans le tableau 
        if(isset($content['MAX_FILE_SIZE']) && isset($content['Fichier']) && isset($content['dossier'])){//DONNEES D'ENVOI DE FICHIER --------------DEBUT
            $this->maxsize = htmlspecialchars($content['MAX_FILE_SIZE']);
            $this->files_img = $content['Fichier'];
            $this->dossier_path = htmlspecialchars($content['dossier']);
            $this->extensions_valides = $content['extension'];
            $this->namefile = htmlspecialchars($content['namefile']);
            $this->appel_get = 1;//Appel_get vaut 1 pour appeler les fonctions nécessaire la gestion d'un fichier image
            return true;//DONNEES D'ENVOI DE FICHIER ------------------------------------------------------------------------------------------------FIN
        }elseif(isset($content['nom']) && isset($content['dossier_path'])){//DONNEES DE CREATION DE DOSSIER -----------------------------------------DEBUT
            $this->nom = $content['nom'];
            $this->dossier_path = $content['dossier_path'];
            $this->appel_get = 2; //Appel_get vaut 2 pour appeler les fonctions nécessaire à la création d'un dossier
            return true;//DONNEES DE CREATION DE DOSSIER ---------------------------------------------------------------------------------------------FIN
        }elseif(isset($content['dossier_path']) && isset($content['suppr_doss'])){
            $this->dossier_path = $content['dossier_path'];
            $this->dossier = $content['suppr_doss'];
            $this->appel_get = 3;
            return true;
        }elseif(isset($content['liens_img'])){
            $this->liens_img = $content['liens_img'];
            $this->appel_get = 4;
            return true;
        }else{
            return false;
        }
    }

    //Cette fonction permet d'appeler les différentes fonction elle ça valeur est donné par hydrate()
    private function appel_function(){
    	//Si appel_get vaut 1 alors on appel la fonction d'ajout de photo
        if($this->appel_get == 1 ){
            return $this->getAjoutPhoto();
        //Si non si elle vaut 2 on appel la fonction d'ajout d'un dossier 
        }elseif($this->appel_get == 2){
            return $this->getNouveauDossier();
        }elseif($this->appel_get == 3){
            return $this->getSuppressionDossier();
        }elseif($this->appel_get == 4){
            return $this->getSuppressionFichier();
        }
    }
//--------------------------------------------------------------------------------Ajout photo DEBUT------------------------------------------------------------------
    //Cette fonction gère l'ajout de photo 
    private function getAjoutPhoto(){

        $resultat = 0;
            //Si Le fichier ressort une erreur on stop tout
            if($this->files_img['error'] > 0){
                $this->code_error = "Erreur de réception du fichier : ".$this->files_img['error']."";
                return false;
            }else{
                //On test la taille du fichier
                 if($this->files_img['size'] > $this->maxsize){
                  $this->code_error = "Le fichier est trop lourd"; 
                  return false;
                }else{
                	if($this->SeparatedExtensionUpload() == true){
                        //Si l'extension n'est pas valide on stop tout
                        if (in_array($this->extension_upload, $this->extensions_valides) ){

                                $this->pathing = $this->liens_absolu.'/vue/albums/'. $this->dossier_path .'/'.$this->namefile.'.'.$this->extension_upload;

                                $resultat = move_uploaded_file($this->files_img['tmp_name'], $this->pathing);
                                    //Si tout c'est bien passé on passe au transfert
                                    if ($resultat){
                                        $this->code_success = "Transfert réussi";
                                        return true;

                                    }else{
                                        //Erreur lors du transfert veuillez réssayer
                                        $this->code_error = 'Erreur de transfert';
                                        return false;
                                    }
                            
                        }else{
                            //Ce type de fichier n\'est pas autorisé
                            $this->code_error = 'Type de fichier non reconnu';
                            return false;
                        }
                    }else{
                    	$this->code_error = 'Une erreur inattendu est survenue, veuillez réssayer ou contacter votre webmaster';
                        return false;
                    }
                }
            }
        }
//--------------------------------------------------------------------------------Ajout photo FIN------------------------------------------------------------------
//--------------------------------------------------------------------------------Nouveau dossier DEBUT------------------------------------------------------------------

    private function getNouveauDossier(){
       if($this->RetiredAccent() == true){
            if(is_dir($this->dossier_path)){

            var_dump($this->liens_internet);
                //si il existe déjà on récupére la variable et on réécrit le chemin avec le nom du dossier à créer
                $this->dossier_path = $this->liens_absolu.'/vue/albums/'.$this->nom.'';
            
                //on vérifie à nouveau si il existe
                if(is_dir($this->dossier_path)){
                    
                    //si il existe déjà "erreur"
                    $this->code_error = "Ce dossier existe déjà choisissez un autre nom";
                    header('location: '.$this->liens_internet.'/vue/admin/ajoutphoto/ajout_photo.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'&error='.$this->code_error.'');
                    return false;     
                }else{
                    mkdir($this->dossier_path, 0777, true);
                
                    //on réécrit le chemin du dossier à créer
                    $this->dossier_path = $this->liens_absolu.'/vue/albums/'.$this->nom.'/';
                    
                    //Le dossier à bien été créer un hydrate success    
                    $this->code_success = "Le dossier à bien été créé !";
                    header('location: '.$this->liens_internet.'/vue/admin/ajoutphoto/ajout_photo.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'&success='.$this->code_success.'');
                    return true;
                }
            }
        
        }
    }
//--------------------------------------------------------------------------------Nouveau Dossier FIN----------------------------------------------------------------------
//--------------------------------------------------------------------------------Suppresion d'un dossier DEBUT------------------------------------------------------------------
    private function getSuppressionDossier(){
        //on supprime le dossier et si tous ce passe bien  on initilise la variable success et on rafraichi la page en javascript
        if(@!rmdir($this->dossier_path)){
            $this->code_error = 'Le dossier n\'est pas vide, veuillez supprimer son contenu avant';
            header('location: '.$this->liens_internet.'/vue/admin/ajoutphoto/ajout_photo.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'&error='.$this->code_error.'');
            return false;
        }else{//sinon on initialise erreur
            $this->code_success = 'Le dossier à bien été supprimé !';
            header('location: '.$this->liens_internet.'/vue/admin/ajoutphoto/ajout_photo.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'&success='.$this->code_success.'');
            return true;  
        }
    }
//--------------------------------------------------------------------------------Suppresion d'un dossier FIN------------------------------------------------------------------
//--------------------------------------------------------------------------------Suppresion d'un Fichier DEBUT------------------------------------------------------------------
    private function getSuppressionFichier(){
            //On parcours la variable POST
            foreach($_POST as $key => $value){
                //Si la clé n'est pas "selection".
                if($key != 'selection'){
                    $value0 = str_replace('&', ' ', $key);//On remplace les & par des espaces
                    $value2 = str_replace('é', '.', $value0);//et on remplace les é par des points
                        //si le chemin dans la variable $value2 et valide
                        if(is_file($value2)){
                            //On supprime l'image
                            unlink($value2);
                                //et on incrémente la variable de session "success"
                            $this->code_success = 'La suppression des éléments à été effectué avec succès !';
                            header('location: '.$this->liens_internet.'/vue/admin/ajoutphoto/ajout_photo.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'&success='.$this->code_success.'');
                        }else{
                            //Si le chemin n'est pas valide on incrémente la variable de session "erreur"
                            $this->code_error = 'Les fichier que vous souhaitez supprimer n\'existes plus !';
                            header('location: '.$this->liens_internet.'/vue/admin/ajoutphoto/ajout_photo.php?token='.$_SESSION['token'].'&id='.$_SESSION['id'].'&error='.$this->code_error.'');
                        }
                }
            } 
        }
//--------------------------------------------------------------------------------Suppresion d'un Fichier FIN------------------------------------------------------------------
//--------------------------------------------------------------------------------FOONCTION ANNEXES DEBUT------------------------------------------------------------------
    //Cette fonction empêche les caractères spéciaux et non autorisé des noms de dossier choisi
    private function RetiredAccent(){
    	//Si le nom de dossier comporte autre chose que les caractère voulu
        if(!preg_match("#^[ a-z0-9A-Z_-]+$#", $this->nom)){
        	//On intialise code_error et on retourne FAUX
            $this->code_error = 'Votre nom de dossier ne peut contenir que des lettres minuscules, majuscules, des chiffres, des espaces et "_" et "-"';
            return false;
        }else{
        	//Si non on retourne vrai
            return true;
        }
    }

    //Cette fonction permet de séparer l'extension d'un fichier de ce nom
    private function SeparatedExtensionUpload(){
    	//Si l'extension à bien été retiré on retourne vrai
    	if($this->extension_upload = strtolower(substr(strrchr($this->files_img['name'],'.'),1))){
    		return true;
    	//Si non on retourne FAUX
    	}else{
    		return false;
    	}
    }

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
     
//--------------------------------------------------------------------------------FONCTION ANNEXES FIN------------------------------------------------------------------

}