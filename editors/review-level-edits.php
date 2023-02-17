<?php
include_once("../../../connectFiles/connect_cis.php");
include_once("cas-go.php");

$level_id = $_GET['level_id'];

$query = $elc_db->prepare("Select * from Levels where level_id = ? ");
$query->bind_param("s", $level_id);
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
	$diff = diff(preg_split("/([\s]+)/", $old), preg_split("/([\s]+)/", $new));
// print_r($diff);
    foreach($diff as $k){
        if(is_array($k))
            $ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').
                (!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
        else $ret .= $k . ' ';
    }
	return $ret;
}

  while ($level = $result->fetch_assoc()) {
      $level_name = $level['level_name'];
      $level_short_name = $level['level_short_name'];
      $level_descriptor = $level['level_descriptor'];
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
      $level_updated_by_edits = $level_edits['level_updated_by'];
      $level_updated_on_edits = $level_edits['level_updated_on'];
  }

?>

<!DOCTYPE html>
<html lang="">

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


        $("#save").click(function() {
            save();
        });



        $(window).keydown(function(e) {
            if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) {
                /*ctrl+s or command+s*/
                save();
                e.preventDefault();
                return false;
            }
        });

    });

    function save() {
        level_id = <?php echo $level_id; ?>;
        level_name = '<?php echo addslashes($level_name_edits); ?>';
        level_short_name = '<?php echo addslashes($level_short_name_edits); ?>';
        level_descriptor = '<?php echo addslashes($level_descriptor_edits); ?>';

        net_id = '<?php echo $net_id; ?>';
        $.ajax({
            method: "POST",
            url: "save-level.php",
            data: {
                level_id: level_id,
                level_name: level_name,
                level_short_name: level_short_name,
                level_descriptor: level_descriptor,
                net_id: net_id,
                needs_review: "0",
                level_updated_by: "<?php echo $level_updated_by_edits; ?>"

            }
        }).done(function(phpfile) {
            $("#save_dialog").html(phpfile);
        });
    }
    </script>
</head>

<body>
    <?php require_once("../content/header-short.php"); ?>
    <div id="title" class="container-fluid">
        Review Level Edits: <?php echo $level_name; ?>
    </div>
    <div class="container-md sticky-top pt-5 mb-2">
        <div class="row justify-content-between">
            <div class="btn-group col-3" role="group">
                <a type="button" class="btn btn-primary" id="go_back" href="index.php"><i class="bi bi-pencil"></i>
                    Editor Menu</a>
            </div>

            <div class="btn-group col-3" role="group">
                <a type="button" class="btn btn-primary" href="level-edit.php?level_id=<?php echo $level_id;?>"><i
                        class="bi bi-pencil"></i> Edit</a>
                <a type="button" class="btn btn-primary" id="save"><i class="bi bi-server"></i> Save</a>
            </div>
        </div>

    </div>

    <div class="container-md pt-4" id="save_dialog"></div>
    <div class="container-md pt-4">
        <div class="container-md pt-4">

            <?php $diff = htmldiff($level_name, $level_name_edits);	?><div class="block">
                <label for="level_name" class="form-label">Level Name</label>
                <div id="level_name"> <?php echo $diff; ?></div>
                <?php $diff = htmldiff($level_short_name, $level_short_name_edits);	?>
                <label for="level_short_name" class="form-label">Level Short Name</label>
                <div id="level_short_name"> <?php echo $diff; ?></div>
                <?php $diff = htmldiff($level_descriptor, $level_descriptor_edits);	?>
                <label for="level_descriptor" class="form-label">Descriptor</label>
                <div id="level_descriptor"> <?php echo $diff; ?></div>

            </div>
</body>

</html>