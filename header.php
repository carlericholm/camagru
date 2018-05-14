<?php
session_start();
include 'config/setup.php';
?>
<header>
<div class="header" id="divTitle" style="border: none;">
	<h1 style="position: relative;"><a href="indexTemp.php" id="camagru">CAMAGRU</a></h1>
</div>
<div class="header" id="user" style="border: none;">
	<?php 

		if ($_SESSION['login'])
		{
			echo "<div style=\"margin-top: 50px;\"><span style=\"font-style: italic\">Bonjour " . $_SESSION['login'] . "</span><br/>";
			echo "<a href=\"destroy.php\" style=\"text-decoration: none; font-size: 0.8em;\">Se déconnecter</a><br/><div>";
		}
		else
		{
			echo '<form method="post" action="connUser.php">
					<input type="text" id="login" name="login" placeholder="login" required></input>
					<input type="password" id="pass" name="pass" placeholder="votre mot de passe" required></input>
					<input type="submit" value="Connexion" name="envoyer"></input>
					<a href="newPass.php" id="lienPassOubli">mot de passe oublié?</a>
					</form>';
		}

		
	?>
</div>
</header>

