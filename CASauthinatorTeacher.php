<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/templateUtilities/CASAuthinator/Authenticator.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/templateUtilities/CASAuthinator/ACLSources/TeachersACLSource.php');
Authenticator::haveLogin(new TeacherACLSource());


?>
