<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set("America/Denver"); 
require_once __DIR__ . '/bootstrap.php';
require_once (getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 2) . '/private-config') . '/connectFiles/connect_cis.php';
require_once "auth.php";
require_once "teachers.php";
require_once __DIR__ . '/content/page_helpers.php';
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Curriculum Portfolio - English Language Center</title>

    <!--     Meta Information -->
    <meta charset="utf-8">
    <meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?php require "content/styles_and_scripts.html"; ?>
</head>

<body>

    <?php require_once __DIR__ . "/content/shared-shell.php"; curriculum_render_site_header(); ?>


    <main class="container portfolio-main">
        <?php
        curriculum_render_portfolio_hero(array(
            'eyebrow' => 'Profile',
            'title' => 'ELC Lab School Profile',
            'subtitle' => 'This profile summarizes key teaching opportunities, scholarly output, and reference material used to document the ELC’s work as a lab school.',
            'actions' => array(
                array('label' => 'Pedagogy', 'href' => '#p'),
                array('label' => 'Teaching Opportunities', 'href' => '#to'),
                array('label' => 'Research and Publications', 'href' => '#rp'),
                array('label' => 'Citations', 'href' => '#c'),
            ),
        ));
        curriculum_render_section_jump_nav('On this page', array(
            array('label' => 'Pedagogy', 'href' => '#p'),
            array('label' => 'Teaching Opportunities', 'href' => '#to'),
            array('label' => 'Research and Publications', 'href' => '#rp'),
            array('label' => 'Citation Library', 'href' => '#c'),
        ), 'Profile sections');
        ?>

        <section class="content-card mb-4">
        <p>Assessment is essential to improve and progress. Administrators of the College of Humanities, the
            Department of Linguistics and English Language, and the English Language Center need to know how well
            the English Language Center (ELC) is fulfilling its principal purpose as a lab school. Accordingly the
            ELC publishes the Lab School Profile as a metric of its accomplishments.</p>
        <p> The profile is organized by a brief description of our <a href="#p">pedagogy</a>, <a href="#to">teaching
                opportunities</a>, <a href='#rp'>research and publications</a>, and <a href="#c"> citations lists of
                academic work done at the ELC</a>.</p>
        </section>

        <section id="p" class="portfolio-card mb-4">
            <div class="portfolio-card-header-level">
                <h2 class="h4 mb-0">Our Pedagogy</h2>
            </div>
            <div class="portfolio-card-body portfolio-rich-text">
        <p><strong>Principled Pedagogical Practices of ELC Teachers</strong></p>
        <p>ELC teachers strive to exemplify the following pedagogical practices for themselves, their students, and
            all who may observe their classes.</p>
        <ol>
            <li>Rely on course outcomes</li>
            <li>Plan Lessons Effectively</li>
            <li>Optimize class time</li>
            <li>Cultivate a positive learning environment</li>
            <li>Evaluate learning effectively</li>
            <li>Utilize homework strategically</li>
            <li>Provide meaningful and timely feedback</li>
            <li>Exemplify Professionalism</li>

        </ol>
        <p>For more detailed information, <a href="https://elc.byu.edu/teacher/ppp.php">click here</a>.</p>
            </div>
        </section>

        <section id="to" class="portfolio-card mb-4">
            <div class="portfolio-card-header-course">
                <h2 class="h4 mb-0">Teaching Opportunities</h2>
            </div>
            <div class="portfolio-card-body">
        <div class="portfolio-table-card">
        <div class="table-responsive">
        <table id="teaching" class='table table-striped'>

            <?php
            $queryStats = $elc_db->prepare("Select * from Statistics order by year DESC, Semester DESC");
            $queryStats->execute();
            $resultStats = $queryStats->get_result();

            $semesterYear = "<th>By Semester</th>";
            $classesTaught  = "<th scope='row'>Classes Taught</th>";
            $supplementalClassesTaught = "<th scope='row'>Supplemental Classes Taught</th>";
            $classesTaughtByStudents = "<th scope='row'>Classes taught by Students</th>";
            $classesTaughtByStudentsP = "<th scope='row'>Percentage of Classes taught by Students</th>";
            $graduatePracticumStudents = "<th scope='row'>Graduate Practicum Students</th>";
            $undergraduatePracticumStudents     = "<th scope='row'>Undergraduate Practicum Students</th>";
            $tutoringHours = "<th scope='row'>Tutoring Hours</th>";
            $classObservations = "<th scope='row'>Class Observations</th>";
            $graduateInternships = "<th scope='row'>Graduate Internships</th>";
            $undergraduateInternships = "<th scope='row'>Undergraduate Internships</th>";
            $i=1;
            $year = date("Y");
            $month = date("m");

            while ($stats = $resultStats->fetch_assoc()) {
                if ($stats['year'] == $year) {
                    if (substr($stats['semester'], 1)=="Winter" && $month < 5) {
                        $currentYear = "*";
                    } elseif (substr($stats['semester'], 1)=="Fall" && $month > 8) {
                        $currentYear = "*";
                    } elseif (substr($stats['semester'], 1)=="Summer" && $month > 4 && $month < 9) {
                        $currentYear = "*";
                    } else {
                        $currentYear = "";
                    }
                } else {
                    $currentYear = "";
                }
                if ($i % 2 == 0) {
                    $classCell = "class='even'";
                } else {
                    $classCell = "class='odd'";
                }
                if ($year-$stats['year'] < 4) {
                    $semesterYear = $semesterYear."<th scope='col'>".substr($stats['semester'], 1)." ".$stats['year'].$currentYear."</th>";
                    $classesTaught  = $classesTaught."<td>".$stats['classes_taught']."</td>";
                    $supplementalClassesTaught = $supplementalClassesTaught."<td>".$stats['supplemental_classes_taught']."</td>";
                    $classesTaughtByStudents = $classesTaughtByStudents."<td>".$stats['classes_taught_by_students']."</td>";

                    if ($stats['classes_taught_by_students'] == 0) {
                        $classesTaughtByStudentsP=$classesTaughtByStudentsP."<td></th>";
                    } else {
                        $classesTaughtByStudentsP = $classesTaughtByStudentsP."<td>".round((($stats['classes_taught_by_students'])/($stats['supplemental_classes_taught']+$stats['classes_taught']))*100)."%"."</td>";
                    }
                    $graduatePracticumStudents = $graduatePracticumStudents."<td>".$stats['graduate_practicum_students']."</td>";
                    $undergraduatePracticumStudents     = $undergraduatePracticumStudents."<td>".$stats['undergraduate_practicum_students']."</td>";
                    $tutoringHours = $tutoringHours."<td>".$stats['tutoring_hours']."</td>";
                    $classObservations = $classObservations."<td>".$stats['class_observations']."</td>";
                    $graduateInternships = $graduateInternships."<td>".$stats['graduate_internships']."</td>";
                    $undergraduateInternships = $undergraduateInternships."<td>".$stats['undergraduate_internships']."</td>";
                    $i++;
                }
            }
            $resultStats->free();

            echo <<<EOF

<thead><tr>$semesterYear</tr></thead>
<tr>$classesTaught</tr>
<tr>$supplementalClassesTaught</tr>
<tr>$classesTaughtByStudents</tr>
<tr>$classesTaughtByStudentsP</tr>
<tr>$graduatePracticumStudents</tr>
<tr>$undergraduatePracticumStudents</tr>
<tr>$tutoringHours</tr>
<tr>$classObservations</tr>
<tr>$graduateInternships</tr>
<tr>$undergraduateInternships</tr>
</table>
<p align="center">*current semester</p>


EOF;
?>
        </div>
        </div>
            </div>
        </section>

        <section id="rp" class="portfolio-card mb-4">
            <div class="portfolio-card-header-course">
                <h2 class="h4 mb-0">Research, Publications, and Presentations</h2>
            </div>
            <div class="portfolio-card-body">
            <div class="portfolio-table-card">
            <h3>Academic Work (Total and Last 5 Years)</h3>
            <div class="table-responsive">
            <table class='table table-striped'>

                <?php
        $i=2;
        $classCell = "class='odd'";
        $queryStats = $elc_db->prepare("Select type, COUNT(*) from Citations group by type");
        $queryStats->execute();
        $resultStats = $queryStats->get_result();

        while ($stats = $resultStats->fetch_assoc()) {
            switch ($stats['type']) {
                case "Dissertation":
                    $dissertation = $stats['COUNT(*)'];
                    break;
                case "Thesis":
                    $thesis = $stats['COUNT(*)'];
                    break;
                case "Project":
                    $project = $stats['COUNT(*)'];
                    break;
                case "Publication":
                    $publication = $stats['COUNT(*)'];
                    break;
                case "Presentation":
                    $presentation = $stats['COUNT(*)'];
                    break;
            }
        }

        $resultStats->free();
        $years = "<th>Year</th><td>Total**</th>";
        $dissertations  = "<th scope='row'>Dissertations</th><td>".$dissertation."</td>";
        $theses = "<th scope='row'>MA Theses</th><td>".$thesis."</td>";
        $projects = "<th scope='row'>MA Projects</th><td>".$project."</td>";
        $publications = "<th scope='row'>Publications</th><td>".$publication."</td>";
        $presentations = "<th scope='row'>Presentations</th><td>".$presentation."</td>";
        $year = date("Y");
        $loopYear = $year;
        while ($loopYear > $year - 5) {
            if ($loopYear == $year) {
                $currentYear = "*";
            } else {
                $currentYear = "";
            }
            $dissertation = $thesis = $project = $publication = $presentation = 0;


            $queryStats = $elc_db->prepare("Select type, COUNT(*) from Citations where year = ? group by type");
            $queryStats->bind_param("s", $loopYear);
            $queryStats->execute();
            $resultStats = $queryStats->get_result();

            while ($stats = $resultStats->fetch_assoc()) {
                switch ($stats['type']) {
                    case "Dissertation":
                        $dissertation = $stats['COUNT(*)'];
                        break;
                    case "Thesis":
                        $thesis = $stats['COUNT(*)'];
                        break;
                    case "Project":
                        $project = $stats['COUNT(*)'];
                        break;
                    case "Publication":
                        $publication = $stats['COUNT(*)'];
                        break;
                    case "Presentation":
                        $presentation = $stats['COUNT(*)'];
                        break;
                }
            }

            $resultStats->free();

            $years = $years."<td>".$loopYear.$currentYear."</td>";
            $dissertations = $dissertations. "<td>".$dissertation."</td>";
            $theses = $theses."<td>".$thesis."</td>";
            $projects = $projects."<td>".$project."</td>";
            $publications = $publications."<td>".$publication."</td>";
            $presentations = $presentations."<td>".$presentation."</td>";

            $loopYear = $loopYear -1;
            $i++;
        }
?>
            <?php
            echo <<<EOF
<thead><tr>$years</tr></thead>
<tr>$dissertations</tr>
<tr>$theses</tr>
<tr>$projects</tr>
<tr>$publications</tr>
<tr>$presentations</tr>
EOF;
            ?>
            </table>
            </div>
            <h3 id="c" class="mt-4">Citations</h3>




            <div role="region" aria-label="Controls">
                <label for="q">Search citations</label>
                <input class="form-control" id="q" type="search"
                    placeholder="Search in authors, title, venue, institution, URL…" />

                <div class="portfolio-toolbar mt-2">
                    <div>Click a column to sort.</div>
                    <div class="portfolio-toolbar ms-auto">
                        <label class="muted">Rows/page
                            <select id="pageSize">
                                <option selected>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </label>
                        <div id="pager" aria-label="Pagination" class="portfolio-toolbar">
                            <button class="btn btn-light" id="prev">Prev</button>
                            <span class="muted">
                                Page <span id="pageNum">1</span> of <span id="pageCount">1</span>
                            </span>
                            <button class="btn btn-light" id="next">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:12px;">
                <div class="portfolio-toolbar mb-2">
                    <div><span class="count" id="shown">0</span> shown <span class="muted">(<span id="total">0</span>
                            total)</span></div>
                </div>
                <div class="table-responsive">
                    <table id='citations' class='table table-striped' style="width:100%; table-layout:fixed;">
                        <thead>
                            <tr>
                                <th class="sortable" width="7%" data-key="year" data-num="1">Year <span class="arrow">↕</span></th>
                                <th class="sortable" width="83%" data-key="cite">Citation (APA) <span class="arrow">↕</span></th>
                                <th class="sortable" width="10%" data-key="derivedType">Type <span class="arrow">↕</span></th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
            </div>
            </div>
        </section>
    </main>

    <script src="js/citations.js"></script>
    <?php curriculum_render_footer(); ?>


</body>

</html>
