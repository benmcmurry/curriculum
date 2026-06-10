<?php
require_once __DIR__ . '/bootstrap.php';

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/Web/sharedAuth/broker.php';

$authState = shared_auth_cas_optional_authentication(curriculum_current_url_without_auth_params());
$auth = $authState['auth'];
if ($auth) {
    $identity = $authState['identity'];
    $net_id = isset($identity['netid']) ? $identity['netid'] : '';
    $button = shared_auth_build_identity_button(
        isset($identity['name']) ? $identity['name'] : $net_id,
        isset($identity['provider']) ? $identity['provider'] : 'cas',
        array('Sign Out' => '?logout=')
    );
} else {
    $button = "<a href='?login='>Sign In</a>";
}
