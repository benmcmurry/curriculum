<div id="header-container" class='flex-row'>
	<div id='menu-collapse' class='flex-initial'><img id="menu" src='images/menu-white.gif' />
	</div>

	<div id='header-info' class='flex-1'>
		<div id="byu-bar" class='flex-column' style=''>
			<a href="http://www.byu.edu"><img id="byu-logo" src="images/byu-logo-light.png" /></a>
		</div>
		<div id="elc-bar" class='flex-row'>
			<?php
				echo "<img class='flex-inital' id='byuhum-logo' src='images/byuhum-logo.png' />";
				echo "<div id='elc-info' class='flex-column flex-1'><h1>".$institution."</h1>";
				echo "<h2>".$name."</h2></div>";
			?>
		</div>
	</div>
	<div class='flex-initial' id='login'>
	<?php echo $button;	?>
	</div>
</div>
