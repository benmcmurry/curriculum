<?php
/**
 * Run from a configured environment:
 *   php scripts/migrate_part_time_program.php --apply
 * It makes schema changes, creates the published Part-time scaffold, and creates
 * corresponding review and backup records in a guarded transaction.
 */
require_once __DIR__ . '/../bootstrap.php';
require_once (getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php';
require_once __DIR__ . '/../editors/level_management_helpers.php';

$apply = in_array('--apply', $argv, true);
if (!$apply) {
    fwrite(STDOUT, "Preflight only. Re-run with --apply to make changes.\n");
}

function curriculum_column_exists($database, $table, $column) {
    $statement = $database->prepare('SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?');
    $statement->bind_param('ss', $table, $column);
    $statement->execute();
    return (bool) $statement->get_result()->fetch_row();
}

$requiredTables = array('Levels', 'Levels_review', 'Levels_backup', 'Courses', 'Courses_review', 'Courses_backup');
foreach ($requiredTables as $table) {
    $result = $elc_db->query('SHOW TABLES LIKE \'' . $elc_db->real_escape_string($table) . '\'');
    if (!$result || !$result->fetch_row()) {
        throw new RuntimeException('Missing required table: ' . $table);
    }
}
fwrite(STDOUT, "Database preflight passed.\n");
if (!$apply) {
    exit(0);
}

foreach (array('Levels', 'Levels_review', 'Levels_backup') as $table) {
    if (!curriculum_column_exists($elc_db, $table, 'program')) {
        $elc_db->query("ALTER TABLE " . $table . " ADD COLUMN program ENUM('full_time','part_time') NOT NULL DEFAULT 'full_time' AFTER level_order");
    }
}
foreach (array('Courses', 'Courses_review', 'Courses_backup') as $table) {
    if (!curriculum_column_exists($elc_db, $table, 'active')) {
        $elc_db->query("ALTER TABLE " . $table . " ADD COLUMN active TINYINT(1) NOT NULL DEFAULT 1 AFTER course_order");
    }
}

$elc_db->begin_transaction();
try {
    $existing = $elc_db->prepare("SELECT level_id FROM Levels WHERE program = 'part_time' LIMIT 1");
    $existing->execute();
    if ($existing->get_result()->fetch_assoc()) {
        throw new RuntimeException('Part-time levels already exist; no scaffold was inserted.');
    }
    $orderResult = $elc_db->query('SELECT COALESCE(MAX(level_order), 0) AS max_order FROM Levels');
    $nextOrder = (int) $orderResult->fetch_assoc()['max_order'] + 1;
    $levels = array(
        array('Level 1-2', 'PT12'),
        array('Level 3-4', 'PT34'),
        array('Level 5+', 'PT5'),
    );
    foreach ($levels as $seed) {
        $levelValues = array('level_order' => $nextOrder++, 'program' => 'part_time', 'level_short_name' => $seed[1], 'level_name' => $seed[0], 'level_descriptor' => '', 'active' => 1, 'level_updated_by' => 'system');
        $levelId = curriculum_level_management_insert($elc_db, 'Levels', $levelValues);
        $reviewLevel = $levelValues;
        $reviewLevel['level_id'] = $levelId;
        $reviewLevel['needs_review'] = 0;
        curriculum_level_management_insert($elc_db, 'Levels_review', $reviewLevel);
        $backupLevel = $levelValues;
        $backupLevel['level_id'] = $levelId;
        curriculum_level_management_insert($elc_db, 'Levels_backup', $backupLevel);
        $courses = array(
            array('All Skills Grammar', $seed[1] . '-ASG', 1),
            array('Listening and Speaking', $seed[1] . '-LS', 2),
        );
        foreach ($courses as $courseOrder => $course) {
            $courseValues = array('level_id' => $levelId, 'course_order' => $courseOrder + 1, 'active' => 1, 'course_name' => $course[0], 'course_short_name' => $course[1], 'skill_area' => $course[2], 'updated_by' => 'system');
            $courseId = curriculum_level_management_insert($elc_db, 'Courses', $courseValues);
            $reviewCourse = $courseValues;
            unset($reviewCourse['skill_area']);
            $reviewCourse['course_id'] = $courseId;
            $reviewCourse['needs_review'] = 0;
            curriculum_level_management_insert($elc_db, 'Courses_review', $reviewCourse);
            $backupCourse = $reviewCourse;
            unset($backupCourse['needs_review']);
            curriculum_level_management_insert($elc_db, 'Courses_backup', $backupCourse);
        }
    }
    $elc_db->commit();
    fwrite(STDOUT, "Created 3 Part-time levels and 6 courses.\n");
} catch (Throwable $exception) {
    $elc_db->rollback();
    throw $exception;
}
