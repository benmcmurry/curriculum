<?php

include_once("../../../connectFiles/connect_cis.php");

$first_initial = $_GET['first_initial'];
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
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

			$author = $last_name.", ".$first_initial.".";



	$message = "<h1>Academic Work by ".$first_name." ".$last_name." </h1> \n";
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

?>
</div>
</body>
</html>
