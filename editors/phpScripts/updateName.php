<?php
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 4) . '/private-config') . '/connectFiles/connect_cis.php');

include_once("../../auth.php");
$id = $_POST['id'];
$full_name = $_POST['full_name'];

$query = $elc_db->prepare("Update User_access set full_name = ? where id = ?");
$query->bind_param("ss", $full_name, $id);
$query->execute();
$result = $query->get_result();
echo "Name Updated!"





?>
