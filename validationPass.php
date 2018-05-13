<?php
session_start();
include 'config/setup.php';

// Récupération des variables nécessaires à l'activation

$pass = hash("whirlpool", $_GET['pass']);
$mail = $_GET['mail'];

// Récupération de la clé correspondant au $login dans la base de données

$req = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
$req->execute(array($mail));
if ($donnees = $req->fetch())
{
	$reqBis = $bdd->prepare("UPDATE users SET password = ? WHERE mail = ?");
	$reqBis->execute(array($pass, $mail));
	$reqBis->closeCursor();
	echo "Votre mot de passe a été mit a jour";
}
else
	echo "Error";

?>
<a href="indexTemp.php">Retour a l'acceuil</a>