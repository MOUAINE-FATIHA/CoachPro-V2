<?php
require_once 'Utilisateur.php';
class Coach extends Utilisateur{
    private $discipline;
    private $experience;
    private $description;

    public function __construct($email, $password , $discipline, $experience, $description= '', $id=0){
        parent::__construct($email , $password , $id);
        $this -> discipline= $discipline;
        $this -> experience =$experience;
        $this -> description = $description;
    }
    public function getDiscipline(){
        return $this->discipline; 
    }
    public function getExperience(){ 
        return $this->experience; 
    }
    public function getDescription(){ 
        return $this->description; 
    }

    public function setDiscipline($discipline){ 
        $this->discipline = $discipline; 
    }
    public function setExperience($experience){ 
        $this->experience = $experience; 
    }
    public function setDescription($description){ 
        $this->description = $description; 
    }

    public function __toString(){
        return parent::__toString() . " Discipline : " . $this->discipline . " Experience : " . $this->experience . " ans";
    }
}