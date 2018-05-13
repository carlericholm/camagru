<?php
session_start();
include 'config/setup.php';

// Récupération des variables nécessaires à l'activation

$login = $_GET['log'];
$cle = $_GET['cle'];

// Récupération de la clé correspondant au $login dans la base de données

$req = $bdd->prepare("SELECT cle, active FROM users WHERE username = ?");
$req->execute(array($login));
if ($donnees = $req->fetch())
{
	$clebdd = $donnees['cle'];   //Recuperation de la clé
	$actif = $donnees['active']; //$actif contient 0 ou 1
}
$req->closeCursor();
// On teste la valeur de la variable $actif récupéré dans la BDD

if ($actif == 1) // Si le compte est déjà actif on prévient
{
	echo "Votre compte est déja actif !";
}
else // Si ce n'est pas le cas on passe aux comparaisons
{
	if ($cle == $clebdd) // On compare nos deux clés
	{
		// Si elles correspondent on active le compte !
		echo "Votre compte a bien été activé";

		// La requête qui va passer notre champ actif de 0 à 1

		$reqBis = $bdd->prepare("UPDATE users SET active=1 WHERE username = ?");
		$reqBis->execute(array($login));
		$req->closeCursor();
		$_SESSION['login'] = $login;
	}
	else // Si les deux clés sont différentes on provoque une erreur...
	{
		echo "Votre compte ne peut pas etre activé...";
	}

}
?>
<a href="indexTemp.php">Retour a l'acceuil</a>