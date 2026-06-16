<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__, 2) . '/shared-ui/layout.php';

$currentUser = shared_auth_current_session_user();
$displayName = $currentUser
    ? (isset($currentUser['name']) && trim((string) $currentUser['name']) !== '' ? $currentUser['name'] : (isset($currentUser['netid']) ? $currentUser['netid'] : 'Account'))
    : '';
$loginUrl = shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum');
$logoutUrl = shared_auth_logout_url(curriculum_current_url_without_auth_params(), 'curriculum');
$curriculumEditorMenuItems = array(
    array('label' => 'Back to Portfolio', 'href' => '../index.php'),
    array('label' => 'Access Table', 'href' => 'users.php')
);

if ($currentUser) {
    $curriculumEditorMenuItems[] = array('label' => 'Profile', 'href' => 'profile-editor.php');
}

shared_ui_render_header(array(
    'brand_href' => '../index.php',
    'brand_label' => 'ELC Curriculum Portfolio',
    'brand_image' => shared_ui_asset_url('assets/img/elc.png'),
    'brand_image_alt' => 'ELC Curriculum Portfolio',
    'brand_title' => 'Curriculum Portfolio',
    'nav_items' => array(),
    'user' => $currentUser,
    'display_name' => $displayName,
    'auth_href' => $loginUrl,
    'logout_href' => $logoutUrl,
    'menu_items' => $curriculumEditorMenuItems,
    'sign_in_label' => 'Login',
    'sign_out_label' => 'Logout'
));
