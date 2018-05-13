<?php
include 'config/setup.php';

if ($_POST['modifier'] == "Modifier")
{
	$newLogin = $_POST['login'];
	$newMail = $_POST['mail'];
	$newPass = hash("whirlpool", $_POST['pass']);
	$req = $bdd->prepare("UPDATE users SET username = ?, mail = ?, password = ? WHERE username = ?");
	$req->execute(array($newLogin, $newMail, $newPass, $_SESSION['login']));
	$_SESSION['login'] = $newLogin;
	$req->closeCursor();
	header('Location: http://localhost:8888/camagru/modifUser.php');
  	exit();	

}

?>