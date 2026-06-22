<?php
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');
$level_id = $_POST['level_id'];
$net_id = $_POST['net_id'];
$level_name = $_POST['level_name'];
$level_short_name = $_POST['level_short_name'];
$level_descriptor = $_POST['level_descriptor'];
$level_active = $_POST['level_active'];
$needs_review = $_POST['needs_review'];
$level_updated_by = $_POST['level_updated_by'];


$query = $elc_db->prepare("UPDATE Levels_review SET needs_review=?, level_name=?, level_short_name=?, level_descriptor=?, level_updated_by=?, active=? WHERE level_id= ?");
$query->bind_param("sssssss", $needs_review, $level_name, $level_short_name, $level_descriptor, $level_updated_by, $level_active, $level_id);
$query->execute();
$result = $query->get_result();
echo (($needs_review == 0) ? 'Saved and published' : 'Saved and queued for review') . ' on ' . date('l jS \of F Y h:i:s A') . '.';

if ($needs_review == 0) {
  $query_final = $elc_db->prepare("UPDATE Levels SET level_name=?, level_short_name=?, level_descriptor=?, level_updated_by=?, active=? WHERE level_id=?");
  $query_final->bind_param("ssssss",  $level_name, $level_short_name, $level_descriptor, $level_updated_by, $level_active, $level_id);
  	$query_final->execute();
  	$result_final = $query_final->get_result();
      
}

$query_backup = $elc_db->prepare("Insert into Levels_backup (level_id, level_name, level_short_name, level_descriptor, level_updated_by, level_updated_on) Values (?, ?, ?, ?, ?, now() )");
$query_backup->bind_param("sssss", $level_id, $level_name, $level_short_name, $level_descriptor, $level_updated_by);
	$query_backup->execute();
	$result_backup = $query_backup->get_result();
