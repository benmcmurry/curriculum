<?php

include_once("../../../connectFiles/connect_cis.php");
include_once("../cas-go.php");
include_once("admins.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile Editor - Curriculum Portfolio</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="robots" content="" />
    <?php include("styles_and_scripts.html"); ?>

    <style>
    table#teaching {
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;

    }

    #teaching td {
        background-color: white;
        color: black;
        border: 1px solid;
        text-align: center;

    }

    </style>
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

    $("td").on("blur", function() {
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

    $("a#add_semester").on("click", function() {
        $.ajax({
            method: "POST",
            url: "add_semester.php",
        }).done(function(phpfile) {
            $("#display_box").html(phpfile);
        });
    });
    $('.openPopup').on('click', function() {
        var dataURL = $(this).attr('data-href');
        var fullLink = "edit-popup.php?id=" + dataURL;

        $('.modal-body').load(fullLink, function() {
            $('#popup').modal('show');
        });
        $('.modal-footer').html(
            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" id="' +
            dataURL + '" class="save btn btn-primary" onClick="save(this.id)">Save changes</button>'
            );
    });

});

function save(id) {

    console.log("saving");
    citation = $("#" + id + "-citation").html();
    citationParts = $("#" + id + "-citation").text();
    parts = citationParts.split(").");
    parts2 = parts[0].split("(");
    year = parts2[1];

    authors = parts2[0].replace(/&amp; |<p>/gi, "");
    citation = citation.replace(/<[\/]{0,1}(span)[^><]*>/ig, "");
    citation = citation.replace(/<[\/]{0,1}(p)[^><]*>/ig, "");
    citation = "<p>" + citation + "</p>";
    type = $("#" + id + "-type option:selected").text();
    console.log("ID: " + id + ", Year: " + year + ", Authors: " + authors + ", Type: " + type);



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
        $("#" + id + "-save_dialog").html(phpfile);
    });

}

function deletePopup(id) {

    id = id.split("-");

    var delete_citation = confirm("Do you want to delete this reference?");
    if (delete_citation == true) {
        $.ajax({
            method: "POST",
            url: "delete.php",
            data: {
                id: id[1],

            }
        }).done(function() {
            location.reload();
        });


    }
}
</script>
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to editor content</a>
    <?php require_once("../content/header-short.php"); ?>

    <?php if ($auth && $access) { ?>
    <main id="main-content" class="container-md editor-main py-4">
        <section class="editor-topbar sticky-top mb-3" aria-label="Editor actions">
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-secondary" href="../profile.php"><i class="bi bi-back"></i> Profile</a>
                <a class="btn btn-outline-secondary" href="index.php"><i class="bi bi-grid-3x3-gap"></i> Editor Menu</a>
            </div>
        </section>

        <section class="editor-panel mb-3">
            <div class="editor-panel-header editor-panel-header-level">
                <h2 class="h4 mb-0">Profile Editor</h2>
            </div>
            <div class="editor-panel-body">
                <p class="mb-0">Update profile statistics and citations used in the curriculum portfolio.</p>
            </div>
        </section>

        <section class="editor-panel mb-3">
            <div class="editor-panel-header editor-panel-header-course d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Edit Statistics</h2>
                <a type='button' class='btn btn-outline-primary btn-sm' id="add_semester"><i class="bi bi-plus"></i> Semester</a>
            </div>
            <div class="editor-panel-body">
                <div class="table-responsive">
        <table id='teaching' class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Year</th>
                    <th>Classes Taught</th>
                    <th>Supplemental Classes Taught</th>
                    <th>Classes taught by Students</th>
                    <th>Graduate Practicum Students</th>
                    <th>Undergraduate Practicum Students</th>
                    <th>Tutoring Hours</th>
                    <th>Class Observations</th>
                    <th>Graduate Internships</th>
                    <th>Undergraduate Internships</th>
                </tr>
            </thead>
            <?php
  $query_stats = $elc_db->prepare("Select * from Statistics order by year DESC, Semester DESC");
  $query_stats->execute();
  $result_stats = $query_stats->get_result();

	while($stats = $result_stats->fetch_assoc()){
		?>
            <tr>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-semester">
                    <?php echo substr($stats['semester'], 1);?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-year"><?php echo $stats['year'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-classes_taught">
                    <?php echo $stats['classes_taught'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-supplemental_classes_taught">
                    <?php echo $stats['supplemental_classes_taught'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-classes_taught_by_students">
                    <?php echo $stats['classes_taught_by_students'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-graduate_practicum_students">
                    <?php echo $stats['graduate_practicum_students'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-undergraduate_practicum_students">
                    <?php echo $stats['undergraduate_practicum_students'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-tutoring_hours">
                    <?php echo $stats['tutoring_hours'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-class_observations">
                    <?php echo $stats['class_observations'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-graduate_internships">
                    <?php echo $stats['graduate_internships'];?></td>
                <td contenteditable="true" id="<?php echo $stats['id'];?>-undergraduate_internships">
                    <?php echo $stats['undergraduate_internships'];?></td>
            </tr>
            <?php }
			$result_stats->free();

			?>
        </table>
                </div>
            </div>
        </section>

        <section class="editor-panel mb-3">
            <div class="editor-panel-header editor-panel-header-course">
                <h2 class="h5 mb-0">Edit Citations</h2>
            </div>
            <div class="editor-panel-body">
                <div class="table-responsive">
        <table id='citations' class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <td> Edit </td>
                    <td width="100px;"> Year </td>
                    <td> Type </td>
                    <td> Citation </td>
                    <td> Delete </td>

                </tr>
            </thead>

            <?php
		$query = $elc_db->prepare("Select * from Citations order by id DESC");
    $query->execute();
    $result = $query->get_result();
		
			while($pubs = $result->fetch_assoc()){

			?>
            <tr>
                <td> <a href="javascript:void(0);" data-href="<?php echo $pubs['id']; ?>"
                        class='btn btn-primary openPopup'><i class="bi bi-pencil"></i>Edit</a></td>
                <td> <?php echo $pubs['year']; ?></td>
                <td> <?php echo $pubs['type']; ?></td>
                <td> <?php echo $pubs['citation']; ?></td>
                <td> <a id='delete-<?php echo $pubs['id']; ?>'  class='btn btn-danger' onClick='deletePopup(this.id)'><i class="bi bi-trash"></i>Delete</a></td>

            </tr>
            <?php

		}

		$result->free();

?>
        </table>
                </div>
            </div>
        </section>
    </main>
    <?php } ?>
    <footer>
        <?php include("../content/footer.html"); ?>
    </footer>


    <!-- <div id="faded-background"></div> -->
    <!-- <div id="popup" class="popup">
    <div id="popup-content">
    </div>
</div> -->
    <div id="display_box"></div>
    <!-- Modal -->
    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Citation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</body>

</html>
