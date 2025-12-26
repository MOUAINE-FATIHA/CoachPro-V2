<?php
require_once 'Utilisateur.php';
class Sportif extends Utilisateur {
    public function __construct($nom, $prenom, $email, $password, $id=0){
        parent::__construct($nom, $prenom, $email, $password, $id);
    }
}
?>
