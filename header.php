<?php
session_start();
include 'config/setup.php';
?>
<header>
<div class="header" id="divTitle">
	<h1><a href="indexTemp.php">camagru</a></h1>
</div>
<div class="header" id="user">
	<?php 

		if ($_SESSION['login'])
		{
			echo "Bonjour " . $_SESSION['login'];
			echo '<a href="destroy.php">Se déconnecter</a><br/>';
			echo '<a href="modifUser.php" id="modifUser">Modifier mes informations</a>';
		}
		else
		{
			echo '<form method="post" action="connUser.php">
					<input type="text" id="login" name="login" placeholder="login" required></input>
					<input type="password" id="pass" name="pass" placeholder="votre mot de passe" required></input>
					<input type="submit" value="Connexion" name="envoyer"></input>
					<a href="newPass.php" id="lienPassOubli">mot de passe oublié?</a>
					<a href="user.php">Creer son compte</a>
					</form>';
		}

		
	?>
</div>
</header>

