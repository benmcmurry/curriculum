<?php
$course_id = $_GET['course_id'];

include_once("../../../connectFiles/connect_cis.php");
include_once("../auth.php");
require_once __DIR__ . '/page_helpers.php';

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
<html lang="en">

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
        var saveDialog = $("#save_dialog");
        function setReviewStatus(message, tone) {
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


        $("#save").click(function() {
            save();
        });



    });

    function save() {
        course_id = <?php echo $course_id; ?>;
        net_id = '<?php echo addslashes($updated_by_edits); ?>';
        course_name = '<?php echo addslashes($course_name_edits); ?>';
        course_description = '<?php echo addslashes($course_description_edits);?>';
        course_short_name = '<?php echo addslashes($course_short_name_edits); ?>';
        course_emphasis = '<?php echo addslashes($course_emphasis_edits); ?>';
        course_materials = '<?php echo addslashes($course_materials_edits); ?>';
        learning_outcomes = '<?php echo addslashes($learning_outcomes_edits); ?>';
        box_folder = '<?php echo addslashes($box_folder_edits); ?>';

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
        }).done(function(phpfile) {
            setReviewStatus(phpfile, "success");
        });
    }
    </script>
</head>

<body>
    <?php require_once dirname(__DIR__) . "/content/shared-shell.php"; curriculum_render_editor_header(); ?>
    <main class="container editor-main py-4">
        <?php
        curriculum_render_editor_hero('Review Queue', 'Review Course Edits', $level_name . ' - ' . $course_name);
        curriculum_render_editor_actions('Review actions', array(
            array('id' => 'go_back', 'href' => 'index.php', 'label' => 'Back to Dashboard', 'icon' => 'bi bi-grid-3x3-gap', 'class' => 'btn btn-outline-secondary'),
            array('href' => 'course-edit.php?course_id=' . $course_id, 'label' => 'Open Editable Version', 'icon' => 'bi bi-arrow-up-right-square', 'class' => 'btn btn-outline-secondary'),
            array('id' => 'save', 'href' => null, 'label' => 'Publish Approved Changes', 'icon' => 'bi bi-check2-square', 'class' => 'btn btn-primary ms-auto'),
        ));
        ?>

        <div class="editor-save-dialog editor-status mb-3" id="save_dialog" aria-live="polite"></div>

        <section class="editor-diff-grid">
            <article class="editor-diff-card">
                <label for="edits" class="form-label">Edit Time and Author</label>
                <div id="edits" class='form-control'>Last updated at <?php echo $updated_on_edits; ?> by <?php echo $updated_by_edits; ?></div>
            </article>

            <?php $diff = htmldiff($course_name, $course_name_edits); ?>
            <article class="editor-diff-card">
                <label for="course_name" class="form-label">Course Name</label>
                <div id="course_name" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($course_short_name, $course_short_name_edits); ?>
            <article class="editor-diff-card">
                <label for="course_short_name" class="form-label">Course Short Name</label>
                <div id="course_short_name" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($course_description, $course_description_edits); ?>
            <article class="editor-diff-card">
                <label for="course_description" class="form-label">Course Description</label>
                <div id="course_description" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($course_emphasis, $course_emphasis_edits); ?>
            <article class="editor-diff-card">
                <label for="course_emphasis" class="form-label">Course Emphasis</label>
                <div id="course_emphasis" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($course_materials, $course_materials_edits); ?>
            <article class="editor-diff-card">
                <label for="course_materials" class="form-label">Course Books and Materials</label>
                <div id="course_materials" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($learning_outcomes, $learning_outcomes_edits); ?>
            <article class="editor-diff-card">
                <label for="learning_outcomes" class="form-label">Course Learning Outcomes</label>
                <div id="learning_outcomes" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($box_folder, $box_folder_edits); ?>
            <article class="editor-diff-card">
                <label for="box_folder" class="form-label">Box Folder Link</label>
                <div id="box_folder" class='form-control'><?php echo $diff; ?></div>
            </article>
        </section>
    </main>
    <?php curriculum_render_footer(array("path_prefix" => "..", "profile_path" => "editors/profile-editor.php", "include_bootstrap_bundle" => false)); ?>
</body>

</html>
