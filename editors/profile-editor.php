<?php

include_once("../../../connectFiles/connect_cis.php");
include_once("../auth.php");
include_once("admins.php");
require_once __DIR__ . '/page_helpers.php';
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
<script>
document.addEventListener("DOMContentLoaded", function () {
    var statusBox = document.getElementById("display_box");
    var teachingTable = document.getElementById("teaching");
    var addSemesterButton = document.getElementById("add_semester");
    var citationModal = document.getElementById("popup");
    var modalBody = citationModal ? citationModal.querySelector(".modal-body") : null;
    var modalFooter = citationModal ? citationModal.querySelector(".modal-footer") : null;
    var bootstrapModal = citationModal && window.bootstrap && typeof window.bootstrap.Modal === "function"
        ? new window.bootstrap.Modal(citationModal)
        : null;

    function showProfileMessage(message) {
        if (statusBox) {
            statusBox.innerHTML = message;
        }
    }

    function postForm(url, data) {
        return fetch(url, {
            method: "POST",
            body: data
        }).then(function (response) {
            return response.text();
        });
    }

    function showCitationModal() {
        if (bootstrapModal) {
            bootstrapModal.show();
            return;
        }

        if (citationModal) {
            citationModal.classList.add("show");
            citationModal.style.display = "block";
            citationModal.removeAttribute("aria-hidden");
            citationModal.setAttribute("aria-modal", "true");
            document.body.classList.add("modal-open");
        }
    }

    function hideCitationModal() {
        if (bootstrapModal) {
            bootstrapModal.hide();
            return;
        }

        if (citationModal) {
            citationModal.classList.remove("show");
            citationModal.style.display = "none";
            citationModal.setAttribute("aria-hidden", "true");
            citationModal.removeAttribute("aria-modal");
            document.body.classList.remove("modal-open");
        }
    }

    if (window.jQuery && window.jQuery.fn && window.jQuery.fn.dataTable) {
        window.jQuery("#citations").dataTable({
            aLengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, "All"]
            ],
        });
    }

    if (teachingTable) {
        teachingTable.addEventListener("focusout", function (event) {
            var cell = event.target.closest("[contenteditable='true']");
            if (!cell || !cell.id) {
                return;
            }

            var data = cell.id.split("-");
            var formData = new FormData();
            formData.append("stat_id", data[0]);
            formData.append("field", data[1]);
            formData.append("value", cell.textContent.trim());

            postForm("edit-stat.php", formData).then(showProfileMessage);
        });
    }

    if (addSemesterButton) {
        addSemesterButton.addEventListener("click", function () {
            postForm("add_semester.php", new FormData()).then(function (message) {
                showProfileMessage(message);
                window.location.reload();
            });
        });
    }

    window.openCitationPopup = function (dataURL) {
        if (!dataURL || !modalBody || !modalFooter) {
            return;
        }

        fetch("edit-popup.php?id=" + encodeURIComponent(dataURL))
            .then(function (response) {
                return response.text();
            })
            .then(function (html) {
                modalBody.innerHTML = html;
                modalFooter.innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" id="' +
                    dataURL + '" class="save btn btn-primary">Save changes</button>';
                var saveButton = modalFooter.querySelector(".save");
                if (saveButton) {
                    saveButton.addEventListener("click", function () {
                        save(this.id);
                    });
                }
                showCitationModal();
            });
    };

    document.addEventListener("click", function (event) {
        var openLink = event.target.closest(".openPopup");
        if (openLink) {
            event.preventDefault();
            window.openCitationPopup(openLink.getAttribute("data-href"));
            return;
        }

        if (event.target.closest("[data-bs-dismiss='modal']") || event.target.classList.contains("modal")) {
            hideCitationModal();
        }
    });
});

function save(id) {
    var citationNode = document.getElementById(id + "-citation");
    var typeNode = document.querySelector("#" + id + "-type option:checked");
    if (!citationNode || !typeNode) {
        return;
    }

    var citation = citationNode.innerHTML;
    var citationParts = citationNode.textContent;
    var parts = citationParts.split(").");
    var parts2 = parts[0].split("(");
    var year = parts2[1];
    var authors = parts2[0].replace(/&amp; |<p>/gi, "");

    citation = citation.replace(/<[\/]{0,1}(span)[^><]*>/ig, "");
    citation = citation.replace(/<[\/]{0,1}(p)[^><]*>/ig, "");
    citation = "<p>" + citation + "</p>";

    var formData = new FormData();
    formData.append("id", id);
    formData.append("citation", citation);
    formData.append("year", year);
    formData.append("authors", authors);
    formData.append("type", typeNode.textContent);

    fetch("edit-citation.php", {
        method: "POST",
        body: formData
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (message) {
            var saveDialog = document.getElementById(id + "-save_dialog");
            if (saveDialog) {
                saveDialog.innerHTML = message;
            }
        });
}

function deletePopup(id) {
    var idParts = id.split("-");
    if (!window.confirm("Do you want to delete this reference?")) {
        return;
    }

    var formData = new FormData();
    formData.append("id", idParts[1]);

    fetch("delete.php", {
        method: "POST",
        body: formData
    }).then(function () {
        window.location.reload();
    });
}
</script>
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to editor content</a>
    <?php require_once dirname(__DIR__) . "/content/shared-shell.php"; curriculum_render_editor_header(); ?>

    <?php if ($auth && $access) { ?>
    <main id="main-content" class="container editor-main py-4">
        <?php
        curriculum_render_editor_hero('Profile Editor', 'Lab School Profile Data', 'Maintain the teaching opportunity statistics and citation records that feed the public profile page.');
        curriculum_render_editor_actions('Editor actions', array(
            array('href' => '../profile.php', 'label' => 'View Live Page', 'icon' => 'bi bi-back', 'class' => 'btn btn-outline-secondary'),
            array('href' => 'index.php', 'label' => 'Editor Dashboard', 'icon' => 'bi bi-grid-3x3-gap', 'class' => 'btn btn-outline-secondary'),
        ));
        ?>
        <p class="editor-helper-note">Statistics save when a cell loses focus. Citation edits open in a modal editor and save when you confirm the changes.</p>
        <div class="editor-status" id="display_box" aria-live="polite"></div>

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
                <button type='button' class='btn btn-outline-primary btn-sm' id="add_semester"><i class="bi bi-plus"></i> Add Semester Row</button>
            </div>
            <div class="editor-panel-body">
                <div class="editor-table-shell">
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
            </div>
        </section>

        <section class="editor-panel mb-3">
            <div class="editor-panel-header editor-panel-header-course">
                <h2 class="h5 mb-0">Edit Citations</h2>
            </div>
            <div class="editor-panel-body">
                <div class="editor-table-shell">
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
                <td> <a href="javascript:void(0);" data-href="<?php echo $pubs['id']; ?>" onclick="openCitationPopup('<?php echo $pubs['id']; ?>'); return false;"
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
            </div>
        </section>
    </main>
    <?php } ?>
    <?php curriculum_render_footer(array("path_prefix" => "..", "profile_path" => "editors/profile-editor.php", "include_bootstrap_bundle" => false)); ?>


    <!-- <div id="faded-background"></div> -->
    <!-- <div id="popup" class="popup">
    <div id="popup-content">
    </div>
</div> -->
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
