<?php
$password = $_POST['password'];
$current_page = $_POST['current_page'];

if ($password !== "curriculum")
{
echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=".$current_page."'>";
}

else {
if(!isset($_SESSION)){session_start();}
$_SESSION['password'] = "password selected";

echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=".$current_page."'>";
}
?>