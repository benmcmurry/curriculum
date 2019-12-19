<?php
include_once("../../../connectFiles/connect_cis.php");
$learningExperienceId = $_POST['learningExperienceId'];
$net_id =  $_POST['net_id'];
$name =  $_POST['name'];
$description = $_POST['description'];
$short_description = $_POST['short_description'];
$emphasis = $_POST['emphasis'];
echo "Saved ".date('l jS \of F Y h:i:s A').".";


$query_final = $elc_db->prepare("UPDATE Learning_experiences SET name=?, short_description=?, description=?, emphasis=?, updated_by=? WHERE learning_experience_id=?");
$query_final->bind_param("ssssss", $name,$short_description, $description, $emphasis, $net_id, $learningExperienceId);
$query_final->execute();
$result_final = $query_final->get_result();

$query_backup = $elc_db->prepare("Insert into Learning_experiences_backup (learning_experience_id, name, short_description, description, emphasis, updated_by, updated_on) Values (?,?,?,?,?,?,now())");
$query_backup->bind_param("ssssss", $learningExperienceId, $name, $short_description, $description, $emphasis, $net_id);
$query_backup->execute();
$result_backup = $query_backup->get_result();
