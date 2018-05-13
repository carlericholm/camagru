<?php
session_start();
include 'indexTemp.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Creation utilisateur</title>
</head>
<body>
<form method="post" action="user.php">
	<fieldset><legend>S'inscrire</legend>
		<label for="prenom">Prenom: </label><input type="text" id="prenom" name="prenom" placeholder="votre prenom" required=""></input><br/><br/>
		<label for="nom">Nom: </label><input type="text" id="nom" name="nom" placeholder="votre nom" required=""></input><br/><br/>
		<label for="pseudo">Login: </label><input type="text" id="pseudo" name="pseudo" placeholder="votre pseudo" required=""></input><br/><br/>
		<label for="mail">Mail: </label><input type="mail" id="mail" name="mail" placeholder="votre mail" required=""></input><br/><br/>
		<label for="password">Password: </label><input type="password" id="password1" name="password" placeholder="votre mot de passe" required=""></input><br/><br/>
		<label for="passconfirm">PasswordConfirm: </label><input type="password" id="password2" name="passConfirm" placeholder="Confirmez votre pass" required=""></input><span id="checkPass"></span>
		<br/><br/>
		<input type="submit" value="Envoyer" name="envoyer" id="sub"></input>
	</fieldset>
</form>
<script type="text/javascript">
var bouton = document.getElementById("sub");
var checkPass = document.getElementById('checkPass');
sub.addEventListener("click", function(e) {
	var pass1 = document.getElementById("password1");
	var pass2 = document.getElementById("password2");
	if (pass1.value !== pass2.value)
	{
		checkPass.textContent = "Les mots de passe ne sont pas identiques";
		checkPass.style.color = 'red';
		e.preventDefault();
	}
});

</script>
</body>
</html>

<?php 

include 'config/setup.php';

if ($_POST['envoyer'] == "Envoyer")
{
	$req = $bdd->prepare('SELECT * FROM users WHERE username = ? OR mail = ?');
	$req->execute(array($_POST['pseudo'], $_POST['mail']));
	$donnees = $req->fetch();
	$check = 0;

	if ($donnees['username'] == $_POST['pseudo']) 
	{
		echo "Cet utilisateur existe deja";
		$check = 1;
	}
	if ($donnees['mail'] == $_POST['mail'])
	{
		echo "Cette adresse mail est déja utilisée";
		$check = 1;
	}

	$req->closeCursor();
}

if ($check == 0)
{
	$email = $_POST['mail'];
	$login = $_POST['pseudo'];
	$cle = md5(microtime(TRUE)*100000);

	$sql = $bdd->prepare('INSERT INTO users(firstname, lastname, username, mail, password, cle) VALUES (:firstname, :lastname, :username, :mail, :password, :cle)');

	$sql->execute(array(
		'firstname' => $_POST['prenom'],
		'lastname' => $_POST['nom'],
		'username' => $_POST['pseudo'],
		'mail' => $_POST['mail'],
		'password' => hash("whirlpool", $_POST['password']),
		'cle' => $cle
 	));
	echo "Utilisateur ajouté a la base de données";

 	//preparation du mail contenant le lien d'activation

 	$destinataire = $email;
 	$sujet = "Activer votre compte";
 	$entete = "From: inscription@camagru.com";

 	//Le lien d'activation est composé de la clé et du login

 	$message = 'Bienvenue sur camagru,

 	Pour activer votre compte, veuillez cliquer sur le lien ci dessous
	ou copier/coller dans votre navigateur internet.

	http://localhost:8888/camagru/validation.php?log='.urlencode($login).'&cle='.urlencode($cle).'


	---------------
	Ceci est un mail automatique, Merci de ne pas y répondre.';
 	var_dump(mail($destinataire, $sujet, $message));

}

?>

<a href="indexTemp.php">Réessayer</a>










