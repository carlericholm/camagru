<?php
session_start();
include 'config/setup.php';

if ($_POST['srcPng'] != 'none')
{
	$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
	$req->execute(array($_SESSION['login']));
	$donnees = $req->fetch();
	$user_id = $donnees['id'];
	$req->closeCursor();

	$src = explode(",", $_POST['fname'], 2)[1];
	$src = base64_decode($src);
	

	if (file_put_contents("temp.png", $src) == true)
	{
		$image1 = imagecreatefrompng('temp.png');
		
		if ($_POST['srcPng'] == 'images/lunettes.png')
		{
			$image2 = imagecreatefrompng('images/lunettes.png');
			imagecopy($image1, $image2, 115, 50, 0, 0, 100, 67);
		}
		if ($_POST['srcPng'] == 'images/moustache.png')
		{
			$image2 = imagecreatefrompng('images/moustache.png');
			imagecopy($image1, $image2, 115, 100, 0, 0, 100, 49);
		}
		if ($_POST['srcPng'] == 'images/chapeau.png')
		{
			$image2 = imagecreatefrompng('images/chapeau.png');
			imagecopy($image1, $image2, 115, -10, 0, 0, 100, 100);
		}
		$req = $bdd->query('SELECT * FROM pics ORDER BY id DESC');
		$donnees = $req->fetch();
		$id = $donnees['id'] + 1;
		$req->closeCursor();
		$adress = 'photos/' . $id . '.png';
		imagepng($image1, $adress);

	}

	$sql = $bdd->prepare('INSERT INTO pics(uid, src) VALUES (:uid, :src)');

		$sql->execute(array(
			'uid' => $user_id,
			'src' => $adress

 		));
}
?>