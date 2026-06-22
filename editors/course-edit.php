<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);	

$course_id = $_GET['course_id']; $message ="";
if ($course_id < 1) {$message =  "Invalid course. Showing first course."; $course_id = 1;}
if ($course_id > 37) {$message =  "Invalid course. showing last course."; $course_id = 37;}

include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');

include_once("../auth.php");
include_once("admins.php");
require_once __DIR__ . '/page_helpers.php';
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
<html lang="en">
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
    function setCourseSaveStatus(message, tone) {
      var saveDialog = $("#save_dialog");
      saveDialog
        .removeClass("alert alert-danger alert-success alert-info")
        .addClass("editor-status");
      if (tone === "error") {
        saveDialog.addClass("alert alert-danger");
      } else if (tone === "success") {
        saveDialog.addClass("alert alert-success");
      } else {
        saveDialog.addClass("alert alert-info");
      }
      saveDialog.text(message);
    }

	$(document).ready(function() {
    current_course_name = $("#course_name").text();
		current_course_description = $("#course_description").text();
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

	$(".editor-form-grid [contenteditable='true']").blur(function(){
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
    setCourseSaveStatus("Saving course changes...", "info");

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
		setCourseSaveStatus(phpfile, "success");
  		});
}

</script>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to editor content</a>
<?php require_once dirname(__DIR__) . '/content/shared-shell.php'; curriculum_render_editor_header();
if ($message) { ?>
	<div class="container editor-access-state">
		<section class="editor-panel">
			<div class="editor-panel-body">
				<div class="alert alert-info" role="status"><?php echo $message; ?></div>
			</div>
		</section>
	</div>
<?php }
if ($auth && $access) { ?>
	<main id="main-content" class="container editor-main py-4">
		<?php
		curriculum_render_editor_hero('Course Editor', $level_name . ' - ' . $course_name, 'Edit the public-facing course summary, materials, learning outcomes, and resource links that appear in the curriculum portfolio.');
		curriculum_render_editor_actions('Editor actions', array(
			array('id' => 'toPortfolio', 'href' => '../course.php?course_id=' . $course_id, 'label' => 'Open Live Course', 'icon' => 'bi bi-arrow-up-right-square', 'class' => 'btn btn-outline-secondary'),
			array('id' => 'go_back', 'href' => 'index.php', 'label' => 'Editor Dashboard', 'icon' => 'bi bi-grid-3x3-gap', 'class' => 'btn btn-outline-secondary'),
			array('id' => 'previous', 'href' => 'course-edit.php?course_id=' . ($course_id - 1), 'label' => 'Previous Course', 'icon' => 'bi bi-arrow-left-circle', 'class' => 'btn btn-outline-secondary'),
			array('id' => 'next', 'href' => 'course-edit.php?course_id=' . ($course_id + 1), 'label' => 'Next Course', 'icon' => 'bi bi-arrow-right-circle', 'class' => 'btn btn-outline-secondary'),
			array('id' => 'save', 'href' => null, 'label' => 'Save Changes', 'icon' => 'bi bi-save2', 'class' => 'btn btn-primary ms-auto'),
		));
		?>

		<p class="editor-helper-note">This page saves on blur and with the Save Changes button. TinyMCE fields use the same shared save flow as the rest of the editor.</p>
		<div class="editor-save-dialog editor-status mb-3" id="save_dialog" aria-live="polite"></div>

		<section class="editor-panel mb-3">
			<div class="editor-panel-header editor-panel-header-course">
				<h2 class="h4 mb-0">Course Editor: <?php echo $level_name." - ".$course_name; ?></h2>
			</div>
			<div class="editor-panel-body editor-form-grid">
		
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
		<div id="googleDriveHelp" class="form-text mb-4">This is the shareable link.</div>
</div></section></main>
  <?php } ?>
<?php curriculum_render_footer(array("path_prefix" => "..", "profile_path" => "editors/profile-editor.php", "include_bootstrap_bundle" => false)); ?>
</body>
</html>
