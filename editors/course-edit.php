<?php

$course_id = $_GET['course_id'];

include_once("../../../connectFiles/connect_cis.php");

if ($local == 0) {
    include_once("../CASauthinator.php");
    $net_id = Authenticator::getUser();
} else {
    $net_id = "blm39";
}

$query = $elc_db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where course_id= ?");
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
  }

?>

<!DOCTYPE html>
<html lang="">
<head>
<title>Course Editor - <?php echo $level_name." - ".$course_name; ?></title>

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

	$("div").blur(function(){
		save();
	});

	 $(window).keydown(function (e){
    if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) { /*ctrl+s or command+s*/
        save();
        e.preventDefault();
        return false;
    }
	});
	 tinymce.init({
            selector: "#course_description, #course_emphasis, #learning_outcomes, #course_materials, #learning_experiences, #assessment",
            inline: true,
            menubar: false,
            nowrap: false,
            plugins: [
         "autolink link image lists charmap hr anchor pagebreak save",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons template paste textcolor rollups"
   ],
   			paste_auto_cleanup_on_paste : true,
            style_formats: [
			{title: 'Normal', inline: 'p'},
			{title: 'Heading', block: 'h4'},
			{title: "Sub-heading", block: 'h5'}

    ],
    		toolbar: "undo redo | cut copy pasterollup | styleselect | bold italic removeformat | table | alignrollup | bullist numlist | insertrollup | linksrollup | coderollup | ",
    		browser_spellcheck: true,
			save_onsavecallback: function() {save();},
			setup: function (editor) {
               // Custom Blur Event to stop hiding the toolbar
                editor.on('blur', function (e) {
                   e.stopImmediatePropagation();
                   e.preventDefault();
                });
                editor.on('focus',function (e) {
	                current_editor = this.id;
	                $.when( $(".editable").css("margin-top", "0px")).done(function(){$("#"+current_editor).css("margin-top", "40px")});
                });
            }


        });
        /*
$(".editable").click(function(){

        });
*/
// tinyMCE.execCommand("mceAddControl", true, '#level_descriptor');

});

function save() {
		course_id = <?php echo $course_id; ?>;
		net_id = '<?php echo $net_id; ?>';
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
				needs_review: "1",
				}
		}).done(function(phpfile) {
		$("#save_dialog").html(phpfile);
  		});
}

</script>
</head>
<body>
	<header>
			<h1> Course Editor: <?php echo $level_name." - ".$course_name; ?></h1>
			<div id="user"><?php echo $net_id; ?></div>

			<!-- <button id="save">Save</button> -->
			<a class="button" id="go_back" href="index.php">Main Menu</a>
			<a class="button" id="previous" href="course-edit.php?course_id=<?php echo $course_id-1;?>">Previous Level</a>
			<a class="button" id="next" href="course-edit.php?course_id=<?php echo $course_id+1;?>">Next Level</a>
			<a class="button" id="save">Save</a>

			<div id="save_dialog"></div>
	</header>
<article>
		<div class="content-background">
			<div class="main">
				<div class="separator">
				<h2>Course Name</h2> <div id="course_name" class="editable" contenteditable="true"><?php echo $course_name; ?></div>
				</div>
				<div class="separator">
					<h2>Course Short Name (Limit to 4-5 characters)</h2> <div id="course_short_name" class="editable" contenteditable="true"><?php echo $course_short_name; ?></div>
				</div>
				<div class="separator">
				<h2>Course Description</h2> <div id="course_description" class="editable" contenteditable="true"><?php echo $course_description; ?></div></div>
				<div class="separator">
					<h2>Course Emphasis</h2><div id="course_emphasis" class="editable" contenteditable="true"><?php echo $course_emphasis; ?></div></div>
				<div class="separator">
				<h2>Course Books and Materials</h2><div id="course_materials" class="editable" contenteditable="true"><?php echo $course_materials; ?></div></div>
			    <div class="separator"><h2>Course Learning Outcomes</h2> <div id="learning_outcomes" class="editable" contenteditable="true"><?php echo $learning_outcomes; ?></div></div>
				<div class="separator"><h2>Course Assessment</h2> <div id="assessment" class="editable" contenteditable="true"><?php echo $assessment; ?></div></div>
				<div class="separator"><h2>Course Learning Experiences</h2><div id="learning_experiences" class="editable" contenteditable="true"><?php echo $learning_experiences; ?></div> </div>
				<div class="separator"><h2>Google Drive Folder ID</h2><div id="google_drive_folder_id" class="editable" contenteditable="true"><?php echo $google_drive_folder_id; ?></div>

			</div>
		</div>
	</article>
</body>
</html>
