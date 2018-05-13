<?php

$DB_DSN = "mysql:host=localhost";
$DB_USER = "root";
$DB_PASSWORD = "root";


try
{
	$bdd = new PDO("$DB_DSN", $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "CREATE DATABASE camagru";
	$bdd->exec($sql);
	echo "Database created successfully";
}

catch (Exception $e)
{
	echo $sql . "<br/>" . $e->getMessage();
}

?>