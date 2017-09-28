<?php


include_once("../../../connectFiles/connect_cis.php");
if ($local == 0) {
    include_once("../CASauthinator.php");
    $net_id = Authenticator::getUser();
} else {
    $net_id = "blm39";
}
if ($net_id == 'blm39') {echo "cleared!";}
else {exit();}
$id=$_POST['id'];
$citation = $_POST['citation'];
$year = $_POST['year'];
$authors = $_POST['authors'];
$type = $_POST['type'];


echo "<script>console.log('it does not exist!');</script>";
$query = $elc_db->prepare("UPDATE Citations SET citation = ? , year = ?, authors = ?, type = ? WHERE id = ? ");
$query->bind_param("sssss", $citation, $year, $authors, $type, $id);
$query->execute();
$result = $query->get_result();

		echo "Saved ".date('l jS \of F Y h:i:s A').".";
		echo "<Script>close_popup();</script>";









?>
