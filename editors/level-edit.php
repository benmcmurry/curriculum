<?php


$level_id = $_GET['level_id'];$message ="";
if ($level_id < 1) {$message = "Invalid level. Showing first level."; $level_id = 1;}
if ($level_id > 9) {$message = "Invalid level. Showing last level."; $level_id = 8;}

include_once("../../../connectFiles/connect_cis.php");
include_once("../cas-go.php");
include_once("admins.php");
$query = $elc_db->prepare("Select * from Levels_review where level_id= ? ");
$query->bind_param("s", $level_id);
$query->execute();
$result = $query->get_result();
while($level = $result->fetch_assoc()){
	$level_name = $level['level_name'];
	$level_short_name = $level['level_short_name'];
	$level_descriptor = $level['level_descriptor'];
	$level_updated_by = $net_id;
	$level_active = $level['active'];


	}

?>

<!DOCTYPE html>
<html lang="en">
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

		current_level_name = $("#level_name").text();
		current_level_descriptor = $("#level_descriptor").text();
		current_level_short_name = $("#level_short_name").text();
		current_level_active = $("#level_active").text();

	$("#save").click(function(){
		save("save button");
	});

	$("div").blur(function(){
		save(this.id);
	});

	 $(window).keydown(function (e){
    if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) { /*ctrl+s or command+s*/
        save();
        e.preventDefault();
        return false;
    }
	});
	 tinymce.init({
            selector: "#level_descriptor",
            inline: true,
            menubar: false,
            nowrap: false,
            plugins: [
         "autolink link image lists charmap hr anchor pagebreak save",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons template paste textcolor rollups"
   ],
   			paste_auto_cleanup_on_paste : true,
            style_formats: [
        {title: 'Normal', inline: 'p'},
        {title: 'Heading', block: 'h3'},
        {title: "Sub-heading", block: 'h4'}

    ],
    		toolbar: "undo redo | cut copy pasterollup | styleselect | bold italic removeformat | table | alignrollup | bullist numlist | insertrollup | linksrollup | coderollup | ",
    		browser_spellcheck: true,
			save_onsavecallback: function() {save();},
			setup: function (editor) {
               // Custom Blur Event to stop hiding the toolbar
                editor.on('blur', function (e) {
                   e.stopImmediatePropagation();
                   e.preventDefault();
                });
                 editor.on('focus',function (e) {
	                current_editor = this.id;
	                $.when( $(".editable").css("margin-top", "0px")).done(function(){$("#"+current_editor).css("margin-top", "40px")});
                });
            }


        });
        $("#level_descriptor").click();
// tinyMCE.execCommand("mceAddControl", true, '#level_descriptor');

});

function save() {
		 if (current_level_name == $("#level_name").text() &&
		 current_level_descriptor == $("#level_descriptor").text() &&
		 current_level_short_name == $("#level_short_name").text() &&
		 current_level_active == $("#level_active").text())
		 {return;}

		// if ( ==  ||  ==  ||  == $("#level_short_name").text())
		level_id = <?php echo $level_id; ?>;
		level_name = $("#level_name").text();
		level_short_name = $("#level_short_name").text();
		level_descriptor = $("#level_descriptor").html();
		level_active = $("#level_active").text();
		net_id = '<?php echo $net_id; ?>';
		$.ajax({
			method: "POST",
			url: "save-level.php",
			data: {
				level_id: level_id,
				level_name: level_name,
				level_short_name: level_short_name,
				level_descriptor: level_descriptor,
				level_active: level_active,
				net_id: net_id,
				needs_review: "1",
				level_updated_by: "<?php echo $level_updated_by; ?>"
				}
		}).done(function(phpfile) {
		$("#save_dialog").html(phpfile);
  		});
}

</script>
</head>
<body>
	<a class="skip-link" href="#main-content">Skip to editor content</a>
	<?php require_once("../content/header-short.php"); 
	if ($message) {
		echo "<div class='container-md pt-4'><div class='alert alert-info' role='status'>".$message."</div></div>";
	}


      if ($auth && $access) { ?>
	  	<main id="main-content" class="container-md editor-main py-4">
			<section class="editor-topbar sticky-top mb-3" aria-label="Editor actions">
				<div class="d-flex flex-wrap gap-2">
					<a type="button" class="btn btn-outline-secondary" id="toPortfolio" href="../levels.php#<?php echo $level_short_name;?>"><i class="bi bi-back"></i> Portfolio</a>
					<a type="button" class="btn btn-outline-secondary" id="go_back" href="index.php"><i class="bi bi-grid-3x3-gap"></i> Editor Menu</a>
					<a type="button" class="btn btn-outline-secondary" id="previous" href="level-edit.php?level_id=<?php echo $level_id-1;?>"><i class="bi bi-arrow-left-circle"></i> Previous</a>
					<a type="button" class="btn btn-outline-secondary" id="next" href="level-edit.php?level_id=<?php echo $level_id+1;?>">Next <i class="bi bi-arrow-right-circle"></i></a>
					<a type="button" class="btn btn-primary ms-auto" id="save"><i class="bi bi-server"></i> Save</a>
				</div>
			</section>

			<div class="editor-save-dialog mb-3" id="save_dialog"></div>

			<section class="editor-panel mb-3">
				<div class="editor-panel-header editor-panel-header-level">
					<h2 class="h4 mb-0">Level Editor: <?php echo $level_name; ?></h2>
				</div>
				<div class="editor-panel-body editor-form-grid">
		<label for="level_short_name" class="form-label">Level Short Name</label>
		<div id="level_short_name" class="form-control" contenteditable="true" aria-describedby="shortNameHelp"><?php echo $level_short_name; ?></div>
		<div id="shortNameHelp" class="form-text mb-4">Limit to 1 or 2 characters. (i.e. FA)</div>


		<label for="level_name" class="form-label">Level Name</label>
		<div id="level_name" class="form-control rte" contenteditable="true" aria-describedby="levelNameHelp"><?php echo $level_name; ?></div>
		<div id="levelNameHelp" class="form-text mb-4">Please use standard naming conventions. (i.e. Foundations A)</div>

		<label for="level_descriptor" class="form-label">Descriptor</label>
			<div id="level_descriptor" class="form-control" aria-describedby="descriptorHelp"><?php echo $level_descriptor; ?></div>
			<div id="descriptorHelp" class="form-text mb-4">Level Descriptors should include function and text-type.</div>
		
		
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" role="switch" id="level_active" <?php if ($level_active == 1) {echo "checked";} ?> onchange="if(this.checked){$('#level_active').text('1');}else{$('#level_active').text('0');}">
  <label class="form-check-label" for="level_active"><?php if ($level_active == 1) {echo "Active";} else {echo "Inactive";} ?></label>
</div>
<script>
  document.getElementById('level_active').addEventListener('change', function() {
    const label = document.querySelector('label[for="level_active"]');
    label.textContent = this.checked ? 'Active' : 'Inactive';
  });
</script>

				</div>
			</section>
		</main>
	<?php } ?>
	<footer>
        <?php include("../content/footer.html"); ?>
    </footer>
</body>
</html>
