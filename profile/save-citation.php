<?php
include_once("../CASauthinator.php");

include_once("../../../connectFiles/connect_cis.php");
$citation =$db->real_escape_string($_POST['citation']);
$year = $_POST['year'];
$authors = $_POST['authors'];
$type = $_POST['type'];

$search = $db->prepare("Select * from Citations where citation = ? ");
$search->bind_param("s", $citation);
  $search->execute();
    $result = $search->get_result();
		if(!$result = $db->query($search)){
			die('There was an error running the query [' . $db->error . ']');
		}
		else {

			if (mysqli_num_rows($result) < 1) {
				echo "<script>console.log('it does not exist!');</script>";
				$query = $db->prepare("Insert into Citations (citation, year, authors, type) Values (?, ?, ?, ?)");
				$query->bind_param("sss", $citation, $year, $authors, $type);
				  $query->execute();
				    $result = $query->get_result();
					if(!$results = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');
					}
					else {
						echo "Saved ".date('l jS \of F Y h:i:s A').".";
						echo "<script>$('#citation').html('');</script>";
					}
			}
			else {
				echo "<script>console.log('already exists!');</script>";
			}
			}





?>
