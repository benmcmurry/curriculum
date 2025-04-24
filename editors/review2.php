<?php
header("Content-type: application/text");
header("Content-Disposition: attachment; filename=proposal.csv");
header("Pragma: no-cache");
header("Expires: 0");
include_once("../../../connectFiles/connect_cis.php");
// require_once $_SERVER['DOCUMENT_ROOT'] . '/Mail.php';
include_once("../cas-go.php");
if ($net_id == 'blm39'|| 'karimay') {echo "cleared!";}
else {exit();}
?>

	<?php
    
    $csv='';
		$contributors = $elc_db->prepare("Select * from Contributors");
    $contributors->execute();
  $contributors_result = $contributors->get_result();
	
			while($people = $contributors_result->fetch_assoc()){
      $first_initial = substr($people['first_name'], 0,1);
			$author = $people['last_name'].", ".$first_initial.".";
                // $csv = $csv.$people['first_name'].";".$people['last_name'].";". $people['email_address'].";";


	$message = "<h3>Publications</h3>";
	$query = $elc_db->prepare("Select * from Citations where authors like '%$author%' and type='Publication' order by year DESC");
  $query->execute();
    $result = $query->get_result();
  
			while($pubs = $result->fetch_assoc()){


			$message .= $pubs['citation'];

		}

		$result->free();


$message .= "<h3>Presentations</h3>";

	$query = $elc_db->prepare("Select * from Citations where authors like '%$author%' and type='Presentation' order by year DESC");
  $query->execute();
    $result = $query->get_result();
   
			while($pubs = $result->fetch_assoc()){

			$message .= $pubs['citation'];
		}

		$result->free();

$message .= "<h3>Thesis, Project, or Dissertation</h3>";

	$query = $elc_db->prepare("Select * from Citations where authors like '%$author%' and type in ('Project', 'Thesis', 'Dissertation') order by year DESC");

    $query->execute();
      $result = $query->get_result();
 
			while($pubs = $result->fetch_assoc()){

			$message .= $pubs['citation'];

		}

		$result->free();


// echo $message;
$out = fopen('php://output', 'w');
fputcsv($out, array($csv.$people['first_name'], $people['last_name'], $people['email_address'], $message));
fclose($out);

$message='';
$csv = '';


}
        $contributors_result->free();
?>