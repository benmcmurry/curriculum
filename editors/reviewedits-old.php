<?php
$course_id = $_GET['course_id'];

include_once("../../../connectFiles/connect_cis.php");
include_once("../cas-go.php");

$query = $elc_db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id = ?");
$query->bind_param("s", $course_id);
$query->execute();
$result = $query->get_result();

function get_decorated_diff($old, $new){
	if ($old !== $new) {
		$from_start = strspn($old ^ $new, "\0");        
		$from_end = strspn(strrev($old) ^ strrev($new), "\0");

		$old_end = strlen($old) - $from_end;
		$new_end = strlen($new) - $from_end;

		$start = substr($new, 0, $from_start);
		$end = substr($new, $new_end);
		$new_diff = substr($new, $from_start, $new_end - $from_start);  
		$old_diff = substr($old, $from_start, $old_end - $from_start);

		$new = "$start<ins style='background-color:#ccffcc'>$new_diff</ins>$end";
		$old = "$start<del style='background-color:#ffcccc'>$old_diff</del>$end";
		return array("old"=>$old, "new"=>$new);
	} else {
		return array("old"=>$old, "new"=>$new);
	}
}

// function diff($old, $new){
//     $matrix = array();
//     $maxlen = 0;
//     foreach($old as $oindex => $ovalue){
//         $nkeys = array_keys($new, $ovalue);
//         foreach($nkeys as $nindex){
//             $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
//                 $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
//             if($matrix[$oindex][$nindex] > $maxlen){
//                 $maxlen = $matrix[$oindex][$nindex];
//                 $omax = $oindex + 1 - $maxlen;
//                 $nmax = $nindex + 1 - $maxlen;
//             }
//         }   
//     }
//     if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
//     return array_merge(
//         diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
//         array_slice($new, $nmax, $maxlen),
//         diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
// }

// function get_decorated_diff($old, $new){
// $ret = '';
//     $diff = diff(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));
//     foreach($diff as $k){
//         if(is_array($k))
//             $ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').
//                 (!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
//         else $ret .= $k . ' ';
//     }
// 	return $ret;
// }


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
      $box_folder_edits = $course_edits['box_folder'];
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
			net_id = '<?php echo $updated_by_edits; ?>';
			course_name = '<?php echo $course_name_edits; ?>';
			course_description = '<?php echo $course_description_edits;?>';
			course_short_name = '<?php echo $course_short_name_edits; ?>';
			course_emphasis = '<?php echo $course_emphasis_edits; ?>';
			course_materials = '<?php echo $course_materials_edits; ?>';
			learning_outcomes = '<?php echo $learning_outcomes_edits; ?>';
			box_folder = '<?php echo $box_folder_edits; ?>';

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
					box_folder: box_folder,
					needs_review: "0",
				}
			}).done(function (phpfile) {
				$("#save_dialog").html(phpfile);
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
			<div class="main">
				<table id='differences' width="100%" cellpadding="10" border="1" cellspacing="0">
					<tr>
						<td>
							<h2>Original</h2>Last updated at <?php echo $updated_on; ?> by <?php echo $updated_by; ?>
						</td>
						<td><a class="button" style="float: right;"
								href="course-edit.php?course_id=<?php echo $course_id;?>">Click here to edit</a>
							<h2>Edits</h2>Last updated at <?php echo $updated_on_edits; ?> by
							<?php echo $updated_by_edits; ?>
						</td>
					</tr>

					<!-- Course Name -->
					<?php $diff = get_decorated_diff($course_name, $course_name_edits);	?>
					<tr>
						<td colspan="2">
							<h2>Course Name</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="course_name"><?php echo $diff['new']; ?></td>
					</tr>

					<!-- Course Short Name -->
					<?php $diff = get_decorated_diff($course_short_name, $course_short_name_edits);	?>
					<tr>
						<td colspan="2">
							<h2>Course Short Name (Limit to 4-5 characters)</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="course_short_name"><?php echo $diff['new']; ?></td>
					</tr>

					<!-- Course Description -->
					<?php $diff = get_decorated_diff($course_description, $course_description_edits);?>
					<tr>
						<td colspan="2">
							<h2>Course Description</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="course_description"><?php echo $diff['new']; ?></td>
					</tr>
					
					<!-- Course Emphasis -->
					<?php $diff = get_decorated_diff($course_emphasis, $course_emphasis_edits);?>
					<tr>
						<td colspan="2">
							<h2>Course Emphasis</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="course_emphasis"><?php echo $diff['new']; ?></td>
					</tr>

					<!-- Course Books and Materials -->
					<?php $diff = get_decorated_diff($course_materials, $course_materials_edits);?>
					<tr>
						<td colspan="2">
							<h2>Course Books and Materials</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="course_materials"><?php echo $diff['new']; ?></td>
					</tr>

					<!-- Course Learning Outcomes -->
					<?php $diff = get_decorated_diff($learning_outcomes, $learning_outcomes_edits);?>
					<tr>
						<td colspan="2">
							<h2>Course Learning Outcomes</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="learning_outcomes" ><?php echo $diff['new']; ?></td>
					</tr>

					<!-- Google Drive Folder -->
					<?php $diff = get_decorated_diff($box_folder, $box_folder_edits); ?>
					<tr>
						<td colspan="2">
							<h2>Box Folder Link</h2>
						</td>
					</tr>
					<tr>
						<td width="50%"><?php echo $diff['old']; ?></td>
						<td width="50%" id="box_folder" ><?php echo $diff['new']; ?></td>
					</tr>

				</table>





			</div>
		</div>
	</article>
</body>

</html>