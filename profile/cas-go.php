<?php
require_once __DIR__ . '/../bootstrap.php';

require_once curriculum_shared_auth_broker_path();

$currentUser = shared_auth_current_session_user();
if (!$currentUser) {
    shared_auth_redirect(shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum'));
}

$net_id = isset($currentUser['netid']) ? (string) $currentUser['netid'] : '';
$auth = $net_id !== '';
