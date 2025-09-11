<?php

$query_teachers = $elc_db->prepare("Select * from User_access where net_id=?");
$query_teachers->bind_param("s", $net_id);
$query_teachers->execute();
$result_admins = $query_teachers->get_result();
if (mysqli_num_rows($result_admins) > 0) {
  $teacher_access=TRUE; $message ="";
} else {
  $teacher_access=FALSE;
  $message="You do not have access to this page. <a href='https://elc.byu.edu/curriculum'>Go back</a>";
}
 ?>
