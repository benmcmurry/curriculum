<?php
session_start();
    require_once "../../connectFiles/connect_cis.php";
    require_once "cas-go.php";
    require_once "teachers.php";
?>
<!DOCTYPE html>
<html lang="">

<head>
    <title>Curriculum Portfolio - English Language Center</title>

    <!--     Meta Information -->
    <meta charset="utf-8">
    <meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?php require "content/styles_and_scripts.html"; ?>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/b-2.3.4/b-html5-2.3.4/b-print-2.3.4/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/b-2.3.4/b-html5-2.3.4/b-print-2.3.4/datatables.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    let table = new DataTable('#citations');
});
</script> 
</head>

<body>

    <?php require "content/header.php"; ?>


    <div id="title" class="container-fluid">ELC Lab School Profile</div>
    <div class="container-md pt-4">
            <p>Assessment is essential to improve and progress. Administrators of the College of Humanities, the
                Department of Linguistics and English Language, and the English Language Center need to know how well
                the English Language Center (ELC) is fulfilling its principal purpose as a lab school. Accordingly the
                ELC publishes the Lab School Profile as a metric of its accomplishments.</p>
            <p> The profile is organized by a brief description of our <a href="#p">pedagogy</a>, <a href="#to">teaching
                    opportunities</a>, <a href='#rp'>research and publications</a>, and <a href="#c"> citations lists of
                    academic work done at the ELC</a>.</p>

            <h2>Our Pedagogy</h2>
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
            <h2>Teaching Opportunities</h2>
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

<h2>Research and Publications</h2>
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
        $years = "<th><h1>Year</h1></th><td>Total**</th>";
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
echo <<<EOF
<thead><tr>$years</tr></thead>
<tr>$dissertations</tr>
<tr>$theses</tr>
<tr>$projects</tr>
<tr>$publications</tr>
<tr>$presentations</tr>




	</table>
	<p align="center">**Data collection started in 2008, but there are recorded citations as early as 2001. </p>
	<p align="center">*current year</p>
EOF;
        ?>
        <h2>Citations</h2>

                <table id='citations' class='table table-striped'>
                    <thead>
                        <tr>
                            <th scope='col'> Citation</th>
                            <th scope='col'> Type </th>
                        </tr>
                    </thead>

                    <?php
                    $query = $elc_db->prepare("Select * from Citations order by year DESC");
                    $query->execute();
                    $result = $query->get_result();

                    while ($pubs = $result->fetch_assoc()) {
                        ?>
                    <tr>
                        <td> <?php echo $pubs['citation']; ?></td>
                        <td> <?php echo $pubs['type']; ?></td>
                    </tr>
                    <?php
                    }

                    $result->free();

                    ?>
                </table>
            
           
<div id="zotero-bibliography"></div>
<script>
  const GROUP_ID = 5548551; // replace with your numeric group ID
  const STYLE = 'apa';
  const LIMIT = 25;        // 1–100
  const START = 0;         // offset for pagination

  async function loadZoteroBib() {
    const params = new URLSearchParams({
      format: 'json',
      include: 'bib',
      style: STYLE,
      sort: 'date',
      direction: 'desc',
      limit: String(LIMIT),
      start: String(START),
      // Optional filters:
      // collection: 'XXXXXX',
      // tag: 'Open Access',
      // itemType: 'journalArticle',
    });

    const url = `https://api.zotero.org/groups/${GROUP_ID}/items?` + params.toString();
    const res = await fetch(url, { headers: { 'Zotero-API-Version': '3' } });
    const data = await res.json();

    // data is an array of items; each has a bib HTML field (either item.meta.bib or item.bib)
    const html = data.map(it => (it.meta && it.meta.bib) || it.bib || '').join('\n');
    document.getElementById('zotero-bibliography').innerHTML = html;
  }

  loadZoteroBib().catch(err => {
    console.error(err);
    document.getElementById('zotero-bibliography').textContent = 'Unable to load bibliography.';
  });
</script>
</div>
<footer>
    <?php require "content/footer.html"; ?>
</footer>
                        
                                    
</body>

</html>