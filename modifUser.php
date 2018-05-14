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
  	height: 15%;
  	width: 25%;
  	margin: auto;
  	margin-top: 50px;
  	position: relative;
  	box-shadow: 3px 3px 3px;
  }
  #login
  {
  	margin-left: 60px;
  }
  #mail
  {
  	margin-left: 87px;
  }
  #pass
  {
  	margin-left: 85px;
  }
  #modifier
  {
  	float: right;
  	margin-right: 40px;
  }

	</style>
</head>
<body>


<form method="post" action="modifUserCheck.php" id="formUser">
		<label for="login">Votre nom d'utilisateur: </label>
		<input type="text" name="login" id="login" value='<?php echo $login;?>'></input><br/>
		<label for="mail">Votre adresse mail: </label>
		<input type="text" name="mail" id="mail" value='<?php echo $email;?>'></input><br/>
		<label for="pass">Votre mot de passe: </label>
		<input type="text" name="pass" id="pass" required=""></input><br/>
		<input type="submit" value="Modifier" name="modifier" id="modifier"></input><span id="checkEmpty"></span>
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
<?php
  include 'footer.php';
?>
</body>
</html>




















