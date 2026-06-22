<?php
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');
$learningExperienceId = $_POST['learningExperienceId'];




$query_final = $elc_db->prepare("DELETE FROM Learning_experiences WHERE learning_experience_id=?");
$query_final->bind_param("s", $learningExperienceId);
$query_final->execute();
$result_final = $query_final->get_result();

$query_final = $elc_db->prepare("DELETE FROM LE_courses WHERE learning_experience_id=?");
$query_final->bind_param("s", $learningExperienceId);
$query_final->execute();
$result_final = $query_final->get_result();

echo "deleted";
?>
