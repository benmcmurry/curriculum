<?php
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
	<link rel="stylesheet" type="text/css" href="profile/datatables.min.css"/>

	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
	<style>
		td p {
			margin-top: 0px;
			margin-bottom: 0px;
		}
		div.content {
			background-color: white !important;
			margin-top: 10px !important;
			padding: 10px;


		}
	</style>
	<script>
		$(document).ready(function() {
			 $('#publications_table, #presentations_table, #theses_table, #projects_table, #dissertations_table').dataTable({
	    aLengthMenu: [
        [5, 10, 50, -1],
        [5, 10, 50, "All"]
    ],
    ordering: false,
    });

		$(".options").on("click", function(){
			$(".options").css({"color": "white", "background-color" : "rgba(70, 162, 222, 1)"});
			$(this).css({"color": "blue", "background-color" : "white"});
			$("#data_view").html($("#teaching_"+this.id).html());


		});
		$("#recent_semesters").trigger("click");

		$(".research_options").on("click", function(){
			$(".research_options").css({"color": "white", "background-color" : "rgba(70, 162, 222, 1)"});
			$(this).css({"color": "blue", "background-color" : "white"});
			$(".research_folder").hide();
			$("#list_"+this.id).show();


		});
		$("#publications").trigger("click");
});


</script>
</head>
<body>
	<header>
		<?php include("content/header.php"); ?>
	</header>
	<nav>
		<?php include("content/nav-bar.php"); ?>
	</nav>

	<article>

		<?php include ("profile/index.php"); ?>

	</article>
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>

<a href="#top" id='scrolly'>&#x2B06;</a>
</body>
</html>
