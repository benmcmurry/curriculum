<?php

	include_once("../../connectFiles/connect_cis.php");
	include_once("auth.php");
	include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="en">
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
		<?php require_once __DIR__ . "/content/shared-shell.php"; curriculum_render_site_header(); ?>

	<main class="container portfolio-main">
		<section class="hero-card portfolio-hero content-card-spotlight">
			<p class="portfolio-eyebrow">Resources</p>
			<h1 class="portfolio-title">Teaching Resources</h1>
			<p class="portfolio-subtitle">The following shared resources are available to support teaching at the English Language Center.</p>
		</section>

		<section class="portfolio-table-card">
			<iframe class="google_folder" src="https://drive.google.com/embeddedfolderview?id=0B9DQPyJT9PIUV2ZGNmlYQTJEQmM#list" title="Teaching resources folder"></iframe>
		</section>
	</main>
	<?php curriculum_render_footer(); ?>


</body>
</html>
