<?php

$level_id=$_GET['level_id'];
echo $level_id;
        $query = $elc_db->prepare("Select * from Levels where level_id = ?");
        $query->bind_param("s", $level_id);
            $query->execute();
            $result = $query->get_result();
        while ($levels = $result->fetch_assoc()) {
            echo "<div class='content-background' id='".$levels['level_short_name']."'><div class='content'>";
						echo "<a class='pdf_icon' target='_new' title='Save PDF' href='print_pdf.php?print_id=".$levels['level_id']."'></a>";

            echo "<h1>".$levels['level_name']."</h1>";





            echo $levels['level_descriptor'];
            echo "<h3>Courses</h3>";
                echo "<div class='course_list'>";
                $course_query = $elc_db->prepare("Select * from Courses where level_id = ? order by course_order");
								$course_query->bind_param("s",$levels['level_id']);
								$course_query->execute();
            		$courses_result = $course_query->get_result();
            while ($courses = $courses_result->fetch_assoc()) {
                echo "<a class='course_icon' style='margin-left:8px' href='course.php?course_id=".$courses['course_id']."'>".$courses['course_name']."</a> ";
            }
                echo "</div>";
            echo "</div></div>";
        }
            echo "</div>";
        $result->free();

?>