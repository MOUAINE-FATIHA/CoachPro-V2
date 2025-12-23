<?php
$user= 'root';
$pass='';

try{
    $db= new PDO('mysql:host=localhost; dbname=coachconnect;charset= utf8mb4', $user , $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
);
}catch(PDOException $e){
    die ("Erreur :" . $e->getMessage());
}