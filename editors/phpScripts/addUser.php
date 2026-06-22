<?php
error_reporting( E_ALL ); 
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 4) . '/private-config') . '/connectFiles/connect_cis.php');

include_once("../../auth.php");
$net_id = $_POST['net_id'];
$full_name = $_POST['full_name'];
$access = $_POST['access'];

$query = $elc_db->prepare("Insert into User_access (net_id, full_name, access) Values (?,?,?)");
$query->bind_param("sss", $net_id, $full_name, $access);
$query->execute();
$result = $query->get_result();
echo "$full_name has been given $access access with the netid of $net_id. <a style='color:blue; cursor:pointer' onclick='location.reload()'>Click here to refresh</a>";





?>
