<?php

include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');
include_once("../auth.php");
if (in_array($net_id, array('blm39', 'karimay'), true)) {echo "cleared!";}
else {exit();}
$citation = $_POST['citation'];
$year = $_POST['year'];
$authors = $_POST['authors'];
$type = $_POST['type'];

$search = $elc_db->prepare("Select * from Citations where citation = ? ");
$search->bind_param("s", $citation);
  $search->execute();
    $result = $search->get_result();
	
			if (mysqli_num_rows($result) < 1) {
				echo "<script>console.log('it does not exist!');</script>";
				$query = $elc_db->prepare("Insert into Citations (citation, year, authors, type) Values (?, ?, ?, ?)");
				$query->bind_param("ssss", $citation, $year, $authors, $type);
				  $query->execute();
				    $result = $query->get_result();
					
						echo "Saved ".date('l jS \of F Y h:i:s A').".";
						echo "<script>$('#citation').html('');</script>";
					
			}
			else {
				echo "<script>console.log('already exists!');</script>";
			}
			





?>
