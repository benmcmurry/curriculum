<?php
include_once("../../../../connectFiles/connect_cis.php");

include_once("../../cas-go.php");
$id = $_POST['id'];


$query = $elc_db->prepare("Delete from User_access where id=?");
$query->bind_param("s", $id);
$query->execute();
$result = $query->get_result();
echo "User Removed.";





?>