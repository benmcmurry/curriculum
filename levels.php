<?php
require_once __DIR__ . '/bootstrap.php';
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 2) . '/private-config') . '/connectFiles/connect_cis.php');
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
		<p class="portfolio-eyebrow">Curriculum</p>
		<h1 class="portfolio-title">Level Descriptors</h1>
		<p class="portfolio-subtitle">These descriptors outline the language abilities students are expected to demonstrate by level and skill area, and they serve as the curricular target for instruction and assessment.</p>
	</section>

	<section class="content-card content-card-compact content-card-nav mb-4">
		<nav class="section-jump-nav" aria-label="Level descriptors navigation">
			<p class="section-jump-label">Jump to level</p>
			<ul>
				<?php
				$levelsForNavQuery = $elc_db->prepare("Select level_name, level_short_name from Levels where active=1 order by level_order ASC");
				$levelsForNavQuery->execute();
				$levelsForNavResult = $levelsForNavQuery->get_result();
				while ($navLevel = $levelsForNavResult->fetch_assoc()) {
					echo "<li><a href='#" . htmlspecialchars($navLevel['level_short_name'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($navLevel['level_name'], ENT_QUOTES, 'UTF-8') . "</a></li>";
				}
				$levelsForNavResult->free();
				?>
			</ul>
		</nav>
	</section>

	<section class="portfolio-card mb-4">
		<div class="portfolio-card-header-level">
			<h2 class="h4 mb-0">How to Read These Descriptors</h2>
		</div>
		<div class="portfolio-card-body portfolio-rich-text">
			<p>This document describes the language ability of our students according to proficiency level and skill area. As we
				continue to revise and improve our existing curriculum, these descriptors will serve as a guide to
				administrators, teachers, and students. Objectives will aim toward helping students reach these proficiency
				descriptors.</p>
			<p>The two proficiency levels next to each ELC level name roughly correspond to ACTFL proficiency levels. The first
				label is the entry point for students in that level and the second label is for students exiting that level. For
				example, students entering Academic B will be at the Advanced Low proficiency level. Students who successfully
				complete Academic B are at the Advanced Mid proficiency level. The descriptors describe what language functions
				students who are exiting the level are capable of performing.</p>
			<p>Each skill area is divided into three groups: function, text, and fluency/comprehensibility.</p>
			<ul>
				<li>Function refers to what a student can do.</li>
				<li>For receptive skills, text refers to the language samples students listen to or read. For productive skills,
					text refers to the language produced by the learner.</li>
				<li>Fluency applies to receptive skills and includes information regarding comprehension levels and rate.</li>
				<li>Comprehensibility is used in productive skills to indicate to which degree the students’ language is
					understood in the presence of errors.</li>
			</ul>
			<p class="mb-0">Another important aspect of these descriptors is the adverbs of frequency that are used to mark
				difference in ability among various levels. Rarely, usually, often, sometimes, frequently and other similar words
				are used throughout the document to discriminate among proficiency levels.</p>
		</div>
	</section>

	<?php
        $query = $elc_db->prepare("Select * from Levels where active=1 order by level_order ASC");
				$query->execute();
				$result = $query->get_result();
        while ($levels = $result->fetch_assoc()) {
            echo "<a class='anchor' id='".$levels['level_short_name']."'></a>";
            echo "<section class='portfolio-card mb-4'>";
            echo "<div class='portfolio-card-header-level'><h2 class='h4 mb-0'>".$levels['level_name']."</h2></div>";
            echo "<div class='portfolio-card-body portfolio-rich-text'>";
            echo $levels['level_descriptor'];
            echo "<h3 class='h6 mt-4 mb-3'>Courses</h3>";
            echo "<div class='portfolio-item-grid'>";
                $course_query = $elc_db->prepare("Select * from Courses where level_id = ? order by course_order");
								$course_query->bind_param("s",$levels['level_id']);
								$course_query->execute();
            		$courses_result = $course_query->get_result();
					
            while ($courses = $courses_result->fetch_assoc()) {
				echo "<article class='portfolio-item-card'>";
				echo "<p class='portfolio-stat-label'>Course</p>";
				echo "<h4>".htmlspecialchars($courses['course_name'], ENT_QUOTES, 'UTF-8')."</h4>";
				echo "<p class='portfolio-item-meta'>Open this course to review the current description, materials, outcomes, and connected learning experiences.</p>";
				echo "<a class='portfolio-chip-link' role='button' data-shortName='".htmlspecialchars($courses['course_short_name'], ENT_QUOTES, 'UTF-8')."' data-name='".htmlspecialchars($courses['course_name'], ENT_QUOTES, 'UTF-8')."' title='".htmlspecialchars($courses['course_name'], ENT_QUOTES, 'UTF-8')."' href='course.php?course_id=".$courses['course_id']."'>View Course</a>";
				echo "</article>";
            }
                
			echo "</div></div></section>";
        }
        $result->free();

?>
</main>
	
	<?php curriculum_render_footer(); ?>

</body>
</html>
