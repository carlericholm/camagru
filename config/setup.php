<?php
session_start();
$DB_DSN = "mysql:host=localhost";
$DB_USER = "root";
$DB_PASSWORD = "root";

try {

	$bdd = new PDO("$DB_DSN;dbname=camagru", $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "CREATE TABLE IF NOT EXISTS users(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    mail VARCHAR(50),
    password VARCHAR(255),
    cle VARCHAR(32),
    active INT DEFAULT 0
    )";

    $bdd->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS pics(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uid INT(6) UNSIGNED NOT NULL,
    src LONGTEXT,
    crea_date TIMESTAMP
    )";

    $bdd->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS commentaires(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    picId INT(6) UNSIGNED NOT NULL,
    username VARCHAR(30) NOT NULL,
    commentaire LONGTEXT
    )";

    $bdd->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS likes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    picId INT(6) UNSIGNED NOT NULL,
    uid INT(6) UNSIGNED NOT NULL,
    likes INT(6) UNSIGNED NOT NULL
    )";

    $bdd->exec($sql);
}

catch (Exception $e)
{
	echo "Erreur: " . $e->getMessage() . "C'est raté";
}


?>