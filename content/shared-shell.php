<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__, 2) . '/shared-ui/layout.php';

if (!function_exists('curriculum_shell_current_user')) {
    function curriculum_shell_current_user() {
        return shared_auth_current_session_user();
    }
}

if (!function_exists('curriculum_shell_display_name')) {
    function curriculum_shell_display_name($currentUser) {
        if (!$currentUser) {
            return '';
        }

        if (isset($currentUser['name']) && trim((string) $currentUser['name']) !== '') {
            return trim((string) $currentUser['name']);
        }

        return isset($currentUser['netid']) ? (string) $currentUser['netid'] : 'Account';
    }
}

if (!function_exists('curriculum_shell_path')) {
    function curriculum_shell_path($pathPrefix, $path) {
        if ($pathPrefix === '') {
            return $path;
        }

        return rtrim($pathPrefix, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('curriculum_shell_user_can_edit')) {
    function curriculum_shell_user_can_edit() {
        global $elc_db, $net_id;

        if (!isset($elc_db) || !$elc_db || !isset($net_id) || trim((string) $net_id) === '') {
            return false;
        }

        $query = $elc_db->prepare("Select * from User_access where net_id=? and access='admin'");
        if (!$query) {
            return false;
        }

        $query->bind_param("s", $net_id);
        $query->execute();
        $result = $query->get_result();

        return $result && mysqli_num_rows($result) > 0;
    }
}

if (!function_exists('curriculum_render_site_header')) {
    function curriculum_render_site_header() {
        $currentUser = curriculum_shell_current_user();
        $displayName = curriculum_shell_display_name($currentUser);
        $loginUrl = shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum');
        $logoutUrl = shared_auth_logout_url(curriculum_current_url_without_auth_params(), 'curriculum');
        $curriculumNavItems = array(
            array('label' => 'Home', 'href' => 'index.php'),
            array('label' => 'Levels', 'href' => 'levels.php'),
            array('label' => 'Courses', 'href' => 'courses.php'),
            array('label' => 'Profile', 'href' => 'profile.php'),
        );
        $curriculumNavUserItems = array();

        if ($currentUser) {
            $curriculumNavUserItems[] = array('label' => 'Profile', 'href' => 'profile.php');
            if (curriculum_shell_user_can_edit()) {
                $curriculumNavUserItems[] = array('label' => 'Edit', 'href' => 'editors/index.php');
            }
        }

        shared_ui_render_header(array(
            'brand_href' => 'index.php',
            'brand_label' => 'ELC Curriculum Portfolio',
            'brand_image' => shared_ui_asset_url('assets/img/elc.png'),
            'brand_image_alt' => 'ELC Curriculum Portfolio',
            'brand_title' => 'Curriculum Portfolio',
            'nav_items' => $curriculumNavItems,
            'user' => $currentUser,
            'display_name' => $displayName,
            'auth_href' => $loginUrl,
            'logout_href' => $logoutUrl,
            'menu_items' => $curriculumNavUserItems,
            'sign_in_label' => 'Login',
            'sign_out_label' => 'Logout',
        ));
    }
}

if (!function_exists('curriculum_render_editor_header')) {
    function curriculum_render_editor_header(array $options = array()) {
        $currentUser = curriculum_shell_current_user();
        $displayName = curriculum_shell_display_name($currentUser);
        $loginUrl = shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum');
        $logoutUrl = shared_auth_logout_url(curriculum_current_url_without_auth_params(), 'curriculum');
        $homePathPrefix = isset($options['home_path_prefix']) ? (string) $options['home_path_prefix'] : '..';
        $editorPathPrefix = isset($options['editor_path_prefix']) ? (string) $options['editor_path_prefix'] : '';
        $curriculumEditorMenuItems = array(
            array('label' => 'Back to Portfolio', 'href' => curriculum_shell_path($homePathPrefix, 'index.php')),
            array('label' => 'Access Table', 'href' => curriculum_shell_path($editorPathPrefix, 'users.php')),
        );

        if ($currentUser) {
            $curriculumEditorMenuItems[] = array('label' => 'Profile', 'href' => curriculum_shell_path($editorPathPrefix, 'profile-editor.php'));
        }

        shared_ui_render_header(array(
            'brand_href' => curriculum_shell_path($homePathPrefix, 'index.php'),
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
            'sign_out_label' => 'Logout',
        ));
    }
}

if (!function_exists('curriculum_render_footer')) {
    function curriculum_render_footer(array $options = array()) {
        $pathPrefix = isset($options['path_prefix']) ? (string) $options['path_prefix'] : '';
        $profilePath = isset($options['profile_path']) ? (string) $options['profile_path'] : 'profile.php';
        $includeBootstrapBundle = !isset($options['include_bootstrap_bundle']) || (bool) $options['include_bootstrap_bundle'];
        $currentUser = curriculum_shell_current_user();

        shared_ui_render_footer(array(
            'columns' => array(
                array(
                    'title' => 'Curriculum',
                    'items' => array(
                        array('label' => 'Our Curriculum', 'href' => curriculum_shell_path($pathPrefix, 'index.php')),
                        array('label' => 'Level Descriptors', 'href' => curriculum_shell_path($pathPrefix, 'levels.php')),
                        array('label' => 'Resources', 'href' => curriculum_shell_path($pathPrefix, 'resources.php')),
                    ),
                ),
                array(
                    'title' => 'Support',
                    'items' => array(
                        array('label' => 'Profile', 'href' => curriculum_shell_path($pathPrefix, $profilePath)),
                        array(
                            'label' => $currentUser ? 'Logout' : 'Login',
                            'href' => $currentUser
                                ? shared_auth_logout_url(curriculum_current_url_without_auth_params(), 'curriculum')
                                : shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum'),
                        ),
                    ),
                ),
                array(
                    'title' => 'English Language Center',
                    'items' => array(
                        array('label' => 'BYU', 'href' => 'https://www.byu.edu'),
                        array('label' => 'Curriculum Portfolio'),
                    ),
                ),
            ),
            'note' => 'Copyright &copy; ' . date('Y') . '. English Language Center',
        ));

        if ($includeBootstrapBundle) {
            echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez3pr6x5MlQ1ZAGC+nuBZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>';
        }
    }
}
