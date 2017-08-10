<?php
session_start();
	include_once("../../connectFiles/connect_cis.php");
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
	<?php include("content/level-nav.php"); ?>
	<article>
		<?php include ("content/level-descriptors.php"); ?>
	</article>
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>
			<?php include("content/other.php"); ?>
	<a href="#top" id='scrolly'>&#x2B06;</a>
</body>
</html>
