<?php

// Déclaration de la session 
session_start();

// Connexion à la BDD 
try {

    $sgbd = "mysql";
    $host = "localhost";
    $dbname = "doranco_agenceloc";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $bdd = new PDO("$sgbd:host=$host;dbname=$dbname", $username, $password, $options);

} catch (Exception $e) {
    die("ERREUR CONNECTION BDD : " . $e->getMessage());
}

// Définition des constantes d'URL et de RACINE_SITE
define("RACINE_SITE", str_replace("\\", "/", str_replace("inc", "", __DIR__)));
define("URL", "http://$_SERVER[HTTP_HOST]" . str_replace($_SERVER['DOCUMENT_ROOT'], "", RACINE_SITE ));

// Require du fichier functions.php
require_once RACINE_SITE . "inc/functions.php";



