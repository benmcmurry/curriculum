<?php
include_once("../CASauthinator.php");
$course_id = $_GET['course_id'];

    include_once("../../../connectFiles/connect_cis.php");
$net_id = Authenticator::getUser();

$query = $db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id=$course_id");
$query->bind_param("s", $course_id);
$query->execute();
$result = $query->get_result();

        while ($course = $result->fetch_assoc()) {
            $level_name = $course['level_name'];
            $course_name = $course['course_name'];
            $course_short_name = $course['course_short_name'];
            $course_description = $course['course_description'];
            $course_emphasis = $course['course_emphasis'];
            $course_materials = $course['course_materials'];
            $learning_outcomes = $course['learning_outcomes'];
            $assessment = $course['assessment'];
            $learning_experiences = $course['learning_experiences'];
            $google_drive_folder_id = $course['google_drive_folder_id'];
            $updated_on = $course['updated_on'];
            $updated_by = $course['updated_by'];
        }

$edits_query = $db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where course_id = ? ");
$edits_query->bind_param("s", $course_id);
$edits_query->execute();
$edit_result = $edits_query->get_result();
        while ($course_edits = $edit_result->fetch_assoc()) {
            $level_name_edits = $course_edits['level_name'];
            $course_name_edits = $course_edits['course_name'];
            $course_short_name_edits = $course_edits['course_short_name'];
            $course_description_edits = $course_edits['course_description'];
            $course_emphasis_edits = $course_edits['course_emphasis'];
            $course_materials_edits = $course_edits['course_materials'];
            $learning_outcomes_edits = $course_edits['learning_outcomes'];
            $assessment_edits = $course_edits['assessment'];
            $learning_experiences_edits = $course_edits['learning_experiences'];
            $google_drive_folder_id_edits = $course_edits['google_drive_folder_id'];
            $updated_on_edits = $course_edits['updated_on'];
            $updated_by_edits = $course_edits['updated_by'];
        }




?>

<!DOCTYPE html>
<html lang="">
<head>
	<title>Review Edits - <?php echo $level_name." - ".$course_name; ?></title>

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


	$("#save").click(function(){
		save();
	});



});

function save() {
		course_id = <?php echo $course_id; ?>;
		net_id = '<?php echo $updated_by_edits; ?>';
		course_name = $("#course_name").text();
		course_description = $("#course_description").html();
		course_short_name = $("#course_short_name").text();
		course_emphasis = $("#course_emphasis").html();
		course_materials = $("#course_materials").html();
		learning_outcomes = $("#learning_outcomes").html();
		assessment = $("#assessment").html();
		learning_experiences = $("#learning_experiences").html();
		google_drive_folder_id = $("#google_drive_folder_id").text();

		$.ajax({
			method: "POST",
			url: "save-course.php",
			data: {
				course_id: course_id,
				net_id: net_id,
				course_name: course_name,
				course_short_name: course_short_name,
				course_description: course_description,
				course_emphasis: course_emphasis,
				course_materials: course_materials,
				learning_outcomes: learning_outcomes,
				assessment: assessment,
				learning_experiences: learning_experiences,
				google_drive_folder_id: google_drive_folder_id,
				needs_review: "0",
				}
		}).done(function(phpfile) {
		$("#save_dialog").html(phpfile);
  		});
}

</script>
</head>
<body>
	<header>
			<h1> Review Edits: <?php echo $level_name." - ".$course_name; ?></h1>
			<div id="user"><?php echo $net_id; ?></div>

			<!-- <button id="save">Save</button> -->
			<a class="button" id="go_back" href="index.php">Main Menu</a>
			<a class="button" id="save">Save</a>

			<div id="save_dialog"></div>
	</header>
<article>
		<div class="content-background">
			<div class="main">
				<table id='differences' width="100%" cellpadding="10" border="1" cellspacing="0">
					<tr>
						<td><h2>Original</h2>Last updated at <?php echo $updated_on; ?> by <?php echo $updated_by; ?></td>
						<td><a class="button" style="float: right;" href="course-edit.php?course_id=<?php echo $course_id;?>">Click here to edit</a><h2 >Edits</h2>Last updated at <?php echo $updated_on_edits; ?> by <?php echo $updated_by_edits; ?></td>
					</tr>
					<tr>
						<td colspan="2"><h2>Course Name</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $course_name; ?></td>
						<td width="50%" id="course_name" <?php if ($course_name !== $course_name_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $course_name_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2"><h2>Course Short Name (Limit to 4-5 characters)</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $course_short_name; ?></td>
						<td width="50%" id="course_short_name"<?php if ($course_short_name !== $course_short_name_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?>><?php echo $course_short_name_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2"><h2>Course Description</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $course_description; ?></td>
						<td width="50%" id="course_description" <?php if ($course_description !== $course_description_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?>><?php echo $course_description_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2"><h2>Course Emphasis</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $course_emphasis; ?></td>
						<td width="50%" id="course_emphasis" <?php if ($course_emphasis !== $course_emphasis_edit) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $course_emphasis_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2">	<h2>Course Books and Materials</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $course_materials; ?></td>
						<td width="50%" id="course_materials" <?php if ($course_materials !== $course_materials_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $course_materials_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2">	<h2>Course Learning Outcomes</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $learning_outcomes; ?></td>
						<td width="50%" id="learning_outcomes" <?php if ($learning_outcomes !== $learning_outcomes_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $learning_outcomes_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2">	<h2>Course Assessment</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $assessment; ?></td>
						<td width="50%" id="assessment" <?php if ($assessment !== $assessment_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $assessment_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2">	<h2>Course Learning Experiences</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $learning_experiences; ?></td>
						<td width="50%" id="learning_experiences" <?php if ($learning_experiences !== $learning_experiences_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $learning_experiences_edits; ?></td>
					</tr>

					<tr>
						<td colspan="2">	<h2>Google Drive Folder ID</h2></td>
					</tr>
					<tr>
						<td width="50%"><?php echo $google_drive_folder_id; ?></td>
						<td width="50%" id="google_drive_folder_id" <?php if ($google_drive_folder_id !== $google_drive_folder_id_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $google_drive_folder_id_edits; ?></td>
					</tr>

				</table>





			</div>
		</div>
</article>
</body>
</html>
