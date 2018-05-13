<?php
session_start();
include 'config/setup.php';
include 'header.php';

$req = $bdd->prepare("SELECT * FROM users WHERE username = ?");
$req->execute(array($_SESSION['login']));
if ($donnees = $req->fetch())
{
	$login = $donnees['username'];
	$email = $donnees['mail'];
	$password = $donnees['password'];
}
$req->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Modifications utilisateur</title>
	<link rel="stylesheet" type="text/css" href="headerStyle.css">
</head>
<body>


<form method="post" action="modifUserCheck.php">
	<fieldset>
		<legend>Modifier mes informations</legend>
		<label for="login">Votre nom d'utilisateur:</label>
		<input type="text" name="login" id="login" value='<?php echo $login;?>'></input><br/>
		<label for="mail">Votre adresse mail: </label>
		<input type="text" name="mail" id="mail" value='<?php echo $email;?>'></input><br/>
		<label for="pass">Votre mot de passe: </label>
		<input type="text" name="pass" id="pass" value='<?php echo $password;?>'></input><br/>
		<input type="submit" value="Modifier" name="modifier" id="modifier"></input><span id="checkEmpty"></span>
	</fieldset>
</form>
<script type="text/javascript">
var sub = document.getElementById('modifier');
var login = document.getElementById('login');
var mail = document.getElementById('mail');
var pass = document.getElementById('pass');
sub.addEventListener("click", function(e) {
	var pass1 = document.getElementById("password1");
	var pass2 = document.getElementById("password2");
	if (login.value == "" || mail.value == "" || pass.value == "")
	{
		checkEmpty.textContent = "Un des champs est vide, veuillez le remplir";
		checkEmpty.style.color = 'red';
		e.preventDefault();
	}
});

</script>

</body>
</html>
<?php 

// if ($_POST['modifier'] == "Modifier")
// {
// 	$newLogin = $_POST['login'];
// 	$newMail = $_POST['mail'];
// 	$newPass = hash("whirlpool", $_POST['pass']);
// 	$req = $bdd->prepare("UPDATE users SET username = ?, mail = ?, password = ? WHERE username = ?");
// 	$req->execute(array($newLogin, $newMail, $newPass, $_SESSION['login']));
// 	$_SESSION['login'] = $newLogin;
// 	$req->closeCursor();
// 	header('Location: http://localhost:8888/camagru/headerStyle..php');
//   	exit();	

// }


?>



















