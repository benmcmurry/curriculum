<?php
include_once("../../../connectFiles/connect_cis.php");
$level_id = $_POST['level_id'];
$net_id = $_POST['net_id'];
$level_name = $_POST['level_name'];
$level_short_name = $_POST['level_short_name'];
$level_descriptor = $_POST['level_descriptor'];
$needs_review = $_POST['needs_review'];
$level_updated_by = $_POST['level_updated_by'];


$level_descriptor = $db ->real_escape_string($level_descriptor);

$query = "UPDATE Levels_review SET needs_review='$needs_review', level_name='$level_name', level_short_name='$level_short_name', level_descriptor='$level_descriptor', level_updated_by='$level_updated_by' WHERE level_id=$level_id";
        if (!$result = $db->query($query)) {
            die('There was an error running the query [' . $db->error . ']');
        } else {
            echo "Saved ".date('l jS \of F Y h:i:s A').".";
        }
if ($needs_review == 0) {
  $query_final = "UPDATE Levels SET level_name='$level_name', level_short_name='$level_short_name', level_descriptor='$level_descriptor', level_updated_by='$level_updated_by' WHERE level_id=$level_id";
          if (!$result_final = $db->query($query_final)) {
              die('There was an error running the query [' . $db->error . ']');
          } else {
              echo "Saved ".date('l jS \of F Y h:i:s A').".";
          }
}

$query_backup = "Insert into Levels_backup (level_id, level_name, level_short_name, level_descriptor, level_updated_by, level_updated_on) Values ('$level_id', '$level_name', '$level_short_name', '$level_descriptor', '$level_updated_by', now() )";
if (!$result_backup = $db->query($query_backup)) {
    die('There was an error running the query [' . $db->error . ']');
}
