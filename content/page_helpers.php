<?php

function curriculum_render_portfolio_hero(array $config): void
{
    $eyebrow = isset($config['eyebrow']) ? (string) $config['eyebrow'] : '';
    $title = isset($config['title']) ? (string) $config['title'] : '';
    $subtitle = isset($config['subtitle']) ? (string) $config['subtitle'] : '';
    $stats = isset($config['stats']) && is_array($config['stats']) ? $config['stats'] : array();
    $actions = isset($config['actions']) && is_array($config['actions']) ? $config['actions'] : array();

    echo "<section class='hero-card portfolio-hero content-card-spotlight'>";
    if ($eyebrow !== '') {
        echo "<p class='portfolio-eyebrow'>" . htmlspecialchars($eyebrow, ENT_QUOTES, 'UTF-8') . "</p>";
    }
    echo "<h1 class='portfolio-title'>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</h1>";
    if ($subtitle !== '') {
        echo "<p class='portfolio-subtitle'>" . htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8') . "</p>";
    }

    if (!empty($actions)) {
        echo "<div class='portfolio-chip-group mt-4'>";
        foreach ($actions as $action) {
            $href = isset($action['href']) ? (string) $action['href'] : '#';
            $label = isset($action['label']) ? (string) $action['label'] : '';
            echo "<a class='portfolio-chip-link' href='" . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</a>";
        }
        echo "</div>";
    }

    if (!empty($stats)) {
        echo "<div class='portfolio-summary-grid mt-4'>";
        foreach ($stats as $stat) {
            $label = isset($stat['label']) ? (string) $stat['label'] : '';
            $value = isset($stat['value']) ? (string) $stat['value'] : '';
            $description = isset($stat['description']) ? (string) $stat['description'] : '';
            echo "<article class='portfolio-stat-card'>";
            echo "<p class='portfolio-stat-label'>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p class='portfolio-stat-value'>" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "</p>";
            if ($description !== '') {
                echo "<p class='mb-0'>" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "</p>";
            }
            echo "</article>";
        }
        echo "</div>";
    }

    echo "</section>";
}

function curriculum_render_section_jump_nav(string $label, array $items, string $ariaLabel): void
{
    if (empty($items)) {
        return;
    }

    echo "<section class='content-card content-card-compact content-card-nav mb-4'>";
    echo "<nav class='section-jump-nav' aria-label='" . htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') . "'>";
    echo "<p class='section-jump-label'>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<ul>";
    foreach ($items as $item) {
        $href = isset($item['href']) ? (string) $item['href'] : '#';
        $itemLabel = isset($item['label']) ? (string) $item['label'] : '';
        echo "<li><a href='" . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($itemLabel, ENT_QUOTES, 'UTF-8') . "</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
    echo "</section>";
}
