<?php
include_once("../../../../connectFiles/connect_cis.php");

include_once("../../cas-go.php");
$id = $_POST['id'];
$net_id = $_POST['net_id'];

$query = $elc_db->prepare("Update User_access set net_id = ? where id = ?");
$query->bind_param("ss", $net_id, $id);
$query->execute();
$result = $query->get_result();
echo "Netid Updated!"





?>