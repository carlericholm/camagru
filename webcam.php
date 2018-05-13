<?php
session_start();
?>
<!-- <video id="video"></video> -->

<!-- <canvas id="canvas"></canvas> -->
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
    margin-top: 25px;
  }
  #menu div a
  {
    font-size: 1.3em;
  }
  #gallery
  {
    margin-top: 25px;
    border: 1px solid green;
    text-align: center;
  }
</style>
</head>
<body>
<?php include 'header.php'; ?>
<div id="mainPage">
	<div id="camera">
	<div id="videoImg">
		<video id="video"></video>
		<img src="images/lunettes.png" id="imgGlasses" style="position: relative; bottom: 193px; left: 117px;display: none;">
		<img src="images/chapeau.png" id="imgHat" style="position: relative; bottom: 253px; left: 117px;display: none;">
		<img src="images/moustache.png" id="imgMoustache" style="position: relative; bottom: 143px; left: 117px; display: none;">
	</div>
		<canvas id="canvas"></canvas><br/>
		<input type="hidden" name="invisible" id="invisible"></input>
		<!-- <button id="startbutton">Prendre une photo</button> -->
		<form method="post" action="upload.php" enctype="multipart/form-data">
			<div id="imgSuper">
				<input type="radio" name="pic" value="pic1" id="lunettes" class="bubble"></input>
				<label for="lunettes"><img src="images/lunettes.png" class="picResize" id="lunettesImg"><br/></label>

				<input type="radio" name="pic" value="pic2" id="chapeau" class="bubble"></input>
				<label for="chapeau"><img src="images/chapeau.png" class="picResize" id="chapeauImg"><br/></label>
				
				<input type="radio" name="pic" value="pic3" id="moustache" class="bubble"></input>
				<label for="moustache"><img src="images/moustache.png" class="picResize" id="moustacheImg"><br/></label>

        <input type="file" name="file" id="file"></input>
        <input type="submit" name="upload" value="Uploader la photo"></input><br/><br/>
				
				<button id="startbutton">Prendre une photo</button>
			</div>
		</form>
	</div>
	<div id="aside">
	<?php
		$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
		$req->execute(array($_SESSION['login']));
		$donnees = $req->fetch();
		$user_id = $donnees['id'];
		$req->closeCursor();
		$req = $bdd->prepare('SELECT * FROM pics WHERE uid=? ORDER BY crea_date DESC LIMIT 5');
		$req->execute(array($user_id));
		while($donnees = $req->fetch())
		{
			$src = $donnees['src'];
      $id = $donnees['id'];
			echo "<div id=\"newImage\" style=\"position: relative\"><img src=". $src . " style=\"width: 200px;\" id=" . $id. "></img></div>";
			?>

			<?php
		}

	?>
	</div>
</div>
</body>
</html>

<script type="text/javascript">


(function() {
	var divImg = document.getElementById('aside');
	var invisible = document.getElementById('invisible');
	var errorPng = document.createElement('p');
	errorPng.textContent = "Veuillez choisir un filtre";
	errorPng.style.color = 'red';
	document.getElementById('imgSuper').appendChild(errorPng);
	errorPng.style.display = 'none';


var newImage = document.getElementById("newImage");
var  aside = document.getElementById("aside");
aside.addEventListener("mouseover", function(e) {
    e.target.style.opacity = '0.5';
});

aside.addEventListener("mouseout", function(e) {
      e.target.style.opacity = "1";
      // deleteText.style.display = "none";
})


function deletePic(id) {
    var newXhttp = new XMLHttpRequest();
    newXhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           console.log(this.responseText);
       }
    };
    newXhttp.open("POST", "delete.php", true);
    newXhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    newXhttp.send("id=" + id);

    window.location = document.location;
}

aside.addEventListener("click", function(e) {
  var id = e.target.id;
  deletePic(id);
  e.preventDefault();
});



var glass = document.getElementById('lunettes');
var hat = document.getElementById('chapeau');
var moust = document.getElementById('moustache');
glass.style.display = "none";
hat.style.display = "none";
moust.style.display = "none";

var imgGlasses = document.getElementById('imgGlasses');
var imgHat = document.getElementById('imgHat');
var imgMoustache = document.getElementById('imgMoustache');

var lunettes = document.getElementById('lunettesImg');
var chapeau = document.getElementById('chapeauImg');
var moustache = document.getElementById('moustacheImg');

lunettes.addEventListener("click" ,function() {
  imgGlasses.style.display = "block";
  imgHat.style.display = "none";
  imgMoustache.style.display = "none";
})

chapeau.addEventListener("click" ,function() {
  imgHat.style.display = "block";
  imgGlasses.style.display = "none";
  imgMoustache.style.display = "none";
})


moustache.addEventListener("click" ,function() {
  imgMoustache.style.display = "block";
  imgGlasses.style.display = "none";
  imgHat.style.display = "none";
})

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 320,
      height = 200;
  	canvas.style.display = "none";

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
    	console.log(video.videoWidth);
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    canvas.style.display = 'none';
    var data = canvas.toDataURL('image/png');
    invisible.value = data;
  }


  	function loadDoc(str) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
           console.log(this.responseText);
       }
    };
    var pic1 = document.getElementById('lunettes');
    var pic2 = document.getElementById('chapeau');
    var pic3 = document.getElementById('moustache');
    var srcPng = 'none';
    

    if (pic1.checked == true)
    	srcPng = "images/lunettes.png";
    else if (pic2.checked == true)
    	srcPng = "images/chapeau.png";
    else if (pic3.checked == true)
    	srcPng = "images/moustache.png";
    xhttp.open("POST", "montage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("fname=" + encodeURIComponent(str) + "&srcPng=" + encodeURIComponent(srcPng));
	if (srcPng == 'none')
		errorPng.style.display = 'block';
	else
		window.location = document.location;
}

  startbutton.addEventListener('click', function(ev){
    takepicture();
    loadDoc(invisible.value);
    ev.preventDefault();
  }, false);

})();

</script>



