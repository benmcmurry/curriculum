<div id="faded-background"></div>
<div id="login_popup" class="popup">
	Login to access curriculum resources.

	<form method="POST" action="start.php">
	<input type="password" name="password" id="password" />
	<input type="hidden" name="current_page" value="<?php echo $current_page; ?>" />
	<input type="submit" id="submit_button" value="Login" />
</div>
<div id="add_popup" class="popup">
	<?php
	//	include("profile/add.php");
	?>
</div>
