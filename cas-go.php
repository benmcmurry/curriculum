<?php
// Load the settings from the central config file
require_once dirname($_SERVER['DOCUMENT_ROOT']) .'/config.php';
// Load the CAS lib
require_once dirname($_SERVER['DOCUMENT_ROOT']) .'/CAS.php';
// Enable debugging
phpCAS::setDebug();
// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(true);

// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
if (isset($_REQUEST['logout'])) {
  if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $redirect = $_SERVER['SERVER_NAME']."/~Ben/curriculum/";
  } else {$redirect = $_SERVER['SERVER_NAME']."/curriculum/";}
    phpCAS::logout();
}
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}
if (isset($_REQUEST['login'])) {
    phpCAS::forceAuthentication();
}

$auth = phpCAS::checkAuthentication();
if (isset($course_id)) {$additional ="&course_id=$course_id";} else {$additional="";}
if ($auth) {

  $net_id = phpCAS::getUser();


  $button = phpCAS::getAttributes()['name']." | <a href='?logout='>Sign Out</a>";;
} else {
  $button = "<a href='?login='>Sign In</a>";

}
?>
