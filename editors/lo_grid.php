<?php
	include_once("../../../connectFiles/connect_cis.php");
	$i=1;
	$ids = "";
	$query = "Select course_id from Courses";
				if(!$result = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');		
				}
			while($row = $result->fetch_assoc()){
				$ids=$ids."#".$row['course_id'].", ";
				
			}
	if (isset($_GET['edit'])) {$editable=1;} else {$editable=0;}
?>

<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
	<title>Learning Outcome Grid </title>
	<meta name="description" content="" />
  	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<link href="lo_grid.css" rel="stylesheet" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Martel:400,200' rel='stylesheet' type='text/css'>
	<link href="../style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>

<!-- 	Javascript -->
	<script>
	$(document).ready(function() {
	editable = <?php echo $editable; ?>;
	
	if (editable==1) {
	course_id = 0;
	$(".lo").focus(function(){
		course_id=this.id;
		
	});	

	$("#save").click(function(){
		save();
	});
	
	$("div").blur(function(){
		save();
	});
	
	 $(window).keydown(function (e){
    if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) { /*ctrl+s or command+s*/
        save();
        e.preventDefault();
        return false;
    }
	});
	 tinymce.init({
            selector: "<?php echo $ids; ?> #aa",
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
    		toolbar: ["undo redo | cut copy pasterollup | styleselect | bold italic removeformat | table | alignleft aligncenter alignright |", "backcolor | bullist numlist | insertrollup | linksrollup | coderollup | save |",],
    		browser_spellcheck: true,
			save_onsavecallback: function() {save();},
			setup: function (editor) {
               // Custom Blur Event to stop hiding the toolbar
                editor.on('blur', function (e) {
                   e.stopImmediatePropagation();
                   e.preventDefault();
                });
            }
			
			
        });
        $("#level_descriptor").click();
// tinyMCE.execCommand("mceAddControl", true, '#level_descriptor');
function save() {
		learning_outcomes = $("#"+course_id).html();
		console.log(course_id);
		console.log(learning_outcomes);
		
$.ajax({
			method: "POST",
			url: "save-outcome.php",
			data: { 
				course_id: course_id,
				learning_outcomes: learning_outcomes,
				
				}
		}).done(function(phpfile) {
		w=window.innerWidth;
		l=(w-500)/2;
		$("#save_dialog").html(phpfile).css({
			left: l,
		}).slideDown().delay(2000).fadeOut(2000);

  		});
  	}	
  	} else { 
	  	$(".lo").attr('contenteditable','false');
	  	setTimeout(refresh, 10000);
  	}
  	
//   	function refresh() {window.location.reload(true);}
});	

</script>

</head>
<body>
	<div id='content'>
	<div id='table'>
	
	<?php
	
		
		while($i<$Levels+1){
			echo "<div class='newRow'>";
			$query = "Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where Levels.level_id=$i order by Courses.course_order";
				if(!$result = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');		
				}
			while($row = $result->fetch_assoc()){
				echo "<div class='editable'><h2>".$row['level_name']." - ".$row['course_name']."</h2>";
				echo "<div class='lo' contenteditable='true' id='".$row['course_id']."'>".$row['learning_outcomes'] . "</div>";
				echo "</div>";
			}
			$i++;
			echo "</div>";
			$result->free();
		}
	?>

</div>
</div>
<div id="save_dialog"></div>
</body>
</html>