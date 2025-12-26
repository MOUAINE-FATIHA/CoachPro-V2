<?php
class Utilisateur {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;

    public function __construct($nom, $prenom, $email, $password, $id=0){
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
    }
    public function getId(){ 
        return $this->id; 
    }
    public function getNom(){ 
        return $this->nom; 
    }
    public function getPrenom(){ 
        return $this->prenom; 
    }
    public function getEmail(){ 
        return $this->email; 
    }
    public function getPassword(){ 
        return $this->password; 
    }

    public function setNom($nom){ 
        $this->nom = $nom; 
    }
    public function setPrenom($prenom){ 
        $this->prenom = $prenom; 
    }
    public function setEmail($email){ 
        $this->email = $email; 
    }
    public function setPassword($password){ 
        $this->password = $password; 
    }

    public function __toString(){
        return "Utilisateur: {$this->nom} {$this->prenom}, Email: {$this->email}";
    }
}
?>

