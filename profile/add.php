<?php

include_once("cas-go.php");
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

</head>
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
	 tinymce.init({
            selector: "#citation",
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
    		toolbar: "undo redo | cut copy pasterollup | italic removeformat | ",
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



});

function save() {
		console.log("saving");
		citation = $("#citation").html();
		citationParts = $("#citation").text();
			parts = citationParts.split(").");
			parts2 = parts[0].split("(");
		year = parts2[1];

		authors = parts2[0].replace(/&amp; |<p>/gi,"");
		citation = citation.replace(/<[\/]{0,1}(span)[^><]*>/ig,"");
		citation = citation.replace(/<[\/]{0,1}(p)[^><]*>/ig,"");
		citation = "<p>"+citation+"</p>";
		type = $("#type option:selected").text();




		$.ajax({
			method: "POST",
			url: "save-citation.php",
			data: {
				citation: citation,
				year: year,
				authors: authors,
				type: type,
				}
		}).done(function(phpfile) {
		$("#save_dialog").html(phpfile);
  		});

}

</script>
</head>
<body>
	<header>
			<h1> Add a citation </h1>
	</header>
<article>
		<div class="content-background">
			<div class="main">

			<h2>Citation</h2> <div id="citation" class="editable" contenteditable="true"></div>
			<select id="type" style="font-size: 2em;">
					<option value="Publication">Publication</option>
					<option value="Presentation" >Presentation</option>
					<option value="Thesis or Dissertation" >Thesis or Dissertation</option>
					<option value="Thesis" >Thesis</option>
					<option value="Project" >Project</option>
					<option value="Dissertation">Dissertation</option>

				</select>
			<div class="separator"></div>
			<a class="button" id="save">Save</a>
			<div id="save_dialog" class="save_dialog"></div>
		</div>
</article>
<body>


</html>
