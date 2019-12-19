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
                $("#"+id).removeClass("potential_course").addClass("connected_course"); //changes class on sort
                connect_to_course(id, "add"); //calls function for ajax add to database
                } 
            if (this.id == "connected_courses") {
                $("#"+id).removeClass("connected_course").addClass("potential_course");//changes class on sort
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
</head>
<body>
    <header>
    <div id='holder'>
        <div>
    <h1> LE &amp; A Editor: <?php echo $name; ?></h1>
            <?php if ($auth && $access) { ?>
            <a class="button" id="go_back" href="index.php">Main Menu</a>
            <a class="button" id="save">Save</a>
            <a class="button" id="delete">Delete</a>
            <div id="save_dialog"></div>
            </div>
            <div id="user"><?php echo $net_id." | <a href='?logout='>Logout</a>"; ?></div>
            </div>
    </header>
    
    <article>

            <div class="content">
                <div class="separator">
                <h2 class='editor-style'>Learning Experience Name</h2> <div id="name" class="editable" contenteditable="true"><?php echo $name; ?></div>
                </div>
                <div class="separator">
                    <h2 class='editor-style'>Short Description</h2> <div id="short_description" class="editable" contenteditable="true"><?php echo $short_description; ?></div>
                </div>
                <div class="separator">
                    <h2 class='editor-style'>Description</h2> <div id="description" class="editable" contenteditable="true"><?php echo $description; ?></div>
                </div>
                <div class="separator">
                    <h2 class='editor-style'>Skill Area Emphasis</h2>
                    <select id='emphasis'>
                    <option value='None'>None</option>
                    <option value='Grammar'>Grammar</option>
                    <option value='Listening'>Listening</option>
                    <option value='Speaking'>Speaking</option>
                    <option value='Reading'>Reading</option>
                    <option value='Writing'>Writing</option>
                    <option value='Pronunciation'>Pronunciation</option>
                    <option value='Vocabulary'>Vocabulary</option>
                    </select>
                
                </div>
                <div class='separator'>
                <h2 class='editor-style'>Courses</h2>
                <ul id="connected_courses" class='connectedSortable'>
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
                        echo "<li class='connected_course' id='$courseId'>$levelShortName $courseName</li>";
                        array_push($courses,$selectedCourse['course_id']);
                    }
                echo "</ul><ul id='potential_courses' class='connectedSortable'>";
                
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
                        
                        echo "<li class='potential_course' id='$courseId'>$levelShortName $courseName</li>";
                        }
                    }

                ?>
               </ul>  <!-- end potential courses list  -->
                </div>
            
   
    </article>
    <?php } ?>
</body>
</html>