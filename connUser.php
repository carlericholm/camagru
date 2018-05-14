<?php
include 'config/setup.php';

if (isset($_POST['login']) && isset($_POST['pass']) && $_POST['login'] !== "" && $_POST['pass'] !== "")
		{
				$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
				$req->execute(array($_POST['login']));
				$donnees = $req->fetch();
					if ($donnees['username'] === $_POST['login'] && hash("whirlpool", $_POST['pass']) == $donnees['password'])
					{
						if ($donnees['active'] == 1)
						{
							$_SESSION['login'] = $_POST['login'];
							header('Location: http://localhost:8888/camagru/indexTemp.php');
  								exit();
						}
						else
						{
							header('Location: http://localhost:8888/camagru/indexTemp.php');
  								exit();
						}
					}
					else
					{
						header('Location: http://localhost:8888/camagru/indexTemp.php');
  								exit();
					}
					$req->closeCursor();
		}

?>