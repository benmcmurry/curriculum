<?php

$query_admins = $elc_db->prepare("Select * from User_access where net_id=? and access='admin'");
$query_admins->bind_param("s", $net_id);
$query_admins->execute();
$result_admins = $query_admins->get_result();
if (mysqli_num_rows($result_admins) > 0) {
  $access=TRUE; $message ="";
} else {
  $access=FALSE;
  $message="You do not have access to this page. <a href='https://elc.byu.edu/curriculum'>Go back</a>";
}

 ?>
