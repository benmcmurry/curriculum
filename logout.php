<?php
	session_start();
	session_unset(); 

	session_destroy(); 
	
$current_page = $_GET['current_page'];


echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=".$current_page."'>";

	?>
	