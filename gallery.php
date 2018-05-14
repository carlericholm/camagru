<?php
session_start();
include 'config/setup.php';
$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
$req->execute(array($_SESSION['login']));
$data = $req->fetch();
$uidUser = $data['id'];
$req->closeCursor();

$req = $bdd->prepare('SELECT * FROM pics');
$req->execute();
$count = 0;
while($data = $req->fetch())
{
	$count++;
	$lastId = $data['id'];
}

$total = $count;
$count = ceil($count / 6);
$req->closeCursor();

$min = 0;
$max = $min + 6;

if (isset($_POST['aller']) && isset($_POST['page']))
{
	$page = $_POST['page'];
	$min = ($page * 6) - 6;
	$max = $min + 6;
}

$req = $bdd->prepare('SELECT * FROM pics ORDER BY id DESC');
$req->execute();



$i = 0;
echo "<div id=\"containerImg\">";
while($donnees = $req->fetch())
{
	if ($i >= $min && $i < $max)
	{
		$src = $donnees['src'];
    	$id = $donnees['id'];
    	$uid = $donnees['uid'];

    	$reqBis = $bdd->prepare('SELECT * FROM users WHERE id = ?');
		$reqBis->execute(array($uid));
		$data = $reqBis->fetch();
		$login = $data['username'];
		$idUtilisateur = $data['id'];
		$reqBis->closeCursor();


		$reqBis = $bdd->prepare('SELECT * FROM likes WHERE uid = ? AND picId = ? ');
		$reqBis->execute(array($uidUser, $id));
		$dataBis = $reqBis->fetch();
		if ($dataBis['likes'] == 1)
		{
			$likeSrc = 'images/vgreen.png';
		}
		else
		{
			$likeSrc = 'images/vblue.png';
		}
		$reqBis->closeCursor();
		$reqBis = $bdd->prepare('SELECT * FROM likes WHERE picId = ? ');
		$reqBis->execute(array($id));
		$nbr = 0;
		while ($dataBis = $reqBis->fetch())
		{
			$nbr++;
		}


		if (!empty($_SESSION['login']))
		{
		echo "<div id=\"imgComm\"><p style=\"font-style: italic;\">Montage réalisé par " . $login . "</p><img src=". $src . " style=\"margin: 10px; width: 300px\" id=" . $id. "></img><div class=\"commentaire\">
		<textarea cols=\"45\" placeholder=\"Votre commentaire...\" id=\"textComm\"></textarea><img id=" . $id . " class=\"like\" src=" . $likeSrc ." style=\"width: 20px; height: 20px; position: relative; bottom: 5px; left: 5px;\"><span>".$nbr."</span><br/>
		<button id=" . $id . " class=\"commButton\" name=\"commenter\">Commenter</button><br/><br/><div class=\"coms\">";
		$reqBis = $bdd->prepare('SELECT * FROM commentaires WHERE picId = ? ORDER BY id DESC');
		$reqBis->execute(array($id));
		while ($dataBis = $reqBis->fetch())
		{
			$username = $dataBis['username'];
			echo  "<span style=\"font-weight: bold;\">" . $username . ": </span>" . $dataBis['commentaire'] . "<br/><br/>";
		}
		$reqBis->closeCursor();
		echo "</div></div></div>";
		}
		else
		{
			echo "<div id=\"imgComm\"><p style=\"font-style: italic;\">Montage réalisé par " . $login . "</p><img src=". $src . " style=\"margin: 10px; width: 300px\" id=" . $id. "></img></div>";
		}
	}
	$i++;
}
echo "</div>";
$req->closeCursor();
?>
<br/><br/>
<form method="post" action="indexTemp.php">
	<select name="page" id="page">
		<?php 
		$i = 1;
			while ($i <= $count) 
			{
				if ($_POST['page'] == $i)
					echo "<option value='$i' selected=\"selected\">$i</option>";
				else
					echo "<option value='$i'>$i</option>";
				$i++;	
			}
		?>
	</select>
	<input type="submit" value="Aller" name="aller"></input>
</form>



<script type="text/javascript">

function addLike(id) {
    var newXhttp = new XMLHttpRequest();
    newXhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           console.log(this.responseText);
       }
    };
    newXhttp.open("POST", "like.php", true);
    newXhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    newXhttp.send("id=" + id);

    window.location = document.location;
}


var like = document.getElementsByClassName("like");
for(var i = 0, length = like.length; i < length; i++) {
       like[i].addEventListener("click", function(e) {

       	addLike(e.target.id);

       })
    }

function addComm(id, comm) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           console.log(this.responseText);
       }
    };
    xhttp.open("POST", "commentaires.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + "&comm=" + comm);

    window.location = document.location;
}




var commenter = document.getElementsByClassName("commButton");
for(var i = 0, length = like.length; i < length; i++) {
       commenter[i].addEventListener("click", function(e) {
       	var texte = e.target.parentNode.childNodes[1].value;
       	addComm(e.target.id, texte);
       
       })
    }





</script>









