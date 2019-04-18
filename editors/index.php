<?php

include_once("../../../connectFiles/connect_cis.php");
include_once("cas-go.php");
include_once("admins.php");
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
		$(document).ready(function () {
			$(".leBox").each(function () {
				leCourseID = this.id.split("-");
				leCourseID = "course-" + leCourseID[1];
				$(this).css({
					"top": findPosition("top", leCourseID) + $("#" + leCourseID).height() + 4,
					"left": findPosition("left", leCourseID) + 4,
					"width": $("#" + leCourseID).width() - 8
				});
			});
			$("div.leMenu").on("click", function () {


				courseID = $(this).prev().attr('id');
				courseID = courseID.split("-");
				courseID = "LeExp-" + courseID[1];
				if ($("#" + courseID).css('display') !== 'none') {
					$("#" + courseID).slideToggle();
				} else {
					$(".leBox").slideUp();
					$("#" + courseID).slideToggle();
				}
			});
			$('#learning_experiences').dataTable({
				aLengthMenu: [
					[5, 10, 50, -1],
					[5, 10, 50, "All"]
				],
				ordering: false,
			});
		});


		function findPosition(position, courseID) {
			courseButtonPosition = $("#" + leCourseID).position();
			courseButtonTop = courseButtonPosition.top;
			courseButtonRight = courseButtonPosition.left;
			if (position == "top") {
				return courseButtonTop;
			} else {
				return courseButtonRight;
			}
		}
	</script>
</head>

<body>
	<header>
		<div id='holder'>
		<div>
			<h1>Curriculum Editor</h1>
			<a class="button" id="go_back" href="https://elc.byu.edu/curriculum/">View the Curriculum Portfolio</a>
		</div>
		<div id="user">
			<?php
if ($auth) {echo phpCAS::getUser()." | <a href='?logout='>Logout</a>";}
else {echo "<a href='?login='>Login</a>";}
				?>
		</div>
	</div>

	</header>

	<article>
		<?php
    echo $message;
    if ($auth && $access) { ?>


		<div class="content">
			<div class="block">
				<h2> Levels and Courses </h2>
				<?php
                $query = $elc_db->prepare("Select Levels.level_id, Levels.level_name from Levels where active=1 order by level_order ASC");
								$query->execute();
								$result = $query->get_result();




        while ($levels = $result->fetch_assoc()) {
            echo "<div class='course_list'>";
            echo "<a class='level' href='level-edit.php?level_id=".$levels['level_id']."'>".$levels['level_name']."</a>";
            $course_query = "Select Courses.course_id, Courses.course_name,Courses.course_short_name, Courses.level_id from Courses where Courses.level_id=".$levels['level_id']." order by course_order ASC";
            if (!$course_result = $elc_db->query($course_query)) {
                die('There was an error running the query [' . $elc_db->error . ']');
            }

            while ($courses = $course_result->fetch_assoc()) {
				echo "<a class='courses' id='course-".$courses['course_id']."' data-shortName='".$courses['course_short_name']."' data-name='".$courses['course_name']."' title='".$courses['course_name']."' href='course-edit.php?course_id=".$courses['course_id']."'><span>".$courses['course_name']."</span></a>
				<div class='leMenu'>LE</div>";
			
				$learningExperienceQuery = $elc_db->prepare("Select *, LE_courses.course_id from Learning_experiences inner join LE_courses on Learning_experiences.learning_experience_id = LE_courses.learning_experience_id where LE_courses.course_id=? order by name ASC");
				$learningExperienceQuery->bind_param("s", $courses['course_id']);
				$learningExperienceQuery->execute();
				$learningExperienceResult = $learningExperienceQuery->get_result();
				echo "<div class='leBox' id ='LeExp-".$courses['course_id']."'>";
				while ($le = $learningExperienceResult->fetch_assoc()) {
				echo "<a class='leOption' href='le-edit.php?learningExperienceId=".$le['learning_experience_id']."'>".$le['name']."</a>";
				}
				echo "</div>";
			}
            echo "</div>";
        }
		$result->free();
		?>
			</div>
			<div class='block'>
				<h2>Learning Experiences</h2>
				<a id='new_le' class='button' href='le-edit.php?learningExperienceId=new'> + Learning
					Experience<a><br />
						<br />
						<table id='learning_experiences'>
							<thead>
								<tr>
									<td></td>
									<td>Learning Experience</td>
									<td>Creator </td>
									<td>Date Created </td>
								</tr>
							</thead>

							<?php 
		$learningExperienceQuery = $elc_db->prepare("Select * from Learning_experiences order by name ASC");
		$learningExperienceQuery->execute();
		$result = $learningExperienceQuery->get_result();
  	while ($learningExperience = $result->fetch_assoc()) {
		echo "<tr><td><a href='le-edit.php?learningExperienceId=".$learningExperience['learning_experience_id']."'>Edit</a></td>";
		echo "<td>".$learningExperience['name']."</td>";
		echo "<td>".$learningExperience['created_by']."</td>";
		echo "<td>".$learningExperience['created_on']."</td>";
		

		echo "</tr>";
		
	}
	  ?>
						</table>
			</div>
			<?php
if (phpCAS::getUser() == "blm39") {
    ?>
			<div class="block">
				<h2> Review Submitted Changes </h2>
				<?php


		$review_query = $elc_db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where needs_review = 1");
		// $review_query = $elc_db->prepare("Select * from Courses_review where needs_review = 1");
		$review_query->execute();
		$result = $review_query->get_result();
  	while ($Courses_review = $result->fetch_assoc()) {
      echo "<a href='review-edits.php?course_id=".$Courses_review['course_id']."'>".$Courses_review['level_name']." - ".$Courses_review['course_name']."</a><br />";
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
		</div>

		<?php } else {?> <p></p><?php } ?>
	</article>
</body>

</html>