<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=db;charset=utf8', 'root', '');
    $db->exec("set names utf8");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Losqu'il y a une erreur, nous renvoyer une EXCEPTION (Par défaut PDO ne dit rien)
} catch (Exception $e) {
    die('Error : ' . $e->getMessage());
}
?>