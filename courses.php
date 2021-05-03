<?php
$local = $_SERVER['REMOTE_ADDR']=='127.0.0.1' ? 1 : 0;
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$refer_url = str_replace("localhost","elctools",$actual_link);
header('Location: '.$refer_url);
exit();
?>
session_start();
	include_once("../../connectFiles/connect_cis.php");
	include_once("cas-go.php");
	include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="">
<head>
	<title>Curriculum Portfolio - English Language Center</title>

<!-- 	Meta Information -->
	<meta charset="utf-8">
	<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
	<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("content/styles_and_scripts.html"); ?>
</head>
<body>
	<header>
		<?php include("content/header.php"); ?>
	</header>
	<nav>
		<?php include("content/nav-bar.php"); ?>
	</nav>

	<article>

		<?php include ("content/course-list.php"); ?>

	</article>
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>


</body>
</html>
