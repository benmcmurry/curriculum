<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__, 2) . '/shared-ui/layout.php';

$newLevelMenuItem = '';
$coursesMenu = '';
$query = $elc_db->prepare('Select Levels.level_id, Levels.level_name, Levels.level_short_name from Levels where active=1 order by level_order ASC');
$query->execute();
$result = $query->get_result();

while ($levels = $result->fetch_assoc()) {
    $newLevelMenuItem .= "<li><a class='dropdown-item' href='levels.php#" . $levels['level_short_name'] . "'>" . $levels['level_name'] . '</a></li>';
    $coursesMenu .= "<li><a class='dropdown-item' href='levels.php#" . $levels['level_short_name'] . "'>" . $levels['level_name'] . "</a> <ul class='dropdown-menu dropdown-submenu'>";

    $course_query = $elc_db->prepare('Select Courses.course_id, Courses.course_name, Courses.level_id, Courses.course_short_name from Courses where Courses.level_id = ? order by course_order ASC');
    $course_query->bind_param('s', $levels['level_id']);
    $course_query->execute();
    $course_result = $course_query->get_result();

    while ($courses = $course_result->fetch_assoc()) {
        $courses['course_name'] = str_replace('Fluency', '', $courses['course_name']);
        $coursesMenu .= "<li><a class='dropdown-item' href='course.php?course_id=" . $courses['course_id'] . "'>" . $courses['course_name'] . '</a></li>';
    }
    $coursesMenu .= '</li></ul>';
}

$currentUser = shared_auth_current_session_user();
$displayName = $currentUser
    ? (isset($currentUser['name']) && trim((string) $currentUser['name']) !== '' ? $currentUser['name'] : (isset($currentUser['netid']) ? $currentUser['netid'] : 'Account'))
    : '';
$loginUrl = shared_auth_login_url(curriculum_current_url_without_auth_params(), 'curriculum');
$logoutUrl = shared_auth_logout_url(curriculum_current_url_without_auth_params(), 'curriculum');
$curriculumNavUserItems = array();
if ($currentUser) {
    $curriculumNavUserItems[] = array('label' => 'Profile', 'href' => 'profile.php');
    require_once __DIR__ . '/../editors/admins.php';
    if ($auth && $access) {
        $curriculumNavUserItems[] = array('label' => 'Edit', 'href' => 'editors/index.php');
    }
}

shared_ui_render_header(array(
    'brand_href' => 'index.php',
    'brand_label' => 'ELC Curriculum Portfolio',
    'brand_image' => shared_ui_asset_url('assets/img/elc.png'),
    'brand_image_alt' => 'ELC Curriculum Portfolio',
    'brand_title' => 'Curriculum Portfolio',
    'nav_items' => array(),
    'user' => $currentUser,
    'display_name' => $displayName,
    'auth_href' => $loginUrl,
    'logout_href' => $logoutUrl,
    'menu_items' => $curriculumNavUserItems,
    'sign_in_label' => 'Sign In',
    'sign_out_label' => 'Sign Out'
));
?>
<nav class="curriculum-nav navbar navbar-expand-sm sticky-top" data-bs-theme="light">
    <div class="container-lg">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#curriculumNavContent" aria-controls="curriculumNavContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="curriculumNavContent">
            <ul class="navbar-nav justify-content-between w-100">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Our Curriculum</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="levels.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">Level Descriptors</a>
                    <ul class="dropdown-menu">
                        <?php echo $newLevelMenuItem; ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Courses</a>
                    <ul class="dropdown-menu">
                        <?php echo $coursesMenu; ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <?php if ($auth && $access) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="editors/index.php">Edit</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
