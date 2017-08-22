<div class='content'>
	<h2>Lab School Profile</h2>
	<p>Assessment is essential to improve and progress. Administrators of the College of Humanities, the Department of Linguistics and English Language, and the English Language Center need to know how well the English Language Center (ELC) is fulfilling its principal purpose as a lab school. Accordingly the ELC publishes the Lab School Profile as a metric of its accomplishments.</p>
	<p> The profile is organized by a brief description of our <a href="#p">pedagogy</a>, <a href="#to">teaching opportunities</a>, <a href='#rp'>research and publications</a>, and <a href="#c"> citations lists of academic work done at the ELC</a>.</p>

	<h2 id='p'>Our Pedagogy</h2>
	<p><strong>Principled Pedagogical Practices of ELC Teachers</strong></p>
	<p>ELC teachers strive to exemplify the following pedagogical practices for themselves, their students, and all who may observe their classes.</p>
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
	<h2 id="to">Teaching Opportunities</h2>
	<div id='data_nav'>
		<ul id='menu '>
			<li class='options' id='recent_semesters'>Recent Semesters</li>
			<li class='options' id='academic_years'>Last 5 Academic Years</li>
			<li class='options' id='years'>Last 5 Calendar Years</li>
		</ul>
		</div>
		<div id='data_view'></div>
		<div class="folder" id="teaching_recent_semesters">
		<table class='teaching'>

<?php
$query_stats = $db->prepare("Select * from Statistics order by year DESC, Semester DESC");
$query_stats->execute();
$result_stats = $query_stats->get_result();

$semester_year = "<td><h1>By Semester</h1></td>";
$classes_taught  = "<td class='first_column'>Classes Taught</td>";
$supplemental_classes_taught = "<td class='first_column'>Supplemental Classes Taught</td>";
$classes_taught_by_students = "<td class='first_column'>Classes taught by Students</td>";
$classes_taught_by_students_p = "<td class='first_column'>Percentage of Classes taught by Students</td>";
$graduate_practicum_students = "<td class='first_column'>Graduate Practicum Students</td>";
$undergraduate_practicum_students     = "<td class='first_column'>Undergraduate Practicum Students</td>";
$tutoring_hours = "<td class='first_column'>Tutoring Hours</td>";
$class_observations = "<td class='first_column'>Class Observations</td>";
$graduate_internships = "<td class='first_column'>Graduate Internships</td>";
$undergraduate_internships = "<td class='first_column'>Undergraduate Internships</td>";
$i=1;
$year = date("Y");
while ($stats = $result_stats->fetch_assoc()) {
    if ($stats['year'] == $year) {
        $current_year = "*";
    } else {
        $current_year = "";
    }
    if ($i % 2 == 0) {
        $class_cell = "class='even'";
    } else {
        $class_cell = "class='odd'";
    }
    if ($year-$stats['year'] < 4) {
        $semester_year = $semester_year."<td ".$class_cell.">".substr($stats['semester'], 1)." ".$stats['year'].$current_year."</td>";
        $classes_taught  = $classes_taught."<td ".$class_cell.">".$stats['classes_taught']."</td>";
        $supplemental_classes_taught = $supplemental_classes_taught."<td ".$class_cell.">".$stats['supplemental_classes_taught']."</td>";
        $classes_taught_by_students = $classes_taught_by_students."<td ".$class_cell.">".$stats['classes_taught_by_students']."</td>";
        $classes_taught_by_students_p = $classes_taught_by_students_p."<td ".$class_cell.">".round((($stats['classes_taught_by_students'])/($stats['supplemental_classes_taught']+$stats['classes_taught']))*100)."%"."</td>";
        $graduate_practicum_students = $graduate_practicum_students."<td ".$class_cell.">".$stats['graduate_practicum_students']."</td>";
        $undergraduate_practicum_students     = $undergraduate_practicum_students."<td ".$class_cell.">".$stats['undergraduate_practicum_students']."</td>";
        $tutoring_hours = $tutoring_hours."<td ".$class_cell.">".$stats['tutoring_hours']."</td>";
        $class_observations = $class_observations."<td ".$class_cell.">".$stats['class_observations']."</td>";
        $graduate_internships = $graduate_internships."<td ".$class_cell.">".$stats['graduate_internships']."</td>";
        $undergraduate_internships = $undergraduate_internships."<td ".$class_cell.">".$stats['undergraduate_internships']."</td>";
        $i++;
    }
}
$result_stats->free();

echo <<<EOF

<thead><tr>$semester_year</tr></thead>
<tr class='odd'>$classes_taught</tr>
<tr>$supplemental_classes_taught</tr>
<tr class='odd'>$classes_taught_by_students</tr>
<tr>$classes_taught_by_students_p</tr>
<tr class='odd'>$graduate_practicum_students</tr>
<tr>$undergraduate_practicum_students</tr>
<tr class='odd'>$tutoring_hours</tr>
<tr>$class_observations</tr>
<tr class='odd'>$graduate_internships</tr>
<tr>$undergraduate_internships</tr>


	</table>
	<p align="center">*current semester</p>
</div>

EOF;
?>

<div class="folder" id="teaching_academic_years">
<table class='teaching'>

<?php
$query_stats = $db->prepare("Select * from Statistics order by year DESC, Semester DESC");
$query_stats->execute();
$result_stats = $query_stats->get_result();

$semester_year = "<td><h1>By Academic Year</h1></td>";
$classes_taught  = "<td class='first_column'>Classes Taught</td>";
$supplemental_classes_taught = "<td class='first_column'>Supplemental Classes Taught</td>";
$classes_taught_by_students = "<td class='first_column'>Classes taught by Students</td>";
$classes_taught_by_students_p = "<td class='first_column'>Percentage of Classes taught by Students</td>";
$graduate_practicum_students = "<td class='first_column'>Graduate Practicum Students</td>";
$undergraduate_practicum_students     = "<td class='first_column'>Undergraduate Practicum Students</td>";
$tutoring_hours = "<td class='first_column'>Tutoring Hours</td>";
$class_observations = "<td class='first_column'>Class Observations</td>";
$graduate_internships = "<td class='first_column'>Graduate Internships</td>";
$undergraduate_internships = "<td class='first_column'>Undergraduate Internships</td>";

$i=1;

$year = date("Y");
$month = date("m");

if ($month < 9) {
    $start_year = $year-1;
} else {
    $start_year = $year;
}


while ($start_year > 2013) {
    if ($i % 2 == 0) {
        $class_cell = "class='even'";
    } else {
        $class_cell = "class='odd'";
    }
    $semester_year_count = 0;
    $classes_taught_count  = 0;
    $supplemental_classes_taught_count = 0;
    $classes_taught_by_students_count = 0;
    $classes_taught_by_students_p_count = 0;
    $graduate_practicum_students_count = 0;
    $undergraduate_practicum_students_count     = 0;
    $tutoring_hours_count = 0;
    $class_observations_count = 0;
    $graduate_internships_count = 0;
    $undergraduate_internships_count = 0;

    $end_year = $start_year+1;
    $query_academic_year = $db->prepare("Select * from Statistics where (year = ? and (semester like '%2Summer%' or semester like '%1Winter%')) OR (year = ? and (semester like '%3Fall%'))");
    $query_academic_year->bind_param("ss", $end_year, $start_year);
    $query_academic_year->execute();
    $result_academic_year = $query_academic_year->get_result();


    while ($academic_year = $result_academic_year->fetch_assoc()) {
        $classes_taught_count += $academic_year['classes_taught'];
        $supplemental_classes_taught_count += $academic_year['supplemental_classes_taught'];
        $classes_taught_by_students_count += $academic_year['classes_taught_by_students'];
        $graduate_practicum_students_count += $academic_year['graduate_practicum_students'];
        $undergraduate_practicum_students_count     += $academic_year['undergraduate_practicum_students'];
        $tutoring_hours_count += $academic_year['tutoring_hours'];
        $class_observations_count += $academic_year['class_observations'];
        $graduate_internships_count += $academic_year['graduate_internships'];
        $undergraduate_internships_count += $academic_year['undergraduate_internships'];
    }
    if ($end_year == $year) {
        $current_year = "*";
    } else {
        $current_year = "";
    }
    $semester_year = $semester_year."<td ".$class_cell.">".$start_year."-".$end_year.$current_year."</td>";

    $classes_taught  = $classes_taught."<td ".$class_cell.">".$classes_taught_count."</td>";
    $supplemental_classes_taught = $supplemental_classes_taught."<td ".$class_cell.">".$supplemental_classes_taught_count."</td>";
    $classes_taught_by_students = $classes_taught_by_students."<td ".$class_cell.">".$classes_taught_by_students_count."</td>";
    $classes_taught_by_students_p = $classes_taught_by_students_p."<td ".$class_cell.">".round((($classes_taught_by_students_count)/($supplemental_classes_taught_count+$classes_taught_count))*100)."%"."</td>";
    $graduate_practicum_students = $graduate_practicum_students."<td ".$class_cell.">".$graduate_practicum_students_count."</td>";
    $undergraduate_practicum_students     = $undergraduate_practicum_students."<td ".$class_cell.">".$undergraduate_practicum_students_count."</td>";
    $tutoring_hours = $tutoring_hours."<td ".$class_cell.">".$tutoring_hours_count."</td>";
    $class_observations = $class_observations."<td ".$class_cell.">".$class_observations_count."</td>";
    $graduate_internships = $graduate_internships."<td ".$class_cell.">".$graduate_internships_count."</td>";
    $undergraduate_internships = $undergraduate_internships."<td ".$class_cell.">".$undergraduate_internships_count."</td>";
    $start_year = $start_year-1;
    $i++;
}
$limit = 6 - $i;
if ($i % 2 == 0) {
    $i=2;
} else {
    $i=1;
}

$query_stats = $db->prepare("Select * from Statistics where semester not like '%1Winter%' AND semester not like '%2Summer%' AND semester not like '%3Fall%' order by year DESC, Semester DESC Limit ?");
$query_stats->bind_param("s", $limit);
$query_stats->execute();
$result = $query_stats->get_result();



while ($stats = $result_stats->fetch_assoc()) {
    if ($i % 2 == 0) {
        $class_cell = "class='even'";
    } else {
        $class_cell = "class='odd'";
    }


    $semester_year = $semester_year."<td ".$class_cell.">".substr($stats['semester'], 1)." ".$stats['year']."</td>";
    $classes_taught  = $classes_taught."<td ".$class_cell.">".$stats['classes_taught']."</td>";
    $supplemental_classes_taught = $supplemental_classes_taught."<td ".$class_cell.">".$stats['supplemental_classes_taught']."</td>";
    $classes_taught_by_students = $classes_taught_by_students."<td ".$class_cell.">".$stats['classes_taught_by_students']."</td>";
    $classes_taught_by_students_p = $classes_taught_by_students_p."<td ".$class_cell.">".round((($stats['classes_taught_by_students'])/($stats['supplemental_classes_taught']+$stats['classes_taught']))*100)."%"."</td>";
    $graduate_practicum_students = $graduate_practicum_students."<td ".$class_cell.">".$stats['graduate_practicum_students']."</td>";
    $undergraduate_practicum_students     = $undergraduate_practicum_students."<td ".$class_cell.">".$stats['undergraduate_practicum_students']."</td>";
    $tutoring_hours = $tutoring_hours."<td ".$class_cell.">".$stats['tutoring_hours']."</td>";
    $class_observations = $class_observations."<td ".$class_cell.">".$stats['class_observations']."</td>";
    $graduate_internships = $graduate_internships."<td ".$class_cell.">".$stats['graduate_internships']."</td>";
    $undergraduate_internships = $undergraduate_internships."<td ".$class_cell.">".$stats['undergraduate_internships']."</td>";
    $i++;
}
$result_stats->free();

echo <<<EOF

<thead><tr>$semester_year</tr></thead>
<tr class='odd'>$classes_taught</tr>
<tr>$supplemental_classes_taught</tr>
<tr class='odd'>$classes_taught_by_students</tr>
<tr>$classes_taught_by_students_p</tr>
<tr class='odd'>$graduate_practicum_students</tr>
<tr>$undergraduate_practicum_students</tr>
<tr class='odd'>$tutoring_hours</tr>
<tr>$class_observations</tr>
<tr class='odd'>$graduate_internships</tr>
<tr>$undergraduate_internships</tr>


	</table>
	<p align="center">*current academic year</p>
</div>

EOF;
?>

<div class="folder" id="teaching_years">
<table class='teaching'>

<?php

$semester_year = "<td><h1>By Calendar Year</h1></td>";
$classes_taught  = "<td class='first_column'>Classes Taught</td>";
$supplemental_classes_taught = "<td class='first_column'>Supplemental Classes Taught</td>";
$classes_taught_by_students = "<td class='first_column'>Classes taught by Students</td>";
$classes_taught_by_students_p = "<td class='first_column'>Percentage of Classes taught by Students</td>";
$graduate_practicum_students = "<td class='first_column'>Graduate Practicum Students</td>";
$undergraduate_practicum_students     = "<td class='first_column'>Undergraduate Practicum Students</td>";
$tutoring_hours = "<td class='first_column'>Tutoring Hours</td>";
$class_observations = "<td class='first_column'>Class Observations</td>";
$graduate_internships = "<td class='first_column'>Graduate Internships</td>";
$undergraduate_internships = "<td class='first_column'>Undergraduate Internships</td>";

$i=1;

$year = date("Y");
$end_year = $year-3;
$start_year = $year;
while ($start_year > $end_year) {
    if ($i % 2 == 0) {
        $class_cell = "class='even'";
    } else {
        $class_cell = "class='odd'";
    }
    $semester_year_count = 0;
    $classes_taught_count  = 0;
    $supplemental_classes_taught_count = 0;
    $classes_taught_by_students_count = 0;
    $classes_taught_by_students_p_count = 0;
    $graduate_practicum_students_count = 0;
    $undergraduate_practicum_students_count     = 0;
    $tutoring_hours_count = 0;
    $class_observations_count = 0;
    $graduate_internships_count = 0;
    $undergraduate_internships_count = 0;


    $query_year = $db->prepare("Select * from Statistics where year = ?");
    $query_year->bind_param("s", $start_year);
    $query_year->execute();
    $result_year = $query_year->get_result();

    while ($year_data = $result_year->fetch_assoc()) {
        $classes_taught_count += $year_data['classes_taught'];
        $supplemental_classes_taught_count += $year_data['supplemental_classes_taught'];
        $classes_taught_by_students_count += $year_data['classes_taught_by_students'];
        $graduate_practicum_students_count += $year_data['graduate_practicum_students'];
        $undergraduate_practicum_students_count     += $year_data['undergraduate_practicum_students'];
        $tutoring_hours_count += $year_data['tutoring_hours'];
        $class_observations_count += $year_data['class_observations'];
        $graduate_internships_count += $year_data['graduate_internships'];
        $undergraduate_internships_count += $year_data['undergraduate_internships'];
    }
    if ($start_year == $year) {
        $current_year = "*";
    } else {
        $current_year = "";
    }
    $semester_year = $semester_year."<td ".$class_cell.">".$start_year.$current_year."</td>";

    $classes_taught  = $classes_taught."<td ".$class_cell.">".$classes_taught_count."</td>";
    $supplemental_classes_taught = $supplemental_classes_taught."<td ".$class_cell.">".$supplemental_classes_taught_count."</td>";
    $classes_taught_by_students = $classes_taught_by_students."<td ".$class_cell.">".$classes_taught_by_students_count."</td>";
    $classes_taught_by_students_p = $classes_taught_by_students_p."<td ".$class_cell.">".round((($classes_taught_by_students_count)/($supplemental_classes_taught_count+$classes_taught_count))*100)."%"."</td>";
    $graduate_practicum_students = $graduate_practicum_students."<td ".$class_cell.">".$graduate_practicum_students_count."</td>";
    $undergraduate_practicum_students     = $undergraduate_practicum_students."<td ".$class_cell.">".$undergraduate_practicum_students_count."</td>";
    $tutoring_hours = $tutoring_hours."<td ".$class_cell.">".$tutoring_hours_count."</td>";
    $class_observations = $class_observations."<td ".$class_cell.">".$class_observations_count."</td>";
    $graduate_internships = $graduate_internships."<td ".$class_cell.">".$graduate_internships_count."</td>";
    $undergraduate_internships = $undergraduate_internships."<td ".$class_cell.">".$undergraduate_internships_count."</td>";
    $start_year=$start_year-1;
    $i++;
}


echo <<<EOF

<thead><tr>$semester_year</tr></thead>
<tr class='odd'>$classes_taught</tr>
<tr>$supplemental_classes_taught</tr>
<tr class='odd'>$classes_taught_by_students</tr>
<tr>$classes_taught_by_students_p</tr>
<tr class='odd'>$graduate_practicum_students</tr>
<tr>$undergraduate_practicum_students</tr>
<tr class='odd'>$tutoring_hours</tr>
<tr>$class_observations</tr>
<tr class='odd'>$graduate_internships</tr>
<tr>$undergraduate_internships</tr>


	</table>
	<p align="center">*current year</p>
</div>

EOF;
?>
<h2 id="rp">Research and Publications</h2>
<div id="research_data_view">
<table class='teaching'>

<?php
$i=2; $class_cell = "class='odd'";
$query_stats = $db->prepare("Select type, COUNT(*) from Citations group by type");
$query_stats->execute();
  $result_stats = $query_stats->get_result();

while ($stats = $result_stats->fetch_assoc()) {
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

$result_stats->free();
$years = "<td><h1>Year</h1></td><td ".$class_cell.">Total**</td>";
$dissertations  = "<td class='first_column'>Dissertations</td><td ".$class_cell.">".$dissertation."</td>";
$theses = "<td class='first_column'>MA Theses</td><td ".$class_cell.">".$thesis."</td>";
$projects = "<td class='first_column'>MA Projects</td><td ".$class_cell.">".$project."</td>";
$publications = "<td class='first_column'>Publications</td><td ".$class_cell.">".$publication."</td>";
$presentations = "<td class='first_column'>Presentations</td><td ".$class_cell.">".$presentation."</td>";
$year = date("Y");
$loop_year = $year;
while ($loop_year > $year - 5) {
    if ($loop_year == $year) {
        $current_year = "*";
    } else {
        $current_year = "";
    }
    if ($i % 2 == 0) {
        $class_cell = "class='even'";
    } else {
        $class_cell = "class='odd'";
    }
    $dissertation = $thesis = $project = $publication = $presentation = 0;


    $query_stats = $db->prepare("Select type, COUNT(*) from Citations where year = ? group by type");
    $query_stats->bind_param("s", $loop_year);
    $query_stats->execute();
    $result_stats = $query_stats->get_result();

    while ($stats = $result_stats->fetch_assoc()) {
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

    $result_stats->free();

    $years = $years."<td ".$class_cell.">".$loop_year.$current_year."</td>";
    $dissertations = $dissertations. "<td ".$class_cell.">".$dissertation."</td>";
    $theses = $theses."<td ".$class_cell.">".$thesis."</td>";
    $projects = $projects."<td ".$class_cell.">".$project."</td>";
    $publications = $publications."<td ".$class_cell.">".$publication."</td>";
    $presentations = $presentations."<td ".$class_cell.">".$presentation."</td>";

    $loop_year = $loop_year -1;
    $i++;
}





echo <<<EOF
<thead><tr>$years</tr></thead>
<tr class='odd'>$dissertations</tr>
<tr>$theses</tr>
<tr class='odd'>$projects</tr>
<tr>$publications</tr>
<tr class='odd'>$presentations</tr>




	</table>
	<p align="center">**Data collection started in 2008, but there are recorded citations as early as 2001. </p>
	<p align="center">*current year</p>
	</div>
EOF;
?>
<h2 id='c'>Citations </h2>
<div id='research_data_nav'>
<ul id='research_menu'>
	<li class='research_options' id='dissertations'>Dissertations</li>
	<li class='research_options' id='theses'>Theses</li>
	<li class='research_options' id='projects'>Projects</li>
	<li class='research_options' id='publications'>Publications</li>
	<li class='research_options' id='presentations'>Presentations</li>
</ul>
</div>
<div id='research_data_view' style="min-height: 550px;padding: 10px;">
<div id='list_publications' class='research_folder'>
	<h1>Publications</h1>
<table id='publications_table'>
				<thead>
					<tr>
						<td>  </td>
					</tr>
				</thead>

	<?php
        $query = $db->prepare("Select * from Citations  where type='publication' order by year DESC");
        $query->execute();
  $result = $query->get_result();

            while ($pubs = $result->fetch_assoc()) {
                ?>
			<tr>

				<td> <?php echo $pubs['citation']; ?></td>
			</tr>
		<?php

            }

        $result->free();

?>
			</table>
</div>
<div id='list_presentations' class='research_folder'>
<h1>Presentations</h1>
<table id='presentations_table'>
				<thead>
					<tr>
						<td>  </td>
					</tr>
				</thead>

	<?php
        $query = $db->prepare("Select * from Citations  where type='presentation' order by year DESC");
        $query->execute();
  $result = $query->get_result();

            while ($pubs = $result->fetch_assoc()) {
                ?>
			<tr>

				<td> <?php echo $pubs['citation']; ?></td>
			</tr>
		<?php

            }

        $result->free();

?>
			</table>
</div>
<div id='list_theses' class='research_folder'>
<h1>Theses</h1>
<table id='theses_table'>
				<thead>
					<tr>
						<td>  </td>
					</tr>
				</thead>

	<?php
        $query = $db->prepare("Select * from Citations  where type='thesis' order by year DESC");
        $query->execute();
    $result = $query->get_result();

            while ($pubs = $result->fetch_assoc()) {
                ?>
			<tr>

				<td> <?php echo $pubs['citation']; ?></td>
			</tr>
		<?php

            }

        $result->free();

?>
			</table>
</div>
<div id='list_projects' class='research_folder'>
<h1>Projects</h1>
<table id='projects_table'>
				<thead>
					<tr>
						<td>  </td>
					</tr>
				</thead>

	<?php
        $query = $db->prepare("Select * from Citations  where type='project' order by year DESC");
        $query->execute();
  $result = $query->get_result();

            while ($pubs = $result->fetch_assoc()) {
                ?>
			<tr>

				<td> <?php echo $pubs['citation']; ?></td>
			</tr>
		<?php

            }

        $result->free();

?>
			</table>
</div>
<div id='list_dissertations' class='research_folder'>
<h1>Dissertations</h1>
<table id='dissertations_table'>
				<thead>
					<tr>
						<td>  </td>
					</tr>
				</thead>

	<?php
        $query = $db->prepare("Select * from Citations  where type='dissertation' order by year DESC");
        $query->execute();
  $result = $query->get_result();

            while ($pubs = $result->fetch_assoc()) {
                ?>
			<tr>

				<td> <?php echo $pubs['citation']; ?></td>
			</tr>
		<?php

            }

        $result->free();

?>
			</table>
</div>
</div>
