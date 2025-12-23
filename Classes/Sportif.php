<?php
require_once 'Utilisateur.php';
class Sportif extends Utilisateur
{

    public function __construct($email, $password, $id = 0){
        parent::__construct($email, $password, $id);
    }
}