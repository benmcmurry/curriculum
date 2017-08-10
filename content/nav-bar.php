<?php

$current_page = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

	<div id="byu-bar">

	<a href="http://www.byu.edu"><img src="images/byu-logo-light.png" /></a>
	<?php
		if(!isset($_SESSION['password'])){echo "<a id='teacher-login' class='button'><span>Teacher Login</span></a>";}
		else {echo "<a href='logout.php?current_page=".$current_page."' id='teacher-logout' class='button'><span>Logout</span></a>";}
?>
</div>
<div id="nav-container">
	<div id="nav-bar">

		<a href="index.php">Mission</a>
		<a href="levels.php">Level Descriptors</a>
		<a href="courses.php">Courses</a>
		<a href="profile.php">Profile </a>
	</div>
</div>
