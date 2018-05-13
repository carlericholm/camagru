<?php
session_start();
include 'config/setup.php';


if(isset($_POST['id']))
{
	$id = $_POST['id'];
	$sql = 'DELETE FROM pics WHERE id="' . $id . '"';
	$bdd->exec($sql);
}
else
	echo "Error";

?>