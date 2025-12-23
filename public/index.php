<?php
require_once '../classes/Utilisateur.php';
// instanciation
$user = new Utilisateur('a@gmail.com' , 'aaa');
$user2 = new Utilisateur('BB@gmail.com' , 'BBB');
var_dump($user,$user2);
?>