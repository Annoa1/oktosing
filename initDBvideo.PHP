<?php
include 'include/db.php';
include 'class/VideoManager.class.php';
// $id=$_GET['id'];
$titre=$_GET['titre'];
$year=$_GET['annee'];

$db = db_connexion();
$videoManager = new VideoManager($db);
$newvideo= new Video();
$new = $videoManager->update($newvideo);



?>

<<html>
<head>
	<title></title>
</head>
<body>

<<p> Video mis à jour avec succés 

	<<a href="admin-video.php">Retourner à l'administration des vidéos</a>
</p>

</body>
</html>