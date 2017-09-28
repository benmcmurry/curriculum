<?php

include_once("../../../connectFiles/connect_cis.php");
if ($local == 0) {
    include_once("../CASauthinator.php");
    $net_id = Authenticator::getUser();
} else {
    $net_id = "blm39";
}
if ($net_id == 'blm39') {echo "cleared!";}
else {exit();}
?>

<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
	<title></title>
	<meta name="description" content="" />
  	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<?php include("styles_and_scripts.html"); ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>

	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

</head>
<!-- 	Javascript -->
	<script>

$(document).ready(function() {
		 $('#citations').dataTable({
	    aLengthMenu: [
        [10, 20, 50, -1],
        [10, 20, 50, "All"]
    ],
    });

$("td").on("blur", function(){
	value = $(this).text();
	data = this.id.split('-');
	stat_id = data[0];
	field = data[1];
	console.log(value);
	console.log(stat_id);
	console.log(field);

	$.ajax({
		method: "POST",
		url: "edit-stat.php",

		data: {
			stat_id: stat_id,
			field: field,
			value: value,
			}
	}).done(function(phpfile) {
	$("#display_box").html(phpfile);
		});
});

$("a#add_semester").on("click", function(){
	$.ajax({
		method: "POST",
		url: "add_semester.php",
	}).done(function(phpfile) {
	$("#display_box").html(phpfile);
		});
});


	});

function editPopup(id) {
	$("#faded-background").show();
	offset = $("#"+id).offset();
	w = 800;
	$("#popup").css({"left" : offset.left+50, "top" : 0, "width" : w});

	$.ajax({
			method: "POST",
			url: "edit-popup.php",
			data: {
				id: id,

				}
		}).done(function(phpfile) {
		$("#popup-content").html(phpfile);
		$("#popup").show();
  		});

}

</script>
</head>
<body>
	<header>
		<h1>Profile Editor</h1>
		<div id="display_box"></div>
	</header>
<article>
	<div class="content">
		<h1>Edit Statistics</h1>
		<div class="main">
			<a id="add_semester" class="button">+</a>
			<table id='teaching'>
				<thead>
					<tr>
						<th class="rotate"><div><span>Semester</span></div></th>
						<th class="rotate"><div><span>Year</span></div></th>
						<th class="rotate"><div><span>Classes Taught</span></div></th>
						<th class="rotate"><div><span>Supplemental Classes Taught</span></div></th>
						<th class="rotate"><div><span>Classes taught by Students</span></div></th>
						<th class="rotate"><div><span>Graduate Practicum Students</span></div></th>
						<th class="rotate"><div><span>Undergraduate Practicum Students</span></div></th>
						<th class="rotate"><div><span>Tutoring Hours</span></div></th>
						<th class="rotate"><div><span>Class Observations</span></div></th>
						<th class="rotate"><div><span>Graduate Internships</span></div></th>
						<th class="rotate"><div><span>Undergraduate Internships</span></div></th>
					</tr>
				</thead>
<?php
  $query_stats = $elc_db->prepare("Select * from Statistics order by year DESC, Semester DESC");
  $query_stats->execute();
  $result_stats = $query_stats->get_result();

	while($stats = $result_stats->fetch_assoc()){
		?>
				<tr>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-semester"><?php echo substr($stats['semester'], 1);?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-year"><?php echo $stats['year'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-classes_taught"><?php echo $stats['classes_taught'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-supplemental_classes_taught"><?php echo $stats['supplemental_classes_taught'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-classes_taught_by_students"><?php echo $stats['classes_taught_by_students'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-graduate_practicum_students"><?php echo $stats['graduate_practicum_students'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-undergraduate_practicum_students"><?php echo $stats['undergraduate_practicum_students'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-tutoring_hours"><?php echo $stats['tutoring_hours'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-class_observations"><?php echo $stats['class_observations'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-graduate_internships"><?php echo $stats['graduate_internships'];?></td>
					<td contenteditable="true" id="<?php echo $stats['id'];?>-undergraduate_internships"><?php echo $stats['undergraduate_internships'];?></td>
				</tr>
			<?php }
			$result_stats->free();

			?>
				</table>
		</div>

	</div>

	<div class="content">
		<h1> Edit a citation </h1>
		<div class="main">
			<table id='citations'>
				<thead>
					<tr>
						<td> Edit </td>
						<td width="100px;"> Year </td>
						<td> Type </td>
						<td> Citation </td>
					</tr>
				</thead>

	<?php
		$query = $elc_db->prepare("Select * from Citations order by id DESC");
    $query->execute();
    $result = $query->get_result();
		
			while($pubs = $result->fetch_assoc()){

			?>
			<tr>
				<td> <a id='<?php echo $pubs['id']; ?>' class='button edit' onClick="editPopup(this.id)">Edit</a></td>
				<td> <?php echo $pubs['year']; ?></td>
				<td> <?php echo $pubs['type']; ?></td>
				<td> <?php echo $pubs['citation']; ?></td>
			</tr>
		<?php

		}

		$result->free();

?>
			</table>
		</div>
	</div>
</article>
</body>
<div id="popup" class="popup">
	<div id="popup-content">
	</div>
</div>
<div id="faded-background">hello</div>

</html>
