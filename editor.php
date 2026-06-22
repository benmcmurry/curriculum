<?php
require_once __DIR__ . '/bootstrap.php';
require_once (getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 2) . '/private-config') . '/connectFiles/connect_cis.php';
require_once "auth.php";
require_once "teachers.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Curriculum Editor - English Language Center</title>
    <meta charset="utf-8">
    <meta name="description" content="Open the curriculum editor workspace for levels, courses, and learning experiences." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Editor" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Editor" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_once("content/styles_and_scripts.html"); ?>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<?php require_once __DIR__ . "/content/shared-shell.php"; curriculum_render_editor_header(array("home_path_prefix" => "", "editor_path_prefix" => "editors")); ?>

<main id="main-content" class="container portfolio-main">
    <section class="hero-card portfolio-hero content-card-spotlight">
        <p class="portfolio-eyebrow">Editor</p>
        <h1 class="portfolio-title">Curriculum Editing Workspace</h1>
        <p class="portfolio-subtitle">Use the current editor workspace to manage level descriptors, course content, learning experiences, user access, and profile statistics.</p>
        <div class="portfolio-chip-group mt-4">
            <a class="portfolio-chip-link" href="editors/index.php">Open Editor Dashboard</a>
            <a class="portfolio-chip-link" href="index.php">Back to Portfolio</a>
        </div>
    </section>

    <section class="portfolio-item-grid">
        <article class="portfolio-item-card">
            <p class="portfolio-stat-label">Levels and Courses</p>
            <h2>Open the main editor dashboard</h2>
            <p class="portfolio-item-meta">Browse levels, courses, and learning experiences in the redesigned editor workspace.</p>
            <a class="portfolio-chip-link" href="editors/index.php">Go to Dashboard</a>
        </article>
        <article class="portfolio-item-card">
            <p class="portfolio-stat-label">Access</p>
            <h2>Manage editor permissions</h2>
            <p class="portfolio-item-meta">Update user access and role settings for curriculum contributors.</p>
            <a class="portfolio-chip-link" href="editors/users.php">Open Access Table</a>
        </article>
        <article class="portfolio-item-card">
            <p class="portfolio-stat-label">Profile Data</p>
            <h2>Edit profile statistics and citations</h2>
            <p class="portfolio-item-meta">Maintain the institutional profile tables and citation library that support the public profile page.</p>
            <a class="portfolio-chip-link" href="editors/profile-editor.php">Open Profile Editor</a>
        </article>
    </section>
</main>

<?php curriculum_render_footer(); ?>
</body>
</html>
