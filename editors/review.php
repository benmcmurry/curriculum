<?php

include_once("../../../connectFiles/connect_cis.php");
// require_once $_SERVER['DOCUMENT_ROOT'] . '/Mail.php';
include_once("cas-go.php");
if ($net_id == 'blm39' || 'karimay') {echo "cleared!";}
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
	
			while($people = $contributors_result->fetch_assoc()){
      $first_initial = substr($people['first_name'], 0,1);
			$author = $people['last_name'].", ".$first_initial.".";



	$message = "<h1>Academic Work by ".$people['first_name']." ".$people['last_name']." </h1> \n";
	$message .= "<h3>Publications</h3>\n";
	$query = $elc_db->prepare("Select * from Citations where authors like '%$author%' and type='Publication' order by year DESC");
  $query->execute();
    $result = $query->get_result();
  
			while($pubs = $result->fetch_assoc()){


			$message .= $pubs['citation']."\n";

		}

		$result->free();


$message .= "<h3>Presentations</h3> \n";

	$query = $elc_db->prepare("Select * from Citations where authors like '%$author%' and type='Presentation' order by year DESC");
  $query->execute();
    $result = $query->get_result();
   
			while($pubs = $result->fetch_assoc()){

			$message .= $pubs['citation']." \n";
		}

		$result->free();

$message .= "<h3>Thesis, Project, or Dissertation</h3> \n";

	$query = $elc_db->prepare("Select * from Citations where authors like '%$author%' and type in ('Project', 'Thesis', 'Dissertation') order by year DESC");

    $query->execute();
      $result = $query->get_result();
 
			while($pubs = $result->fetch_assoc()){

			$message .= $pubs['citation']." \n";

		}

		$result->free();


echo $message;

$body = "Dear ".$people['first_name'].",%0D%0A%0D%0A
			We are updating the list of scholarly work in the ELC profile. Please follow the link below and send me any updates or additions at your earliest convenience. We would like to have our profile up-to-date by September 1. Recent Grads, please double check that your thesis or project is listed properly.%0D%0A%0D%0A

			https://elc.byu.edu/curriculum/profile/review3.php?first_initial=".$first_initial."%26last_name=".$people['last_name']."%26first_name=".$people['first_name'];
echo "<br /><a href='mailto:".$people['email_address']."?subject=ELC Profile Update&body=".$body."'>Request Update</a>";



// Mail::sendEmail($to, $subject, $content);
// }
// else {exit;}


}
		$contributors_result->free();
?>
</div>
</body>
</html>
