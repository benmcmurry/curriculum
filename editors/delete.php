<?php

session_start();
include_once("../../../connectFiles/connect_cis.php");
include_once("../cas-go.php");

$id=$_POST['id'];

$query = $elc_db->prepare("DELETE from Citations WHERE id = ? ");
$query->bind_param("s", $id);
$query->execute();
$result = $query->get_result();

?>