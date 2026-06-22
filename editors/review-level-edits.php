<?php
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');
include_once("../auth.php");
require_once __DIR__ . '/page_helpers.php';

$level_id = $_GET['level_id'];

$query = $elc_db->prepare("Select * from Levels where level_id = ? ");
$query->bind_param("s", $level_id);
$query->execute();
$result = $query->get_result();

function diff($old, $new) {
    $matrix = array();
    $maxlen = 0;
    foreach ($old as $oindex => $ovalue) {
        $nkeys = array_keys($new, $ovalue);
        foreach ($nkeys as $nindex) {
            $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            if ($matrix[$oindex][$nindex] > $maxlen) {
                $maxlen = $matrix[$oindex][$nindex];
                $omax = $oindex + 1 - $maxlen;
                $nmax = $nindex + 1 - $maxlen;
            }
        }   
    }
    if ($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
    return array_merge(
        diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
        array_slice($new, $nmax, $maxlen),
        diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}

function htmldiff($old, $new) {
$ret = '';
	$old = str_replace("<", " <", $old);
	$old = str_replace(">", "> ", $old);
	$new = str_replace("<", " <", $new);
	$new = str_replace(">", "> ", $new);
	$diff = diff(preg_split("/([\s]+)/", $old), preg_split("/([\s]+)/", $new));
// print_r($diff);
    foreach ($diff as $k) {
        if (is_array($k))
            $ret .= (!empty($k['d'])?"<del>".implode(' ', $k['d'])."</del> ":'').
                (!empty($k['i'])?"<ins>".implode(' ', $k['i'])."</ins> ":'');
        else $ret .= $k . ' ';
    }
	return $ret;
}

  while ($level = $result->fetch_assoc()) {
      $level_name = $level['level_name'];
      $level_short_name = $level['level_short_name'];
      $level_descriptor = $level['level_descriptor'];
        $level_active = $level['active'];
      $level_updated_by = $level['level_updated_by'];
      $level_updated_on = $level['level_updated_on'];
  }

$query_edits = $elc_db->prepare("Select * from Levels_review where level_id = ? ");
$query_edits->bind_param("s", $level_id);
$query_edits->execute();
$result_edits = $query_edits->get_result();

  while ($level_edits = $result_edits->fetch_assoc()) {
      $level_name_edits = $level_edits['level_name'];
      $level_short_name_edits = $level_edits['level_short_name'];
      $level_descriptor_edits = $level_edits['level_descriptor'];
      $level_active_edits = $level_edits['active'];
      $level_updated_by_edits = $level_edits['level_updated_by'];
      $level_updated_on_edits = $level_edits['level_updated_on'];
  }
 $level_active_label = ($level_active == 1) ? "Active" : "Inactive";
    $level_active_edits_label = ($level_active_edits == 1) ? "Active" : "Inactive"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Level Editor - <?php echo $level_name; ?></title>

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
        } );

        $(window).keydown(function(e) {
            if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) {
                /*ctrl+s or command+s*/
                save();
                e.preventDefault();
                return false;
            }
        } );
    } );

    function save() {
        level_id = <?php echo $level_id; ?>;
        level_name = '<?php echo addslashes($level_name_edits); ?>';
        level_short_name = '<?php echo addslashes($level_short_name_edits); ?>';
        level_descriptor = '<?php echo addslashes($level_descriptor_edits); ?>';
        level_active = '<?php echo $level_active_edits; ?>';
        net_id = '<?php echo $net_id; ?>';
        $.ajax({
            method: "POST",
            url: "save-level.php",
            data: {
                level_id: level_id,
                level_name: level_name,
                level_short_name: level_short_name,
                level_descriptor: level_descriptor,
                level_active: level_active,
                net_id: net_id,
                needs_review: "0",
                level_updated_by: "<?php echo $level_updated_by_edits; ?>"
            }
        } ).done(function(phpfile) {
            setReviewStatus(phpfile, "success");
        } );
    }
    </script>
    <style>
        .form-label {
  font-size: 20px;
  font-weight: 200;
  color: #333;
  margin-top: 8px;
  display: block;
}
    </style>
</head>

<body>
    <?php require_once dirname(__DIR__) . "/content/shared-shell.php"; curriculum_render_editor_header(); ?>
    <main class="container editor-main py-4">
        <?php
        curriculum_render_editor_hero('Review Queue', 'Review Level Edits', $level_name);
        curriculum_render_editor_actions('Review actions', array(
            array('id' => 'go_back', 'href' => 'index.php', 'label' => 'Back to Dashboard', 'icon' => 'bi bi-grid-3x3-gap', 'class' => 'btn btn-outline-secondary'),
            array('href' => 'level-edit.php?level_id=' . $level_id, 'label' => 'Open Editable Version', 'icon' => 'bi bi-arrow-up-right-square', 'class' => 'btn btn-outline-secondary'),
            array('id' => 'save', 'href' => null, 'label' => 'Publish Approved Changes', 'icon' => 'bi bi-check2-square', 'class' => 'btn btn-primary ms-auto'),
        ));
        ?>

        <div class="editor-save-dialog editor-status mb-3" id="save_dialog" aria-live="polite"></div>

        <section class="editor-diff-grid">
            <?php $diff = htmldiff($level_name, $level_name_edits); ?>
            <article class="editor-diff-card">
                <label for="level_name" class="form-label">Level Name</label>
                <div id="level_name" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($level_short_name, $level_short_name_edits); ?>
            <article class="editor-diff-card">
                <label for="level_short_name" class="form-label">Level Short Name</label>
                <div id="level_short_name" class='form-control'><?php echo $diff; ?></div>
            </article>

            <?php $diff = htmldiff($level_descriptor, $level_descriptor_edits); ?>
            <article class="editor-diff-card">
                <label for="level_descriptor" class="form-label">Descriptor</label>
                <div id="level_descriptor" class='form-control'><?php echo $diff; ?></div>
            </article>

            <article class="editor-diff-card">
                <label for="level_active" class="form-label">Active Status</label>
                <div id="level_active" class='form-control'><?php
                if ($level_active == $level_active_edits) {echo "Level will remain ".$level_active_label.".<br />"; }
                else { echo "Level status will change from <del>".$level_active_label."</del> to <ins>".$level_active_edits_label."</ins>.<br />"; }
                ?></div>
            </article>
        </section>
    </main>
    <?php curriculum_render_footer(array("path_prefix" => "..", "profile_path" => "editors/profile-editor.php", "include_bootstrap_bundle" => false)); ?>
</body>
</html>
