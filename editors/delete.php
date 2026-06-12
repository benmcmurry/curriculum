<?php
require_once __DIR__ . '/../bootstrap.php';
include_once("../../../connectFiles/connect_cis.php");
include_once("../auth.php");

$id=$_POST['id'];

$query = $elc_db->prepare("DELETE from Citations WHERE id = ? ");
$query->bind_param("s", $id);
$query->execute();
$result = $query->get_result();

?>
