<?php
include 'config/setup.php';
include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Réinitialisation mot de passe</title>
<link rel="stylesheet" type="text/css" href="headerStyle.css">
	<style type="text/css">
		  body
  {
    background-image: url(images/ocean.jpg);
  }
  #mainPage
  {
    display: flex;
    justify-content: space-around;
  }
  header
  {
    width: 80%;
    margin: auto;
    border-radius: 5px;
    box-shadow: 3px 3px 3px;
  }
  #camagru
  {
    text-decoration: none;
    color: black;
  }
  #camagru:hover
  {
    color: white;
  }
  #formUser
  {
  	height: 10%;
  	width: 27%;
  	margin: auto;
  	margin-top: 50px;
  	position: relative;
  	box-shadow: 3px 3px 3px;
  }

  #formUser input
  {
  	margin-top: 15px;
  	margin-left: 50px;
  }


	</style>
</head>
<body>

<div id="newPass">
	<form method="post" action="newPass.php" id="formUser">
	<label for="newpass">Entrez votre mail pour recevoir un nouveau mot de passe</label><br/>
		<input type="text" id="newpass" name="newpass"></input>
		<input type="submit" value="Envoyer" name="envoyer"></input>
	</form>
</div>
<?php
  include 'footer.php';
?>
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
 			echo "<span style=\"color: green;\">Un email avec votre nouveau mot de passe vient de vous etre envoyé<span>";

		}
		else
			echo "<span style=\"color: red; width: 50%; margin: auto;\">Email incorrect ou inexistant</span>";

	}
	else
		echo "<span style=\"color: red; width: 50%; margin: auto;\">Veuillez indiquer votre mail</span>";
}


?>

















