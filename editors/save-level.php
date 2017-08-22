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

$query = $db->prepare("UPDATE Levels_review SET needs_review=?, level_name=?, level_short_name=?, level_descriptor=?, level_updated_by=? WHERE level_id= ?");
$query->bind_param("ssssss", $needs_review, $level_name, $level_short_name, $level_descriptor, $level_updated_by, $level_id);
	$query->execute();
	$result = $query->get_result();
						print_r($result);
            echo "Saved ".date('l jS \of F Y h:i:s A').".";

if ($needs_review == 0) {
  $query_final = $db->prepare("UPDATE Levels SET level_name=?, level_short_name=?, level_descriptor=?, level_updated_by=? WHERE level_id=?");
  $query_final->bind_param("sssss",  $level_name, $level_short_name, $level_descriptor, $level_updated_by, $level_id);
  	$query_final->execute();
  	$result_final = $query_final->get_result();

          if (!$result_final = $db->query($query_final)) {
              die('There was an error running the query [' . $db->error . ']');
          } else {
              echo "Saved ".date('l jS \of F Y h:i:s A').".";
          }
}

$query_backup = $db->prepare("Insert into Levels_backup (level_id, level_name, level_short_name, level_descriptor, level_updated_by, level_updated_on) Values (?, ?, ?, ?, ?, now() )");
$query_backup->bind_param("sssss", $level_id, $level_name, $level_short_name, $level_descriptor, $level_updated_by);
	$query_backup->execute();
	$result_backup = $query_backup->get_result();
