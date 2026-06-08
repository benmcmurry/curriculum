<?php
require_once __DIR__ . '/../bootstrap.php';

require_once '../config.php';
require_once '../CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setFixedServiceURL(curriculum_current_url_without_auth_params());
phpCAS::setNoCasServerValidation();

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}

$auth = phpCAS::checkAuthentication();
if ($auth) {
    $net_id = phpCAS::getUser();
} else {
    phpCAS::forceAuthentication();
}
