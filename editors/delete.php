<?php
require_once __DIR__ . '/../bootstrap.php';
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');
include_once("../auth.php");

$id=$_POST['id'];

$query = $elc_db->prepare("DELETE from Citations WHERE id = ? ");
$query->bind_param("s", $id);
$query->execute();
$result = $query->get_result();

?>
