<?php

include_once("../../../connectFiles/connect_cis.php");

include_once("cas-go.php");
if ($net_id == 'blm39') {echo "cleared!";}
else {exit();}
?>

<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
	<title>Scholarly Work Review</title>
	<meta name="description" content="" />
  	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<!-- 	Style Sheet and Font info -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Martel:400,200' rel='stylesheet' type='text/css'>
	<link href="review_style.css" rel="stylesheet" type="text/css" />

<!-- 	Javascript Includes -->
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/js.js"></script>
	<link rel="stylesheet" type="text/css" href="profile/datatables.min.css"/>
 	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
</head>
<body>
<div id="main">
	<?php
		$contributors = $elc_db->prepare("Select * from Contributors");
    $contributors->execute();
  $contributors_result = $contributors->get_result();
		// if(!$contributors_result = $elc_db->query($contributors)){
		// 	die('There was an error running the query [' . $elc_db->error . ']');
		// }
			while($people = $contributors_result->fetch_assoc()){
      $first_initial = substr($people['first_name'], 0,1);
			$author = $people['last_name'].", ".$first_initial.".";



	$message = "<h1>Academic Work by ".$people['first_name']." ".$people['last_name']." </h1>";
	$message .= "<h3>Publications</h3>";
	$query = $elc_db->prepare("Select * from Citations where authors like '%?%' and type='Publication' order by year DESC");
  $query->bind_param("s", $author);
  $query->execute();
    $result = $query->get_result();
    if(!$result = $elc_db->query($query)){
			die('There was an error running the query [' . $elc_db->error . ']');
		}
			while($pubs = $result->fetch_assoc()){


			$message .= $pubs['citation'];

		}

		$result->free();


$message .= "<h3>Presentations</h3>";

	$query = $elc_db->prepare("Select * from Citations where authors like '%?%' and type='Presentation' order by year DESC");
  $query->bind_param("s", $author);
  $query->execute();
    $result = $query->get_result();
    	if(!$result = $elc_db->query($query)){
			die('There was an error running the query [' . $elc_db->error . ']');
		}
			while($pubs = $result->fetch_assoc()){

			$message .= $pubs['citation'];
		}

		$result->free();

$message .= "<h3>Thesis, Project, or Dissertation</h3>";

	$query = $elc_db->prepare("Select * from Citations where authors like '%?%' and type in ('Project', 'Thesis', 'Dissertation') order by year DESC");
  $query->bind_param("s", $author);
    $query->execute();
      $result = $query->get_result();
  if(!$result = $elc_db->query($query)){
			die('There was an error running the query [' . $elc_db->error . ']');
		}
			while($pubs = $result->fetch_assoc()){

			$message .= $pubs['citation'];

		}

		$result->free();


echo $message;

$to      = $people['email_address'].", ben_mcmurry@byu.edu";
$to = "ben_mcmurry@byu.edu";
$subject = "ELC Profile Update Request";
$content = "<html><body><p>".$people['first_name']." ".$author.",</p>".
			"<p>We are updating the list of scholarly work in the ELC profile. Please examine the list below and send me any updates or additions By January 17th, 2017. Recent Grads, please double check that your thesis or project is listed properly.

			If you are no longer in a position where you are producing scholarly work connected to the ELC, please email me and I will remove you from this mailing list. Thanks.</p>".$message."</body><html>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: ben_mcmurry@byu.edu'. "\r\n";

mail($to, $subject, $content, $headers);


}
		$contributors_result->free();
?>
</div>
</body>
</html>
