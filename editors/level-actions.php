<?php
require_once __DIR__ . '/../bootstrap.php';
require_once (getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/admins.php';
require_once __DIR__ . '/level_management_helpers.php';

header('Content-Type: application/json; charset=utf-8');
if (!$auth || !$access || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    echo json_encode(array('ok' => false, 'message' => 'Administrator access is required.'));
    exit;
}

try {
    $action = isset($_POST['action']) ? (string) $_POST['action'] : '';
    if ($action === 'move') {
        $levelId = filter_input(INPUT_POST, 'level_id', FILTER_VALIDATE_INT);
        $direction = isset($_POST['direction']) ? (string) $_POST['direction'] : '';
        if (!$levelId || !in_array($direction, array('up', 'down'), true)) {
            throw new RuntimeException('Choose a valid level and direction.');
        }
        $current = $elc_db->prepare('SELECT level_order, program FROM Levels WHERE level_id = ?');
        $current->bind_param('i', $levelId);
        $current->execute();
        $currentLevel = $current->get_result()->fetch_assoc();
        if (!$currentLevel) {
            throw new RuntimeException('That level was not found.');
        }
        $operator = $direction === 'up' ? '<' : '>';
        $sort = $direction === 'up' ? 'DESC' : 'ASC';
        $neighbor = $elc_db->prepare('SELECT level_id, level_order FROM Levels WHERE program = ? AND level_order ' . $operator . ' ? ORDER BY level_order ' . $sort . ' LIMIT 1');
        $neighbor->bind_param('si', $currentLevel['program'], $currentLevel['level_order']);
        $neighbor->execute();
        $other = $neighbor->get_result()->fetch_assoc();
        if (!$other) {
            throw new RuntimeException('That level is already at the edge of its program.');
        }
        $elc_db->begin_transaction();
        $swap = $elc_db->prepare('UPDATE Levels SET level_order = CASE level_id WHEN ? THEN ? WHEN ? THEN ? END WHERE level_id IN (?, ?)');
        $swap->bind_param('iiiiii', $levelId, $other['level_order'], $other['level_id'], $currentLevel['level_order'], $levelId, $other['level_id']);
        $swap->execute();
        $reviewSwap = $elc_db->prepare('UPDATE Levels_review SET level_order = CASE level_id WHEN ? THEN ? WHEN ? THEN ? END WHERE level_id IN (?, ?)');
        $reviewSwap->bind_param('iiiiii', $levelId, $other['level_order'], $other['level_id'], $currentLevel['level_order'], $levelId, $other['level_id']);
        $reviewSwap->execute();
        $backupSwap = $elc_db->prepare('INSERT INTO Levels_backup (level_id, level_order, program, level_short_name, level_name, level_descriptor, active, level_updated_by, level_updated_on, shared_user_id) SELECT level_id, level_order, program, level_short_name, level_name, level_descriptor, active, level_updated_by, NOW(), shared_user_id FROM Levels WHERE level_id IN (?, ?)');
        $backupSwap->bind_param('ii', $levelId, $other['level_id']);
        $backupSwap->execute();
        $elc_db->commit();
        echo json_encode(array('ok' => true, 'message' => 'Level order updated.'));
        exit;
    }
    if ($action === 'archive' || $action === 'restore') {
        $levelId = filter_input(INPUT_POST, 'level_id', FILTER_VALIDATE_INT);
        if (!$levelId) {
            throw new RuntimeException('Choose a valid level.');
        }
        $active = $action === 'restore' ? 1 : 0;
        $elc_db->begin_transaction();
        $levelUpdate = $elc_db->prepare('UPDATE Levels SET active = ?, level_updated_by = ? WHERE level_id = ?');
        $levelUpdate->bind_param('isi', $active, $net_id, $levelId);
        $levelUpdate->execute();
        if ($levelUpdate->affected_rows === 0) {
            throw new RuntimeException('That level was not found.');
        }
        $courseUpdate = $elc_db->prepare('UPDATE Courses SET active = ?, updated_by = ? WHERE level_id = ?');
        $courseUpdate->bind_param('isi', $active, $net_id, $levelId);
        $courseUpdate->execute();
        $reviewUpdate = $elc_db->prepare('UPDATE Levels_review SET active = ?, level_updated_by = ?, needs_review = 0 WHERE level_id = ?');
        $reviewUpdate->bind_param('isi', $active, $net_id, $levelId);
        $reviewUpdate->execute();
        $backup = $elc_db->prepare('INSERT INTO Levels_backup (level_id, level_order, program, level_short_name, level_name, level_descriptor, active, level_updated_by, level_updated_on, shared_user_id) SELECT level_id, level_order, program, level_short_name, level_name, level_descriptor, active, level_updated_by, NOW(), shared_user_id FROM Levels WHERE level_id = ?');
        $backup->bind_param('i', $levelId);
        $backup->execute();
        $elc_db->commit();
        echo json_encode(array('ok' => true, 'message' => $active ? 'Level and courses restored.' : 'Level and courses archived.'));
        exit;
    }

    if ($action !== 'create') {
        throw new RuntimeException('Unsupported level action.');
    }
    $program = isset($_POST['program']) ? (string) $_POST['program'] : '';
    $levelName = trim((string) ($_POST['level_name'] ?? ''));
    $shortName = trim((string) ($_POST['level_short_name'] ?? ''));
    $descriptor = (string) ($_POST['level_descriptor'] ?? '');
    $active = isset($_POST['active']) && $_POST['active'] === '0' ? 0 : 1;
    $templateId = filter_input(INPUT_POST, 'template_level_id', FILTER_VALIDATE_INT);
    if (!in_array($program, array('full_time', 'part_time'), true) || $levelName === '' || !preg_match('/^[A-Za-z0-9_-]{1,32}$/', $shortName)) {
        throw new RuntimeException('Enter a program, level name, and a unique short name using letters, numbers, hyphens, or underscores.');
    }
    if ($program === 'full_time' && !$templateId) {
        throw new RuntimeException('Choose a Full-time level template.');
    }
    $duplicate = $elc_db->prepare('SELECT level_id FROM Levels WHERE level_name = ? OR level_short_name = ? LIMIT 1');
    $duplicate->bind_param('ss', $levelName, $shortName);
    $duplicate->execute();
    if ($duplicate->get_result()->fetch_assoc()) {
        throw new RuntimeException('The level name or short name is already in use.');
    }

    $elc_db->begin_transaction();
    $orderResult = $elc_db->query('SELECT COALESCE(MAX(level_order), 0) + 1 AS next_order FROM Levels');
    $levelOrder = (int) $orderResult->fetch_assoc()['next_order'];
    $levelValues = array('level_name' => $levelName, 'level_short_name' => $shortName, 'level_descriptor' => $descriptor, 'level_updated_by' => $net_id, 'active' => $active, 'level_order' => $levelOrder, 'program' => $program);
    $levelId = curriculum_level_management_insert($elc_db, 'Levels', $levelValues);
    $reviewValues = $levelValues;
    $reviewValues['level_id'] = $levelId;
    $reviewValues['needs_review'] = 0;
    curriculum_level_management_insert($elc_db, 'Levels_review', $reviewValues);
    $backupValues = $levelValues;
    $backupValues['level_id'] = $levelId;
    curriculum_level_management_insert($elc_db, 'Levels_backup', $backupValues);

    $starterCourses = array();
    if ($program === 'part_time') {
        $starterCourses = array(
            array('name' => 'All Skills Grammar', 'short_name' => $shortName . '-ASG'),
            array('name' => 'Listening and Speaking', 'short_name' => $shortName . '-LS'),
        );
    } else {
        $template = $elc_db->prepare("SELECT c.course_name, c.course_short_name, c.skill_area FROM Courses c INNER JOIN Levels l ON l.level_id = c.level_id WHERE c.level_id = ? AND l.program = 'full_time' ORDER BY c.course_order ASC");
        $template->bind_param('i', $templateId);
        $template->execute();
        $templateResult = $template->get_result();
        while ($course = $templateResult->fetch_assoc()) {
            $starterCourses[] = array('name' => $course['course_name'], 'short_name' => $shortName . '-' . $course['course_short_name'], 'skill_area' => (int) $course['skill_area']);
        }
        if (count($starterCourses) !== 4) {
            throw new RuntimeException('The selected Full-time template must contain exactly four courses.');
        }
    }
    foreach ($starterCourses as $index => $course) {
        $skillArea = isset($course['skill_area']) ? $course['skill_area'] : ($index === 0 ? 1 : 2);
        $courseValues = array('level_id' => $levelId, 'course_name' => $course['name'], 'course_short_name' => $course['short_name'], 'course_order' => $index + 1, 'active' => $active, 'skill_area' => $skillArea, 'updated_by' => $net_id);
        $courseId = curriculum_level_management_insert($elc_db, 'Courses', $courseValues);
        $reviewCourseValues = $courseValues;
        unset($reviewCourseValues['skill_area']);
        $reviewCourseValues['course_id'] = $courseId;
        $reviewCourseValues['needs_review'] = 0;
        curriculum_level_management_insert($elc_db, 'Courses_review', $reviewCourseValues);
        $backupCourseValues = $reviewCourseValues;
        unset($backupCourseValues['needs_review']);
        curriculum_level_management_insert($elc_db, 'Courses_backup', $backupCourseValues);
    }
    $elc_db->commit();
    echo json_encode(array('ok' => true, 'message' => 'Level and starter courses created.', 'level_id' => $levelId));
} catch (Throwable $exception) {
    $elc_db->rollback();
    http_response_code(422);
    echo json_encode(array('ok' => false, 'message' => $exception->getMessage()));
}
