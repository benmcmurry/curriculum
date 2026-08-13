<?php

function curriculum_program_label($program) {
    return $program === 'part_time' ? 'Part-time' : 'Full-time';
}

function curriculum_level_adjacent_id($database, $levelId, $direction) {
    $comparison = $direction === 'previous' ? '<' : '>';
    $ordering = $direction === 'previous' ? 'DESC' : 'ASC';
    $query = $database->prepare("SELECT level_id FROM Levels WHERE level_order " . $comparison . " (SELECT level_order FROM Levels WHERE level_id = ?) ORDER BY level_order " . $ordering . ", level_id " . $ordering . " LIMIT 1");
    $query->bind_param('i', $levelId);
    $query->execute();
    $row = $query->get_result()->fetch_assoc();
    return $row ? (int) $row['level_id'] : null;
}

function curriculum_course_adjacent_id($database, $courseId, $direction) {
    $comparison = $direction === 'previous' ? '<' : '>';
    $ordering = $direction === 'previous' ? 'DESC' : 'ASC';
    $query = $database->prepare("SELECT c.course_id FROM Courses c INNER JOIN Levels l ON l.level_id = c.level_id WHERE (l.level_order, c.course_order, c.course_id) " . $comparison . " (SELECT l2.level_order, c2.course_order, c2.course_id FROM Courses c2 INNER JOIN Levels l2 ON l2.level_id = c2.level_id WHERE c2.course_id = ?) ORDER BY l.level_order " . $ordering . ", c.course_order " . $ordering . ", c.course_id " . $ordering . " LIMIT 1");
    $query->bind_param('i', $courseId);
    $query->execute();
    $row = $query->get_result()->fetch_assoc();
    return $row ? (int) $row['course_id'] : null;
}

function curriculum_level_management_required_columns($database, $table, $providedColumns) {
    $allowedTables = array('Levels', 'Levels_review', 'Levels_backup', 'Courses', 'Courses_review', 'Courses_backup');
    if (!in_array($table, $allowedTables, true)) {
        throw new RuntimeException('Unsupported database table.');
    }
    $result = $database->query('SHOW COLUMNS FROM ' . $table);
    while ($column = $result->fetch_assoc()) {
        if ($column['Extra'] === 'auto_increment' || in_array($column['Field'], $providedColumns, true)) {
            continue;
        }
        if ($column['Null'] === 'NO' && $column['Default'] === null) {
            throw new RuntimeException($table . '.' . $column['Field'] . ' requires a creation default before levels can be created.');
        }
    }
}

function curriculum_level_management_insert($database, $table, $values) {
    curriculum_level_management_required_columns($database, $table, array_keys($values));
    $columns = array_keys($values);
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $statement = $database->prepare('INSERT INTO ' . $table . ' (' . implode(',', $columns) . ') VALUES (' . $placeholders . ')');
    $types = '';
    $params = array();
    foreach ($values as $value) {
        $types .= is_int($value) ? 'i' : 's';
        $params[] = $value;
    }
    $bind = array($types);
    foreach ($params as $key => $value) {
        $bind[] = &$params[$key];
    }
    call_user_func_array(array($statement, 'bind_param'), $bind);
    $statement->execute();
    return (int) $database->insert_id;
}
