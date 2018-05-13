<?php
include 'config/setup.php';
include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Réinitialisation mot de passe</title>
	<style type="text/css">

	header
	{
		display: flex;
	}
	.header
	{
		border: 1px solid black;
		height: 150px;

	}
	#divTitle
	{
		width: 90%;
		text-align: center;
	}
	#user form
	{
		display: flex;
		flex-direction: column;
		margin: 50px;
		justify-content: center;
		align-items: center;
	}
	input
	{
		margin-bottom: 5px;
	}
	#lienPassOubli
	{
		font-size: 0.7em;
	}
	#newPass
	{
		margin-top: 25px;
		border: 1px solid black;
	}
	#form2
	{
		margin-left: 30px;
	}
	</style>
</head>
<body>

<div id="newPass">
	<p>Entrez votre mail pour recevoir un nouveau mot de passe</p>
	<form method="post" action="newPass.php" id="form2">
		<input type="text" id="newpass" name="newpass"></input>
		<input type="submit" value="Envoyer" name="envoyer"></input>
	</form>
</div>

</body>
</html>

<?php

if ($_POST['envoyer'] == "Envoyer")
{
	if ($_POST['newpass'] != "")
	{
		$req = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
		$req->execute(array($_POST['newpass']));
		if ($donnees = $req->fetch())
		{
			$newPassword = md5(microtime(TRUE)*100000);
			$destinataire = $donnees['mail'];
 			$sujet = "Réinitialiser le mot de passe";
 			$entete = "From: inscription@camagru.com";

 			//Le lien d'activation est composé de la clé et du login

 			$message = 'Voici votre nouveau mot de passe:'.$newPassword.' 

 			Pour activer votre nouveau mot de passe, veuillez cliquer sur le lien ci dessous
			ou copier/coller dans votre navigateur internet.

			http://localhost:8888/camagru/validationPass.php?pass='.urlencode($newPassword).'&mail='.urlencode($donnees['mail']).'


			---------------	
			Ceci est un mail automatique, Merci de ne pas y répondre.';

 			mail($destinataire, $sujet, $message);
 			echo "Un email avec votre nouveau mot de passe vient de vous etre envoyé";

		}
		else
			echo "Email incorrect ou inexistant";

	}
	else
		echo "Veuillez indiquer votre mail";
}


?>

















