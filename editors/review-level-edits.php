<?php
include_once("../../../connectFiles/connect_cis.php");
if ($local == 0) {
  include_once("../CASauthinator.php");
  $net_id = Authenticator::getUser();
} else {$net_id = "blm39";}
$level_id = $_GET['level_id'];

$query = $db->prepare("Select * from Levels where level_id = ? ");
$query->bind_param("s", $level_id);
$query->execute();
$result = $query->get_result();

  while ($level = $result->fetch_assoc()) {
      $level_name = $level['level_name'];
      $level_short_name = $level['level_short_name'];
      $level_descriptor = $level['level_descriptor'];
      $level_updated_by = $level['level_updated_by'];
      $level_updated_on = $level['level_updated_on'];
  }

$query_edits = $db->prepare()"Select * from Levels_review where level_id = ? ");
$query_edits->bind_param("s", $level_id);
$query_edits->execute();
$result_edits = $query_edits->get_result();

  while ($level_edits = $result_edits->fetch_assoc()) {
      $level_name_edits = $level_edits['level_name'];
      $level_short_name_edits = $level_edits['level_short_name'];
      $level_descriptor_edits = $level_edits['level_descriptor'];
      $level_updated_by_edits = $level_edits['level_updated_by'];
      $level_updated_on_edits = $level_edits['level_updated_on'];
  }

?>

<!DOCTYPE html>
<html lang="">
<head>
	<title>Level Editor - <?php echo $level_name; ?></title>

<!-- 	Meta Information -->
	<meta charset="utf-8">
	<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
	<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("styles_and_scripts.html"); ?>


	<!-- 	Javascript -->
	<script>
	$(document).ready(function() {


	$("#save").click(function(){
		save();
	});



	 $(window).keydown(function (e){
    if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) { /*ctrl+s or command+s*/
        save();
        e.preventDefault();
        return false;
    }
	});

});

function save() {
		level_id = <?php echo $level_id; ?>;
		level_name = $("#level_name").text();
		level_short_name = $("#level_short_name").text();
		level_descriptor = $("#level_descriptor").html();
		net_id = '<?php echo $net_id; ?>';
		$.ajax({
			method: "POST",
			url: "save-level.php",
			data: {
				level_id: level_id,
				level_name: level_name,
				level_short_name: level_short_name,
				level_descriptor: level_descriptor,
				net_id: net_id,
				needs_review: "0",
				level_updated_by: "<?php echo $level_updated_by_edits; ?>"

				}
		}).done(function(phpfile) {
		$("#save_dialog").html(phpfile);
  		});
}

</script>
</head>
<body>
	<header>
			<h1> Review Level Edits: <?php echo $level_name; ?></h1>
			<div id="user"><?php echo $net_id; ?></div>
			<!-- <button id="save">Save</button> -->
			<a class="button" id="go_back" href="index.php">Main Menu</a>
			<a class="button" id="save">Save</a>
			<div id="save_dialog"></div>

	</header>
	<article>
		<div class="content-background">
			<div class="main">
			<table id='differences' width="100%" cellpadding="10" border="1" cellspacing="0">
				<tr>
					<td><h2>Original</h2>Last updated at <?php echo $level_updated_on; ?> by <?php echo $level_updated_by; ?></td>
					<td><a class="button" style="float: right;" href="level-edit.php?level_id=<?php echo $level_id;?>">Click here to edit</a><h2 >Edits</h2>Last updated at <?php echo $level_updated_on_edits; ?> by <?php echo $level_updated_by_edits; ?></td>
				</tr>
				<tr>
					<td colspan="2"><h2>Level Name</h2></td>
				</tr>
				<tr>
					<td width="50%"><?php echo $level_name; ?></td>
					<td width="50%" id="level_name" <?php if ($level_name !== $level_name_edits) {
    echo "style='color: green;background-color:#efefef;'";
}?> ><?php echo $level_name_edits; ?></td>
				</tr>
				<tr>
					<td colspan="2"><h2>Level Short Name</h2></td>
				</tr>
				<tr>
					<td width="50%"><?php echo $level_short_name; ?></td>
					<td width="50%" id="level_short_name" <?php if ($level_short_name !== $level_short_name_edits) {
			echo "style='color: green;background-color:#efefef;'";
		}?> ><?php echo $level_short_name_edits; ?></td>
				</tr>

				<tr>
					<td colspan="2"><h2>Descriptor</h2></td>
				</tr>
				<tr>
					<td width="50%"><?php echo $level_descriptor; ?></td>
					<td width="50%" id="level_descriptor" <?php if ($level_descriptor !== $level_descriptor_edits) {
				echo "style='color: green;background-color:#efefef;'";
				}?> ><?php echo $level_descriptor_edits; ?></td>
				</tr>

			</table>


			</div>
		</div>
	</article>
</body>
</html>
