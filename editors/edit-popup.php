<?php

session_start();
include_once("../../../connectFiles/connect_cis.php");
include_once("../cas-go.php");
$id = $_GET['id'];
?>


<!-- 	Javascript -->
<script>
$(document).ready(function() {

    tinymce.init({
        selector: ".citation",
        inline: true,
        menubar: false,
        nowrap: false,
        plugins: [
            "autolink link image lists charmap hr anchor pagebreak save",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template paste textcolor rollups"
        ],
        paste_auto_cleanup_on_paste: true,
        style_formats: [{
                title: 'Normal',
                inline: 'p'
            },
            {
                title: 'Heading',
                block: 'h3'
            },
            {
                title: "Sub-heading",
                block: 'h4'
            }

        ],
        toolbar: "undo redo | cut copy pasterollup | italic removeformat | ",
        browser_spellcheck: true,
        save_onsavecallback: function() {
            save();
        },

    });



});
</script>


<?php
		$query = $elc_db->prepare("Select * from Citations where id = ? ");
		$query->bind_param("s", $id);
		$query->execute();
		$result = $query->get_result();

			while($pubs = $result->fetch_assoc()){

			?>


<div id="<?php echo $pubs['id']; ?>-citation" class="form-control citation" contenteditable="true">
    <?php echo $pubs['citation']; ?></div>
<select id="<?php echo $pubs['id']; ?>-type" class='form-control'>
    <option value="Publication" <?php if ($pubs['type'] == "Publication") {echo " selected";} ?>>Publication</option>
    <option value="Presentation" <?php if ($pubs['type'] == "Presentation") {echo " selected";} ?>>Presentation</option>
    <option value="Thesis or Dissertation" <?php if ($pubs['type'] == "Thesis or Dissertation") {echo " selected";}?>>
        Thesis or Dissertation</option>
    <option value="Thesis" <?php if ($pubs['type'] == "Thesis") {echo " selected";}?>>Thesis</option>
    <option value="Project" <?php if ($pubs['type'] == "Project") {echo " selected";}?>>Project</option>
    <option value="Dissertation" <?php if ($pubs['type'] == "Dissertation") {echo " selected";}?>>Dissertation</option>

</select>
<div id="<?php echo $pubs['id']; ?>-save_dialog" class="save_dialog"></div>

<?php

		}

		$result->free();
?>