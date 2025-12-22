<?php

$user= 'root';
$pass='';

try{
    $db= new PDO('mysql:host=localhost; dbname=coachconnect', $user , $pass);
    echo 'connexion réussite' . "<br/>";
    foreach($db -> query('SELECT * FROM users') as $row){
        print_r($row);
    }
}catch(PDOException $e)
{
    print "Erreur :" . $e->getMessage() . "<br/>";
    die;
}