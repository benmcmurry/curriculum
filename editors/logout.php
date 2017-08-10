<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/templateUtilities/CASAuthinator/CASAuthenticator.php');
if (isset($_GET['logout']))  {
	CASAuthenticator::getInstance()->logout();
}

?>
