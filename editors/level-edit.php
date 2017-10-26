<?php


$level_id = $_GET['level_id'];$message ="";
if ($level_id < 1) {$message = "Invalid level. Showing first level."; $level_id = 1;}
if ($level_id > 8) {$message = "Invalid level. Showing last level."; $level_id = 8;}

include_once("../../../connectFiles/connect_cis.php");
include_once("cas-go.php");
include_once("admins.php");

$query = $elc_db->prepare("Select * from Levels where level_id= ? ");
$query->bind_param("s", $level_id);
$query->execute();
$result = $query->get_result();
while($level = $result->fetch_assoc()){
	$level_name = $level['level_name'];
	$level_short_name = $level['level_short_name'];
	$level_descriptor = $level['level_descriptor'];
	$level_updated_by = $net_id;


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

		current_level_name = $("#level_name").text();
		current_level_descriptor = $("#level_descriptor").text();
		current_level_short_name = $("#level_short_name").text();

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

function save(field) {
	console.log(field);
		switch (field) {
			case "level_name":
				 if (current_level_name == $("#level_name").text()) {console.log("same"); return;}
				break;
			case "level_descriptor":
				if (current_level_descriptor == $("#level_descriptor").text()) {console.log("same");return;}
				break;
			case "level_short_name":
				if (current_level_short_name == $("#level_short_name").text()) {console.log("same");return;}
				break;
		}
		// if ( ==  ||  ==  ||  == $("#level_short_name").text())
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
	<header>

			<h1> Level Editor: <?php echo $level_name; ?></h1>
			<div id="user"><?php echo $net_id." | <a href='?logout='>Logout</a>"; ?></div>
			<?php echo $message;

      if ($auth && $access) { ?>
			<a class="button" id="go_back" href="index.php">Main Menu</a>
			<a class="button" id="previous" href="level-edit.php?level_id=<?php echo $level_id-1;?>">Previous Level</a>
			<a class="button" id="next" href="level-edit.php?level_id=<?php echo $level_id+1;?>">Next Level</a>
			<a class="button" id="save">Save</a>
			<div id="save_dialog"></div>

	</header>
	<article>
		<div class="content-background">
			<div class="main">
				<div class="separator">
				<h2>Level Short Name (limit to 1 or 2 characters)</h2> <div id="level_short_name" class="editable" contenteditable="true"><?php echo $level_short_name; ?></div>
				</div>
				<div class="separator">
				<h2>Level Name</h2> <div id="level_name" class="editable rte" contenteditable="true"><?php echo $level_name; ?></div></div>
				<div class="separator">
				<h2>Descriptor</h2>

			        <div id="level_descriptor" class="editable"><?php echo $level_descriptor; ?></div>
				</div>

			</div>
		</div>
	<?php } ?>
	</article>
</body>
</html>
