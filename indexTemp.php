<?php
session_start();
include 'config/setup.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="headerStyle.css">
	<style type="text/css">
	body
	{
		background-image: url(images/ocean.jpg);
		background-attachment: fixed;
	}
	header
	{
		width: 80%;
		margin: auto;
		border-radius: 5px;
		box-shadow: 2px 2px 2px;
	}
	#mainPage
	{
		display: flex;
		justify-content: space-around;
	}
	#camera
	{
		border: 2px solid red;
	}
	#aside
	{
		border: 3px solid black;

	}
	.picResize
	{
		width: 100px;
		height: 100px;
	}
	#menu
	{
		border: 1px solid black;
		height: 100px;
		display: flex;
		justify-content: space-around;
		margin: auto;
		margin-top: 25px;
		align-items: center;
		border-radius: 5px;
		box-shadow: 2px 2px 2px;
		width: 80%;

	}
	#menu div a
	{
		font-size: 1.3em;
		text-decoration: none;
		color: black;

	}
	#menu div a:hover
	{
		color: blue;
	}
	#gallery
	{
		margin: auto;
		margin-top: 25px;
		border: 1px solid green;
		text-align: center;
		width: 80%;
	}

	#containerImg
	{
		display: flex;
		flex-wrap: wrap;
		justify-content: space-around;
		border: 3px solid red;
		margin: auto;
	}

	#imgComm
	{
		border: 2px solid orange;
		margin: auto;
	}
/*	.commentaire
	{
		height: 300px;
		border: 3px solid blue;
		overflow: auto;
		word-wrap: break-word;

	}*/
	#textComm
	{
		border-radius: 5px;
		box-shadow: 2px 2px 2px;
		border-style: none;
	}

	.coms
	{
		border: 1px solid pink;
		text-align: left;
		overflow: scroll;
		height: 150px;
		width: 325px;
		margin-left: 15px;
		word-wrap: break-word;
	}




</style>
</head>
<body>

<?php 
	include 'header.php';
	
?>
		<div id="menu">
			<div><a href="webcam.php">Montage</a><br/></div>
			<div><a href="#">Mon compte</a></div>
		</div>
		<div id="gallery">	
			<!-- <h1>Bienvenue sur la gallerie</h1> -->
<?php
	 		include 'gallery.php';
?>
		</div>

</body>
</html>


















