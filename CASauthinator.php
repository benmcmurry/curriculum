<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/templateUtilities/CASAuthinator/Authenticator.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/templateUtilities/CASAuthinator/ACLSources/executive_councilACLSource.php');
Authenticator::haveLogin(new executive_councilACLSource());
?>