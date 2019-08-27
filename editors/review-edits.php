<?php
$course_id = $_GET['course_id'];

include_once("../../../connectFiles/connect_cis.php");
include_once("cas-go.php");

$query = $elc_db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id = ?");
$query->bind_param("s", $course_id);
$query->execute();
$result = $query->get_result();


function diff($old, $new){
    $matrix = array();
    $maxlen = 0;
    foreach($old as $oindex => $ovalue){
        $nkeys = array_keys($new, $ovalue);
        foreach($nkeys as $nindex){
            $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            if($matrix[$oindex][$nindex] > $maxlen){
                $maxlen = $matrix[$oindex][$nindex];
                $omax = $oindex + 1 - $maxlen;
                $nmax = $nindex + 1 - $maxlen;
            }
        }   
    }
    if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
    return array_merge(
        diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
        array_slice($new, $nmax, $maxlen),
        diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}

function htmldiff($old, $new){
$ret = '';
	$old = str_replace("<"," <", $old);
	$old = str_replace(">","> ", $old);
	$new = str_replace("<"," <", $new);
	$new = str_replace(">","> ", $new);
    $diff = diff(preg_split("/([\s]+|<\*>)/", $old), preg_split("/([\s]+|<\*>)/", $new));
    foreach($diff as $k){
        if(is_array($k))
            $ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').
                (!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
        else $ret .= $k . ' ';
    }
	return $ret;
}


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

$edits_query = $elc_db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where course_id = ? ");
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
		$(document).ready(function () {


			$("#save").click(function () {
				save();
			});



		});

		function save() {
			course_id = <?php echo $course_id; ?>;
			net_id = "<?php echo $updated_by_edits; ?>";
			course_name = "<?php echo $course_name_edits; ?>";
			course_description = "<?php echo $course_description_edits;?>";
			course_short_name = "<?php echo $course_short_name_edits; ?>";
			course_emphasis = "<?php echo $course_emphasis_edits; ?>";
			course_materials = "<?php echo $course_materials_edits; ?>";
			learning_outcomes = "<?php echo $learning_outcomes_edits; ?>";
			google_drive_folder_id = "<?php echo $google_drive_folder_id_edits; ?>";

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
					google_drive_folder_id: google_drive_folder_id,
					needs_review: "0",
				}
			}).done(function (phpfile) {
				$("#save_dialog").html(phpfile);
				console.log("Did it run?")
			});
		}
	</script>
</head>

<body>
	<header>
		<div id='holder'>
			<div>
				<h1> Review Edits: <?php echo $level_name." - ".$course_name; ?></h1>
				<a class="button" id="go_back" href="index.php">Main Menu</a>
				<a class="button" id="save">Save</a>
			</div>
			<div id="save_dialog"></div>
			<div id="user"><?php echo $net_id." | <a href='?logout='>Logout</a>"; ?></div>
		</div>
	</header>
	
	<article>
		<div class="content">
			<div class="block">
			<a class="button" style="float: right;"
								href="course-edit.php?course_id=<?php echo $course_id;?>">Click here to edit</a>
							<h2>Edits</h2>Last updated at <?php echo $updated_on_edits; ?> by
							<?php echo $updated_by_edits; ?>
	</div>
	</table>
		<?php $diff = htmldiff($course_name, $course_name_edits);	?><div class="block"><h2 class='editor-style'>Course Name</h2> <div id="course_name"><?php echo $diff; ?></div></div>
		<?php $diff = htmldiff($course_short_name, $course_short_name_edits);	?><div class="block"><h2 class='editor-style'>Course Short Name (Limit to 4-5 characters)</h2> <div id="course_short_name"><?php echo $diff; ?></div></div>
		<?php $diff = htmldiff($course_description, $course_description_edits);?><div class="block"><h2 class='editor-style'>Course Description</h2> <div id="course_description"><?php echo $diff; ?></div></div>
		<?php $diff = htmldiff($course_emphasis, $course_emphasis_edits);?><div class="block"><h2 class='editor-style'>Course Emphasis</h2><div id="course_emphasis"><?php echo $diff; ?></div></div>
		<?php $diff = htmldiff($course_materials, $course_materials_edits);?><div class="block"><h2 class='editor-style'>Course Books and Materials</h2><div id="course_materials"><?php echo $diff; ?></div></div>
		<?php $diff = htmldiff($learning_outcomes, $learning_outcomes_edits);?><div class="block"><h2 class='editor-style'>Course Learning Outcomes</h2> <div id="learning_outcomes"><?php echo $diff; ?></div></div>
		<?php $diff = htmldiff($google_drive_folder_id, $google_drive_folder_id_edits); ?><div class="block"><h2 class='editor-style'>Google Drive Folder ID</h2><div id="google_drive_folder_id"><?php echo $diff; ?></div></div>
				


			
		</div>
	</article>
</body>

</html>