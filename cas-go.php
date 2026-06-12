<?php
require_once __DIR__ . '/bootstrap.php';

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/Web/sharedAuth/broker.php';

$currentUser = shared_auth_current_session_user();
$auth = false;
$net_id = '';
if ($currentUser) {
    $net_id = isset($currentUser['netid']) ? (string) $currentUser['netid'] : '';
    $auth = $net_id !== '';
    $logoutUrl = shared_auth_build_url_with_query(curriculum_current_url_without_auth_params(), array('logout' => '1'));
    $button = shared_auth_build_identity_button(
        isset($currentUser['name']) ? $currentUser['name'] : $net_id,
        isset($currentUser['provider']) ? $currentUser['provider'] : 'okta',
        array('Sign Out' => $logoutUrl)
    );
} else {
    $button = "<a href='" . htmlspecialchars(shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum'), ENT_QUOTES, 'UTF-8') . "'>Sign In</a>";
}

if (isset($_REQUEST['logout'])) {
    curriculum_destroy_session();
    shared_auth_redirect(shared_auth_logout_url(curriculum_current_url_without_auth_params(), 'curriculum'));
}
