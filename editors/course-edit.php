<?php

$course_id = $_GET['course_id']; $message ="";
if ($course_id < 1) {$message =  "Invalid course. Showing first course."; $course_id = 1;}
if ($course_id > 33) {$message =  "Invalid course. showing last course."; $course_id = 33;}

include_once("../../../connectFiles/connect_cis.php");

include_once("cas-go.php");
include_once("admins.php");
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
      $box_folder = $course['box_folder'];
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

    current_course_name = $("#course_name").text();
		current_course_description = $("#course_description").text(); console.log("current_course_description");
		current_course_short_name = $("#course_short_name").text();
		current_course_emphasis = $("#course_emphasis").text();
		current_course_materials = $("#course_materials").text();
		current_learning_outcomes = $("#learning_outcomes").text();
		current_assessment = $("#assessment").text();
		current_learning_experiences = $("#learning_experiences").text();
		current_box_folder = $("#box_folder").text();

	$("#save").click(function(){
		save("button");
	});

	$("div").blur(function(){
		save(this.id);
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
});

function save() {

    //    if (current_course_name == $("#course_name").text() &&
    //       current_course_description == $("#course_description").text() &&
    //       current_course_short_name == $("#course_short_name").text() &&
    //       current_course_emphasis == $("#course_emphasis").text() &&
    //       current_course_materials == $("#course_materials").text() &&
    //       current_learning_outcomes == $("#learning_outcomes").text() &&
    //       current_assessment == $("#assessment").text() &&
    //       current_learning_experiences == $("#learning_experiences").text() &&
    //       current_box_folder == $("#box_folder").text())
    //       {return ;}

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
		box_folder = $("#box_folder").text();

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
				box_folder: box_folder,
				needs_review: "1",
				}
		}).done(function(phpfile) {
		$("#save_dialog").html(phpfile);
  		});
}

</script>
</head>
<body>
<?php require_once("../content/header-short.php"); 
if ($message) {
	echo "<div class='container-md pt-4'>";
	echo $message;
	echo "</div>";
}
if ($auth && $access) { ?>
	<div class="container-md sticky-top pt-5 mb-2">
		<div class="row justify-content-between">
			<div class="btn-group col-3" role="group">
			<a type="button" class="btn btn-primary" id="toPortfolio" href="../course.php?course_id=<?php echo $course_id;?>"><i class="bi bi-back"></i> Portfolio </a>
					<a type="button" class="btn btn-primary" id="go_back" href="index.php"><i class="bi bi-pencil"></i> Editor Menu</a>			</div>
			<div class="btn-group col-3" role="group">
				<a type="button" class="btn btn-primary" id="previous" href="course-edit.php?course_id=<?php echo $course_id-1;?>"><i class="bi bi-arrow-left-circle"></i> Previous Course</a>
				<a type="button" class="btn btn-primary" id="next" href="course-edit.php?course_id=<?php echo $course_id+1;?>">Next Course <i class="bi bi-arrow-right-circle"></i></a>
			</div>
			<div class="btn-group col-2" role="group">
				<a type="button" class="btn btn-primary" id="save"><i class="bi bi-server"></i> Save</a>
			</div>
		</div>
	</div>
	<div class="container-md" id="save_dialog"></div>
	<div class="container-md bg-light">
		<h2>Course Editor: <?php echo $level_name." - ".$course_name; ?></h2>
 	 </div>
			
	  <div class="container-md bg-light">
		
			<label for="course_name" class="form-label">Course Name</label> 
			<div id="course_name" class="form-control" contenteditable="true" aria-describedby="courseNameHelp"><?php echo $course_name; ?></div>
			<div id="courseNameHelp" class="form-text mb-4">Follow pre-determined naming schemes</div>
	
		
		<label for="course_short_name" class="form-label">Course Short Name</label> 
		<div id="course_short_name" class="form-control" contenteditable="true" aria-describedby="courseShortNameHelp"><?php echo $course_short_name; ?></div>
		<div id="courseShortNameHelp" class="form-text mb-4">Limit to 4 or 5 characters. (i.e. Gmr)</div>

		<label for="course_description" class="form-label">Course Description</label> 
		<div id="course_description" class="form-control" contenteditable="true" aria-describedby="courseDescriptorHelp"><?php echo $course_description; ?></div>
		<div id="courseDescriptorHelp" class="form-text mb-4">This should be no more than 2 sentences long.</div>
		
		<label for="course_emphasis" class="form-label">Course Emphasis</label>
		<div id="course_emphasis" class="form-control" contenteditable="true" aria-describedby="courseEmphasisHelp"><?php echo $course_emphasis; ?></div>
		<div id="courseEmphasisHelp" class="form-text mb-4">Use list format to list the skills addressed in this course</div>
		
		<label for="course_materials" class="form-label">Course Books and Materials</label>
		<div id="course_materials" class="form-control" contenteditable="true" aria-describedby="courseMaterialsHelp"><?php echo $course_materials; ?></div>
		<div id="courseMaterialsHelp" class="form-text mb-4">Use list format to list materials needed for the course</div>
		
		<label for="learning_outcomes" class="form-label">Course Learning Outcomes</label> 
		<div id="learning_outcomes" class="form-control" contenteditable="true" aria-describedby="courseLearningOutcomesHelp"><?php echo $learning_outcomes; ?></div>
		<div id="courseLearningOutcomesHelp" class="form-text mb-4">This should be an ordered list.</div>
		
		<label for="box_folder" class="form-label">Box Folder Link</label>
		<div id="box_folder" class="form-control" contenteditable="true" aria-describedby="googleDriveHelp"><?php echo $box_folder; ?></div>
		<div id="googleDriveHelp" class="form-text mb-4">This the shareable link.</div>

</div>
  <?php } ?>
</body>
</html>
