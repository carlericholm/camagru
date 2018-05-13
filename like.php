<?php
session_start();
include 'config/setup.php';

$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
$req->execute(array($_SESSION['login']));
$data = $req->fetch();
$uid = $data['id'];
$req->closeCursor();



$req = $bdd->prepare('SELECT * FROM likes WHERE uid = ? AND picId = ? ');
$req->execute(array($uid, $_POST['id']));
$donnes = $req->fetch();
if ($donnes['uid'] == $uid && $donnes['picId'] == $_POST['id'])
{
	$sql = 'DELETE FROM likes WHERE picId ="'. $_POST['id'].'" AND uid="' . $uid . '"';
	$bdd->exec($sql);
}
else
{
	if (isset($_POST['id']))
	{
	$picId = $_POST['id'];
	$sql = $bdd->prepare('INSERT INTO likes(picId, uid, likes) VALUES (:picId, :uid, :likes)');

		$sql->execute(array(
			'picId' => $picId,
			'uid' => $uid,
			'likes' => 1

 		));
	}
}
$req->closeCursor();





?>