<?php
require_once 'Utilisateur.php';

class Coach extends Utilisateur {
    private $discipline;
    private $annees_exp;
    private $description;

    public function __construct($nom, $prenom, $email, $password, $discipline, $annees_exp, $description='', $id=0){
        parent::__construct($nom, $prenom, $email, $password, $id);
        $this->discipline = $discipline;
        $this->annees_exp = $annees_exp;
        $this->description = $description;
    }
    public function getDiscipline(){ 
        return $this->discipline; 
    }
    public function getAnneesExp(){ 
        return $this->annees_exp; 
    }
    public function getDescription(){ 
        return $this->description; 
    }

    public function setDiscipline($discipline){ 
        $this->discipline = $discipline; 
    }
    public function setAnneesExp($annees_exp){ 
        $this->annees_exp = $annees_exp; 
    }
    public function setDescription($description){ 
        $this->description = $description; 
    }

    public function __toString(){
        return parent::__toString() . " discipline: {$this->discipline}, expérience: {$this->annees_exp} ans";
    }
}
?>
