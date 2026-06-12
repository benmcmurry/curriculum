<?php
require_once __DIR__ . '/../bootstrap.php';

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/Web/sharedAuth/broker.php';

$currentUser = shared_auth_current_session_user();
if (!$currentUser) {
    shared_auth_redirect(shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum'));
}

$net_id = isset($currentUser['netid']) ? (string) $currentUser['netid'] : '';
$auth = $net_id !== '';
