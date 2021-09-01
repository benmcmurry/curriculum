<?php
include_once("../../../../connectFiles/connect_cis.php");

include_once("../../cas-go.php");
$id = $_POST['id'];
$full_name = $_POST['full_name'];

$query = $elc_db->prepare("Update User_access set full_name = ? where id = ?");
$query->bind_param("ss", $full_name, $id);
$query->execute();
$result = $query->get_result();
echo "Name Updated!"





?>