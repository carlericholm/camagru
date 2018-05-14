<?php
session_start();
include 'config/setup.php';

$file = $_FILES['file']['tmp_name'];

if (empty($file))
{
	header('Location: http://localhost:8888/camagru/indexTemp.php');
}

if (isset($_POST['upload']))
{
	if (isset($_POST['pic']))
	{
		$temp = $_FILES['file']['type'];
		$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
		$req->execute(array($_SESSION['login']));
		$donnees = $req->fetch();
		$user_id = $donnees['id'];
		$req->closeCursor();
		if ($temp == 'image/png')
		{
			if (move_uploaded_file($file, "temp.png") == true)
			{

				$image1 = imagecreatetruecolor(640, 480);
				$temp = imagecreatefrompng('temp.png');
				$width = imagesx($temp);
				$height = imagesy($temp);
   				imagecopyresampled($image1, $temp, 0, 0, 0, 0, 640, 480, $width, $height);
   				file_put_contents("essai.png", $image1);
   				if ($_POST['pic'] == 'pic1')
   					$src = 'images/lunettes.png';
   				if ($_POST['pic'] == 'pic2')
   					$src = 'images/chapeau.png';
   				if ($_POST['pic'] == 'pic3')
   					$src = 'images/moustache.png';
				if ($_POST['pic'] == 'pic1')
				{
					$image2 = imagecreatefrompng($src);
					imagecopy($image1, $image2, 250, 200, 0, 0, 100, 67);
				}
				if ($_POST['pic'] == 'pic2')
				{
					$image2 = imagecreatefrompng($src);
					imagecopy($image1, $image2, 200, 200, 0, 0, 100, 100);
				}
				if ($_POST['pic'] == 'pic3')
				{
					$image2 = imagecreatefrompng($src);
					imagecopy($image1, $image2, 200, 200, 0, 0, 100, 49);
				}
				$req = $bdd->query('SELECT * FROM pics ORDER BY id DESC');
				$donnees = $req->fetch();
				$id = $donnees['id'] + 1;
				$adress = 'photos/' . $id . '.png';
				imagepng($image1, $adress);
				$req->closeCursor();
				$sql = $bdd->prepare('INSERT INTO pics(uid, src) VALUES (:uid, :src)');
				$sql->execute(array(
				'uid' => $user_id,
				'src' => $adress
 				));

				header('Location: http://localhost:8888/camagru/webcam.php');
			}
		}
		else
		{
			echo "Il faut un format png";
		}


	}
	else
		echo "Il faut preciser un fichier a superposer";
	
}

?>