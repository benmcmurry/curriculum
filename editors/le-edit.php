<?php
include_once("../../../connectFiles/connect_cis.php");

$learningExperienceId = $_GET['learningExperienceId'];
include_once("../auth.php");
include_once("admins.php");
$name = "Learning Experience";
$short_description = "";
$description = "";
$emphasis = "None";
$updatedBy = "";
$courses = array();
if ($learningExperienceId == "new") {
    $query = $elc_db->prepare("Insert into Learning_experiences (name, created_by, created_on) values ('Untitled Learning Experience', ?, NOW())");
    $query->bind_param("s", $net_id);
    
    $query->execute();
    $learningExperienceId = $elc_db->insert_id;
    echo $learningExperienceId;
}
$query = $elc_db->prepare("Select * from Learning_experiences where learning_experience_id = ?");
$query->bind_param("s", $learningExperienceId);
$query->execute();
$result = $query->get_result();

while ($learningExperience = $result->fetch_assoc()) {
    $name = $learningExperience['name'];
    $short_description = $learningExperience['short_description'];
    $description = $learningExperience['description'];
    $emphasis = $learningExperience['emphasis'];
    // $required = $learningExperience['required'];
    // $assessment = $learningExperience['assessment'];
    $updatedBy = $learningExperience['updated_by'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Learning Experience Editor - <?php echo $name; ?></title>

<!-- 	Meta Information -->
<meta charset="utf-8">
<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("styles_and_scripts.html"); ?>
<!-- 	Javascript -->
<script>
    function setLESaveStatus(message, tone) {
        var saveDialog = $("#save_dialog");
        saveDialog
            .removeClass("alert alert-danger alert-success alert-info")
            .addClass("editor-status");
        if (tone === "error") {
            saveDialog.addClass("alert alert-danger");
        } else if (tone === "success") {
            saveDialog.addClass("alert alert-success");
        } else {
            saveDialog.addClass("alert alert-info");
        }
        saveDialog.text(message);
    }

    $(document).ready(function() {
        $("#emphasis option[value='<?php echo $emphasis; ?>']").prop('selected',true); 
        current_name = $("#name").text();
        current_short_description = $("#short_description").text();
        current_description = $("#description").text();
        

    $("#save").on("click", function(){
        save("button");
    });
    $("#delete").on("click", function(){
        deleteLe();
    });

    $(".editor-form-grid [contenteditable='true']").on("blur", function(){
        save(this.id);
    });

     $(window).keydown(function (e){
    if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) { /*ctrl+s or command+s*/
        save();
        e.preventDefault();
        return false;
    }
    });

    $('input:checkbox').change(function(){save();}); //calls save function when checkbox status changes.
    $( "#connected_courses" ).on( "sortstop", function( event, ui ) { return; } );
    $("#connected_courses, #potential_courses").sortable({
        connectWith: ".connectedSortable",
        stop: function( event, ui ) {
            var id = ui.item.attr("id"); //gets id of sorted item
            if (this.id == "potential_courses") {
                $("#"+id).removeClass("text-bg-warning").addClass("text-bg-success"); //changes class on sort
                connect_to_course(id, "add"); //calls function for ajax add to database
                } 
            if (this.id == "connected_courses") {
                $("#"+id).removeClass("text-bg-success").addClass("text-bg-warning");//changes class on sort
                connect_to_course(id, "remove");//calls function for ajax remove from database
            } 

            }
      }).disableSelection();

     tinymce.init({
            selector: "#description, #short_description",
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
            {title: 'Heading', block: 'h4'},
            {title: "Sub-heading", block: 'h5'}

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
        
}); // End Document Ready
net_id = '<?php echo $net_id; ?>';
learningExperienceId = <?php echo $learningExperienceId; ?>;
    function connect_to_course(id, action) {
        setLESaveStatus(action === "add" ? "Linking course..." : "Removing course link...", "info");
        $.ajax({
            type: "POST",
            url: "connect_to_course.php",
            data: {
                net_id: net_id,
                learningExperienceId: learningExperienceId,
                id: id,
                action: action
            }}).done(function(phpfile){
                setLESaveStatus(phpfile, "success");
            });
        
    }

    function save() {
      setLESaveStatus("Saving learning experience changes...", "info");
      
     
     name = $("#name").text();
     description = $("#description").html();
     short_description = $("#short_description").html();
     emphasis = $("#emphasis option:selected").text();
     $.ajax({
         method: "POST",
         url: "save-le.php",
         data: {
             learningExperienceId: learningExperienceId,
             net_id: net_id,
             name: name,
             description: description,
             short_description: short_description,
             emphasis: emphasis
             }
     }).done(function(phpfile) {
     setLESaveStatus(phpfile, "success");
     });
}

function deleteLe() {
    $.ajax({
        method: "post",
        url: "delete-le.php",
        data: {
            learningExperienceId: learningExperienceId,
        }
        }).done(function(phpfile) {
            setLESaveStatus(phpfile, "success");
            window.open("index.php");

        });
        
}

</script>
<style>
    .connectedSortable div {
        cursor: grabbing;
    }
    </style>
</head>
<body>
   <a class="skip-link" href="#main-content">Skip to editor content</a>
   <?php require_once dirname(__DIR__) . '/content/shared-shell.php'; curriculum_render_editor_header();
if ($message) { ?>
	<div class="container editor-access-state">
		<section class="editor-panel">
			<div class="editor-panel-body">
				<div class="alert alert-info" role="status"><?php echo $message; ?></div>
			</div>
		</section>
	</div>
<?php }
?>
<?php if ($auth && $access) { ?>
    <main id="main-content" class="container editor-main py-4">
        <section class="editor-hero">
            <p class="editor-eyebrow">Learning Experience Editor</p>
            <h1 class="h3 mb-2"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="mb-0">Edit the activity description, manage its emphasis, and connect it to the courses where it belongs.</p>
        </section>

        <section class="editor-topbar sticky-top mb-3" aria-label="Editor actions">
            <div class="d-flex flex-wrap gap-2">
                <a type="button" class="btn btn-outline-secondary" id="toPortfolio" href="../learning_experience.php?id=<?php echo $learningExperienceId;?>"><i class="bi bi-arrow-up-right-square"></i> Open Live Page</a>
                <a type="button" class="btn btn-outline-secondary" id="go_back" href="index.php"><i class="bi bi-grid-3x3-gap"></i> Editor Dashboard</a>
                <a type="button" class="btn btn-primary ms-auto" id="save"><i class="bi bi-save2"></i> Save Changes</a>
                <a type="button" class="btn btn-danger" id="delete"><i class="bi bi-trash"></i> Delete Learning Experience</a>
            </div>
        </section>

        <p class="editor-helper-note">This page saves automatically when you leave a field, and the course-linking area updates immediately when you drag an item across lists.</p>
        <div class="editor-save-dialog editor-status mb-3" id="save_dialog" aria-live="polite"></div>

        <section class="editor-panel mb-3">
            <div class="editor-panel-header editor-panel-header-course">
                <h2 class="h4 mb-0">LE &amp; A Editor: <?php echo $name; ?></h2>
            </div>
            <div class="editor-panel-body editor-form-grid">
            <div class="content">
                <label for="name" class="form-label">Learning Experience Name</label> 
                 <div id="name" class="form-control" contenteditable="true" aria-describedby="learningExperienceNameHelp"><?php echo $name; ?></div>
                 <div id="learningExperienceNameHelp" class="form-text mb-4">The name should be concise yet clear enough to identify the activity.</div>

                <label for="short_description" class="form-label">Short Description</label> 
                     <div id="short_description" class="form-control" contenteditable="true" aria-describedby="shortDescriptionHelp"><?php echo $short_description; ?></div>
                     <div id="shortDescriptionHelp" class="form-text mb-4">This is what is seen in the course list.</div>
                
                <label for="description" class="form-label">Description</label> 
                     <div id="description" class="form-control" contenteditable="true" aria-describedby="descriptionHelp"><?php echo $description; ?></div>
                     <div id="descriptionHelp" class="form-text mb-4">Describe the activity in as much detail as necessary.</div>
                
                <label for="emphasis" class="form-label">Skill Area Emphasis</label> 
                    
                    <select class= "form-control" id='emphasis' aria-describedby="emphasisHelp">
                    <option value='None'>None</option>
                    <option value='Grammar'>Grammar</option>
                    <option value='Listening'>Listening</option>
                    <option value='Speaking'>Speaking</option>
                    <option value='Reading'>Reading</option>
                    <option value='Writing'>Writing</option>
                    <option value='Pronunciation'>Pronunciation</option>
                    <option value='Vocabulary'>Vocabulary</option>
                    <option value='Listening and Reading'>Listening and Reading</option>
                    </select>
                    <div id="emphasisHelp" class="form-text mb-4">Which skill area does this learning experience primarily target?</div>
                
            </div>
            </div>
        </section>

        <section class="editor-panel mb-3">
            <div class="editor-panel-header editor-panel-header-course">
                <h2 class='h5 mb-0'>Courses</h2>
            </div>
            <div class="editor-panel-body">
                <p> Drag the courses from the Other courses list to connect the course with this learning experience. Drag courses from the Connected Courses list to disconnect them from the Learning Experience. </p>
                <div class='editor-sort-grid'>
                    <div class='editor-sort-column'>
                    <h3>Connected Courses</h3>
                    <div id="connected_courses" class='list-group bg-light connectedSortable border border-primary-subtle border-2'>
                
                <?php
                    $query = $elc_db->prepare("Select 
                    LE_courses.course_id,
                    Courses.course_name, 
                    Levels.level_id, 
                    Levels.level_short_name,
                    LE_courses.id 
                from LE_courses 
                natural left join 
                    Courses 
                natural left join 
                    Levels
                where LE_courses.learning_experience_id=?");
                    $query->bind_param("s", $learningExperienceId);
                    $query->execute();
                    $result = $query->get_result();
                    $courses = array();
                    while ($selectedCourse = $result->fetch_assoc()) {
                        $courseName = $selectedCourse['course_name'];
                        $levelShortName = $selectedCourse['level_short_name'];
                        $courseId = $selectedCourse['course_id'];
                        echo "<div class='m-1 connected_course list-group-item text-bg-success text-center rounded-2' id='$courseId'>$levelShortName $courseName</div>";
                        array_push($courses,$selectedCourse['course_id']);
                    }
                echo "</div></div><div class='editor-sort-column'><h3>Other Courses</h3><div id='potential_courses' class='list-group bg-light connectedSortable border border-primary-subtle border-2'>";
                
                    $query = $elc_db->prepare("Select 
                    Courses.course_name, 
                    Levels.level_id, 
                    Levels.level_short_name,
                    Courses.course_id,
                    Courses.level_id
                from Courses 
                inner join 
                    Levels on Levels.level_id=Courses.level_id
                ");
                    $query->execute();
                    $result = $query->get_result();
                    
                    while ($potentialCourse = $result->fetch_assoc()) {
                        $courseName = $potentialCourse['course_name'];
                        $levelShortName = $potentialCourse['level_short_name'];
                        $courseId = $potentialCourse['course_id'];
                        if (in_array($courseId, $courses)) {
                            
                        } else {
                        
                        echo "<div class='m-1 potential_course list-group-item text-bg-warning text-center rounded-2' id='$courseId'>$levelShortName $courseName</div>";
                        }
                    }

                ?>
               </div></div>  <!-- end potential courses list  -->
                </div>
            </div>
        </section>
    </main>
        <?php } ?>
    <?php curriculum_render_footer(array("path_prefix" => "..", "profile_path" => "editors/profile-editor.php", "include_bootstrap_bundle" => false)); ?>
</body>
</html>
