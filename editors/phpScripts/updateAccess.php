<?php
include_once("../../../../connectFiles/connect_cis.php");

include_once("../../cas-go.php");
$id = $_POST['id'];
$access = $_POST['access'];

$query = $elc_db->prepare("Update User_access set access = ? where id = ?");
$query->bind_param("ss", $access, $id);
$query->execute();
$result = $query->get_result();
echo "Access Updated!"





?>