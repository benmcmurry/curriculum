<?php
$current_page = $_Post['href'];

$session_destroy();
$session_start();
$_session['status'] = "loggedIn";

echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=".$current_page."'>";

 ?>
