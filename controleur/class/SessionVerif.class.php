<?php 

class SessionVerif{
    private $liens_internet;
    private $liens_absolu;
    public $id;
    public $nom;
    public $prenom;
    private $pass;
    private $actif;
    public $date_born;
    public $email;
    public $token;
    private $token_date;
    private $code_error;
    private $code_success;
    
    //on initialise les attributs par le array(email_pass) et si les test email et pass sont concluant on appel User() pour la recherhe dans la base de données, si non rien ne ce passe;
    public function __construct($email_pass){
        $this->email = $email_pass['email'];
        $this->pass = $email_pass['pass'];
        $this->liens_internet = $email_pass['liens_internet'];
        $this->liens_absolu = $email_pass['liens_absolu'];
        if($this->getEmail() == true && $this->getPass() == true){
            $this->User();
            return true;
        }else{
            return false;
        }
    }
    //recherche dans la bdd;
    private function User(){
        include $this->liens_absolu.'/modele/verifBdd.php';
    }

     //on hydrate les données avec les valeurs trouvé dans la bdd;
    private function hydrate($donnees){
        $this->id = htmlspecialchars($donnees['id']);
        $this->actif = htmlspecialchars($donnees['actif']);
        $this->nom = htmlspecialchars($donnees['nom']);
        $this->date_born = htmlspecialchars($donnees['date_born']);
        $this->email = htmlspecialchars($donnees['email']);
        $this->prenom = htmlspecialchars($donnees['prenom']);
        //si le compte est actif et que l'email et la date sont correctes on continue en démarrant la session si non rien ne ce passe
        if($this->getActif() && $this->getEmail() && $this->getDateborn() == true){   
            $this->begin_session();
        }else{
            return false;
        }
    }

    //verifie si le compte est activé;
    private function getActif(){
        if($this->actif == 1){
            return true;
        }else{
            $_SESSION['error'] = 'votre compte n\'est pas activé';
            header('refresh:0');
            return false;
        }
    }

    //démarre la session si compte et activé et transmet le token et l'id de l'utilisateur;
    private function begin_session(){
        if($this->actif == 1){
            $_SESSION['nom'] = $this->nom;
            $_SESSION['prenom'] = $this->prenom;
            $_SESSION['id'] = $this->id;
            $_SESSION['email'] = $this->email;
            $_SESSION['success'] = 'Vous êtes connecté !';
            header('location: vue/admin/Launch_page.php?token='.$_SESSION['token'].'&id='.$this->id.'');

        }else{
            return false;
        }
    }
    
    //verifie si le mot de passe continue au moins 8 caractère et pas plus de 15;
    public function getPass(){
        if(strlen($this->pass) >= 8 && strlen($this->pass) <=15){
            return true;
        }else{
            $_SESSION['error'] = 'Ce compte n\'existe pas';
            return false;
        }
    }
    
    //verifie que l'id est bien un entier;
    private function getId(){
        if(is_int($this->id)){
            return true;
        }else{
            return false; 
        }
    }
    
    //verifie que la date et bien une date;
    private function getDateborn(){
        setlocale(LC_TIME, 'fr_FR.utf8','fra');
        $date = strtotime($this->date_born);
        $date1 = strftime('%B', $date);
        $date2 = date('Y', $date);
        $date3 = date('d', $date);
        $_SESSION['date'] = $date3.' '.$date1.' '.$date2;
        return true;
    }
    
    //vérifie que l'email et bien un email;
    private function getEmail(){
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL) == true){
            return true;
        }else{
            $_SESSION['error'] = 'Un probleme avec l\'adresse email est survenue, contactez votre webmaster';
            header('refresh:0');
            return false;
        }
    }
    
    //verifie que le prenom et bien une chaine de caractère qu'elle est inférieure à 25 caractères et supérieure à 2 et qu'elle ne continuer pas de données interdite;
    private function getPrenom(){
        if(is_string($this->prenom) && strlen($this->prenom) < 25 && strlen($this->prenom) > 2 && preg_match('`^[[:alpha:]]+[ -]?[[:alpha:]]+$`', $this->prenom) == true){
            return true;
        }else{
            return false;
        }
    }
    
    //idem que pour le prenom;
    private function getNom(){
        if(is_string($this->nom) && strlen($this->nom) < 25 && strlen($this->nom) > 2 && preg_match('`^[[:alpha:]]+[ -]?[[:alpha:]]+$`', $this->nom) == true){
            return true;
        }else{
            return false;
        }
    }
    
    
}