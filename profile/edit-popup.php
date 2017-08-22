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
	$id = $_POST['id'];
?>


<!-- 	Javascript -->
	<script>
	$(document).ready(function() {


	$(".save").click(function(){
		save(this.id);
	});

	tinymce.init({
            selector: ".editable",
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


function save(id) {

		console.log("saving");
		citation = $("#"+id+"-citation").html();
		citationParts = $("#"+id+"-citation").text();
			parts = citationParts.split(").");
			parts2 = parts[0].split("(");
		year = parts2[1];

		authors = parts2[0].replace(/&amp; |<p>/gi,"");
		citation = citation.replace(/<[\/]{0,1}(span)[^><]*>/ig,"");
		citation = citation.replace(/<[\/]{0,1}(p)[^><]*>/ig,"");
		citation = "<p>"+citation+"</p>";
		type = $("#"+id+"-type option:selected").text();
		console.log("ID: "+id+", Year: "+year+", Authors: "+authors+", Type: "+type);



		$.ajax({
			method: "POST",
			url: "edit-citation.php",
			data: {
				id: id,
				citation: citation,
				year: year,
				authors: authors,
				type: type,
				}
		}).done(function(phpfile) {
		$("#"+id+"-save_dialog").html(phpfile);
  		});

}


</script>


	<?php
		$query = $db->prepare("Select * from Citations where id = ? ");
		$query->bind_param("s", $id);
		$query->execute();
		$result = $query->get_result();

			while($pubs = $result->fetch_assoc()){

			?>


			<h2>Citation</h2> <div id="<?php echo $pubs['id']; ?>-citation" class="editable citation" contenteditable="true"><?php echo $pubs['citation']; ?></div>
			<select id="<?php echo $pubs['id']; ?>-type" style="font-size: 2em;">
					<option value="Publication" <?php if ($pubs['type'] == "Publication") {echo " selected";} ?>>Publication</option>
					<option value="Presentation" <?php if ($pubs['type'] == "Presentation") {echo " selected";} ?>>Presentation</option>
					<option value="Thesis or Dissertation" <?php if ($pubs['type'] == "Thesis or Dissertation") {echo " selected";}?>>Thesis or Dissertation</option>
					<option value="Thesis" <?php if ($pubs['type'] == "Thesis") {echo " selected";}?>>Thesis</option>
					<option value="Project" <?php if ($pubs['type'] == "Project") {echo " selected";}?>>Project</option>
					<option value="Dissertation" <?php if ($pubs['type'] == "Dissertation") {echo " selected";}?>>Dissertation</option>

				</select>
			<div class="separator"></div>
			<a class="button save" id="<?php echo $pubs['id']; ?>">Save</a>
			<div id="<?php echo $pubs['id']; ?>-save_dialog" class="save_dialog"></div>

		<?php

		}

		$result->free();
?>
