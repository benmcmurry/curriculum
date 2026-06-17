<?php

function curriculum_render_editor_hero(string $eyebrow, string $title, string $description): void
{
    echo "<section class='editor-hero'>";
    echo "<p class='editor-eyebrow'>" . htmlspecialchars($eyebrow, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<h1 class='h3 mb-2'>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</h1>";
    echo "<p class='mb-0'>" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "</section>";
}

function curriculum_render_editor_actions(string $ariaLabel, array $actions): void
{
    if (empty($actions)) {
        return;
    }

    echo "<section class='editor-topbar sticky-top mb-3' aria-label='" . htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') . "'>";
    echo "<div class='d-flex flex-wrap gap-2'>";
    foreach ($actions as $action) {
        $href = isset($action['href']) ? (string) $action['href'] : null;
        $id = isset($action['id']) ? (string) $action['id'] : '';
        $label = isset($action['label']) ? (string) $action['label'] : '';
        $class = isset($action['class']) ? (string) $action['class'] : 'btn btn-outline-secondary';
        $icon = isset($action['icon']) ? (string) $action['icon'] : '';
        $extra = isset($action['extra']) ? (string) $action['extra'] : '';
        $idAttr = $id !== '' ? " id='" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "'" : '';
        $iconHtml = $icon !== '' ? "<i class='" . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . "'></i> " : '';
        if ($href !== null) {
            echo "<a class='" . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . "'" . $idAttr . " href='" . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . "'" . $extra . ">" . $iconHtml . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</a>";
        } else {
            echo "<button type='button' class='" . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . "'" . $idAttr . $extra . ">" . $iconHtml . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</button>";
        }
    }
    echo "</div>";
    echo "</section>";
}
