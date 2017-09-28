<?php

include_once("../../../connectFiles/connect_cis.php");
// Load the settings from the central config file
require_once '../config.php';
// Load the CAS lib
require_once '../CAS.php';
// Enable debugging
phpCAS::setDebug();
// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(true);

// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
phpCAS::setNoCasServerValidation();

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}
if (isset($_REQUEST['login'])) {
    phpCAS::forceAuthentication();
}

// check CAS authentication
$auth = phpCAS::checkAuthentication();
?>

<!DOCTYPE html>
<html lang="">
<head>
	<title>Curriculum Editor</title>

<!-- 	Meta Information -->
	<meta charset="utf-8">
	<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
	<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("styles_and_scripts.html"); ?>

<!-- 	Javascript -->
	<script>
	$(document).ready(function() {



});


</script>
</head>
<body>
	<header>
			<h1>Curriculum Editor</h1>
			<div id="user">
				<?php
if ($auth) {echo phpCAS::getUser()." | <a href='?logout='>Logout</a>";}
else {echo "<a href='?login='>Login</a>";}
				?>
			</div>
			<a class="button" id="go_back" href="https://elc.byu.edu/curriculum/">View the Curriculum Portfolio</a>
				</header>
<article>
		<?php if ($auth) { ?>
			<hr />

			<div class="main">
			<h2> Levels and Courses </h2>
			<?php
                $query = $elc_db->prepare("Select Levels.level_id, Levels.level_name from Levels order by level_order ASC");
								$query->execute();
								$result = $query->get_result();




        while ($levels = $result->fetch_assoc()) {
            echo "<div class='course_list'>";
            echo "<h2><a href='level-edit.php?level_id=".$levels['level_id']."'>".$levels['level_name']."</a></h2>";
            $course_query = "Select Courses.course_id, Courses.course_name, Courses.level_id from Courses where Courses.level_id=".$levels['level_id']." order by course_order ASC";
            if (!$course_result = $elc_db->query($course_query)) {
                die('There was an error running the query [' . $elc_db->error . ']');
            }

            while ($courses = $course_result->fetch_assoc()) {
                echo "<a class='course-icon ".$courses['course_id']."' href='course-edit.php?course_id=".$courses['course_id']."'>".$courses['course_name']."</a>";
            }
            echo "</div>";
        }
        $result->free();

if (phpCAS::getUser() == "blm39") {
    ?>
		<h2> Review Submitted Changes </h2>
		<?php



		$review_query = $elc_db->prepare("Select * from Courses_review where needs_review = 1");
		$review_query->execute();
		$result = $review_query->get_result();
  	while ($Courses_review = $result->fetch_assoc()) {
      echo "<a href='review-edits.php?course_id=".$Courses_review['course_id']."'>".$Courses_review['course_name']."</a><br />";
  	}

		$review_level_query = $elc_db->prepare("Select * from Levels_review where needs_review = 1");
		$review_level_query->execute();
		$review_level_query_results = $review_level_query->get_result();

  	while ($level_review = $review_level_query_results->fetch_assoc()) {
      echo "<a href='review-level-edits.php?level_id=".$level_review['level_id']."'>".$level_review['level_name']."</a><br />";
  	}

}

?>
			</div>
	<hr />
<?php } else {?> <p></p><?php } ?>
	</article>
</body>
</html>
