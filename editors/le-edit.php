<?php
include_once("../../../connectFiles/connect_cis.php");

$learningExperienceId = $_GET['learningExperienceId'];
include_once("cas-go.php");
include_once("admins.php");
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
<html lang="">
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

    $("div").on("blur", function(){
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
    $( "#connected_courses" ).on( "sortstop", function( event, ui ) {console.log} );
    $("#connected_courses, #potential_courses").sortable({
        connectWith: ".connectedSortable",
        stop: function( event, ui ) {
            var id = ui.item.attr("id"); //gets id of sorted item
            console.log(id);
            console.log(this.id);
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
        $.ajax({
            type: "POST",
            url: "connect_to_course.php",
            data: {
                net_id: net_id,
                learningExperienceId: learningExperienceId,
                id: id,
                action: action
            }}).done(function(phpfile){
                $("#save_dialog").html(phpfile);
            });
        
    }

    function save() {
      
     
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
     $("#save_dialog").html(phpfile);
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
            $("#save_dialog").html(phpfile);
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
   <?php require_once("../content/header-short.php"); 
if ($message) {
	echo "<div class='container-md pt-4'>";
	echo $message;
	echo "</div>";
}
?>
<?php if ($auth && $access) { ?>
    <div class="container-md sticky-top pt-5 mb-2">
		<div class="row justify-content-between">
			<div class="btn-group col-3" role="group">
			<a type="button" class="btn btn-primary" id="toPortfolio" href="../learning_experience.php?id=<?php echo $learningExperienceId;?>"><i class="bi bi-back"></i> Portfolio </a>
					<a type="button" class="btn btn-primary" id="go_back" href="index.php"><i class="bi bi-pencil"></i> Editor Menu</a>			</div>
			
			<div class="btn-group col-3" role="group">
				<a type="button" class="btn btn-primary" id="save"><i class="bi bi-server"></i> Save</a>
				<a type="button" class="btn btn-danger" id="delete"><i class="bi bi-trash"></i> Delete</a>

            </div>
		</div>
	</div>
    <div id="save_dialog"></div>
    </div>
<div class="container-md bg-light">
		<h2>LE &amp; A Editor: <?php echo $name; ?></h2>
 	 </div>
    
<div class='container-md pt-4'>
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
                <h2 class='editor-style'>Courses</h2>
                <p> Drag the courses from the Other courses list to connect the course with this learning experience. Drag courses from the Connected Courses list to disconnect them from the Learning Experience. </p>
                <div class='row justify-content-evenly'>
                <div class='col-3 p2 text-center'><h3>Connectected Courses</h3></div>
                <div class='col-3 p2 text-center'><h3>Other Courses</h3></div>
                </div>
                <div class='row justify-content-evenly'>
                    <div id="connected_courses" class='col-3 p-2 list-group bg-light connectedSortable border border-primary-subtle border-2'>
                
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
                echo "</div><div id='potential_courses' class='col-3 p-2 list-group bg-light connectedSortable border border-primary-subtle border-2'>";
                
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
               </div>  <!-- end potential courses list  -->
                
                </div>
</div>
            
   
<div class='container-md pt-4'>
        <?php } ?>
</body>
</html>