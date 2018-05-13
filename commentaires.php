<?php
session_start();
include 'config/setup.php';

$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
$req->execute(array($_SESSION['login']));
$data = $req->fetch();
$uid = $data['id'];
$req->closeCursor();

if (isset($_POST['id']) && isset($_POST['comm']))
{
	$picId = $_POST['id'];
	$commentaire = $_POST['comm'];
	$sql = $bdd->prepare('INSERT INTO commentaires(picId, username, commentaire) VALUES (:picId, :username, :commentaire)');

		$sql->execute(array(
			'picId' => $picId,
			'username' => $_SESSION['login'],
			'commentaire' => $commentaire

 		));
}


?>