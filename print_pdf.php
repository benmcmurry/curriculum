<?php
include_once("../../connectFiles/connect_cis.php");
$level_id=$_GET['print_id'];

$year = date("Y");
$download_date = date("F\ j\,\ Y");
            

function convertLinks($inputString) {
    if (strpos($_SERVER["SERVER_NAME"], 'elc.byu.edu')) {$server = 'href="https://'.$_SERVER["SERVER_NAME"].'/curriculum/';}
    else {$server = 'href="http://'.$_SERVER["SERVER_NAME"].'/';}
    
    return str_replace('href="', $server, $inputString);
}

// Include autoloader
require_once 'dompdf/autoload.inc.php';

// Reference the Dompdf namespace
use Dompdf\Dompdf;

// Instantiate and use the dompdf class
$dompdf = new Dompdf();
$query = $elc_db->prepare("Select * from Levels where level_id=?");
$query->bind_param("s",$level_id);
$query->execute();
$result = $query->get_result();
$level = $result->fetch_assoc();
$html = "<!DOCTYPE html>
<html lang=''>
<head>
	<title>".$level['level_name']." Level Descriptor</title>

<!-- 	Meta Information -->
	<meta charset='utf-8'>
	<meta name='description' content='This section of the ELC website outlines the ELC curriculum.' />
	<meta name='keywords' content='ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes' />
	<meta name='robots' content='ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes' />
    <link href='pdfStyle.css' rel='stylesheet' type='text/css' />


</head>
<body>

<footer>
<table>
    <tr>
        <td align='left' width='33%'>
            <a href='https://elc.byu.edu/curriculum/'>https://elc.byu.edu/curriculum/</a>
        </td>
        <td align='center' width='33%'>
            &copy; $year. English Language Center
        </td>
        <td align='right' width='33%'>
            Downloaded: $download_date
        </td>
    </tr>
</table>
</footer>
<header>
<table>
    <tr>
        
        <td>
        <h1>".$level['level_name']."</h1>
        <h1>Level Descriptor</h1>
            
        </td>
        <td style=';width:200px'>
            <img width='200px' src='".$_SERVER["DOCUMENT_ROOT"]."/curriculum/images/box-logo.jpg' />
        </td>
    </tr>

<table>
    


</header>";
$parts = explode("<h3>Reading", $level['level_descriptor']);
$html.="<article><div style='page-break-after: always;'>".$parts[0]."</div>
<h1>".$level['level_name']." Level Descriptor, Page 2</h1>

<h3>Reading".$parts[1]."</article></body></html>";

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($level['level_name']." Level Descriptor");
exit;
?>
