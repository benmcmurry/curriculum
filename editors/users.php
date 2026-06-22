<?php
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');

include_once("../auth.php");
require_once("admins.php"); 
require_once __DIR__ . '/page_helpers.php';

// if ($net_id == "blm39" || $net_id == "karimay") {
// } else {
//     echo "access denied";
// }

$query = $elc_db->prepare("Select * from User_access order by id desc");
$query->execute();
$result = $query->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Curriculum Editor - Access Table</title>

    <!-- 	Meta Information -->
    <meta charset="utf-8">
    <meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?php include("styles_and_scripts.html"); ?>
    <script>
        function showAccessMessage(message, tone) {
            var updateBox = document.querySelector("#update");
            updateBox.className = "editor-status";
            if (tone === "error") {
                updateBox.classList.add("alert", "alert-danger");
            } else {
                updateBox.classList.remove("alert-danger");
            }
            updateBox.innerHTML = message;
        }

        function updateName(id, full_name) {
            var fd = new FormData();
            fd.append('id', id);
            fd.append('full_name', full_name);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    showAccessMessage(xmlHttp.responseText, "success");
                }
            }
            xmlHttp.open("post", "phpScripts/updateName.php");
            xmlHttp.send(fd);
        }

        function updateNetid(id, net_id) {
            var fd = new FormData();
            fd.append('id', id);
            fd.append('net_id', net_id);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    showAccessMessage(xmlHttp.responseText, "success");
                }
            }
            xmlHttp.open("post", "phpScripts/updateNetid.php");
            xmlHttp.send(fd);
        }

        function updateAccess(id, access) {
            var fd = new FormData();
            fd.append('id', id);
            fd.append('access', access);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    showAccessMessage(xmlHttp.responseText, "success");
                }
            }
            xmlHttp.open("post", "phpScripts/updateAccess.php");
            xmlHttp.send(fd);
        }

        function addUser() {
            var fd = new FormData();
            full_name = document.querySelector("#newName").value;
            net_id = document.querySelector("#newNetid").value;
            access = document.querySelector("#newAccess").value;

            if (full_name == "" || net_id == "" || access == "choose") {
                showAccessMessage("Please complete all fields.", "error");

            } else {
                fd.append('full_name', full_name);
                fd.append('net_id', net_id);
                fd.append('access', access);
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        showAccessMessage(xmlHttp.responseText, "success");
                        location.reload();
                    }
                }
                xmlHttp.open("post", "phpScripts/addUser.php");
                xmlHttp.send(fd);
            }
        }
        function removeUser(id) {
            if (!window.confirm("Remove this user from the access table?")) {
                return;
            }
            var fd = new FormData();
            fd.append('id', id);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    showAccessMessage(xmlHttp.responseText, "success");
                    location.reload();
                }
            }
            xmlHttp.open("post", "phpScripts/removeUser.php");
            xmlHttp.send(fd);
        }
    </script>
    <style>
        td,
        option {
            text-align: center;
            vertical-align: middle;
        }
    </style>

</head>

<body>
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
    if ($auth && $access) { ?>
    <main id="main-content" class="container editor-main py-4">
        <?php
        curriculum_render_editor_hero('Administration', 'Access Table', 'Manage who can edit the curriculum and which contributors have teacher or admin access.');
        curriculum_render_editor_actions('Access actions', array(
            array('id' => 'toPortfolio', 'href' => '../index.php', 'label' => 'Back to Site', 'icon' => 'bi bi-arrow-return-left', 'class' => 'btn btn-outline-secondary'),
            array('id' => 'toEditor', 'href' => 'index.php', 'label' => 'Editor Dashboard', 'icon' => 'bi bi-pencil', 'class' => 'btn btn-outline-secondary'),
        ));
        ?>

        <p class="editor-helper-note">Changes save as soon as a name, netid, or access level field loses focus.</p>
        <div class="editor-status" id="update" aria-live="polite"></div>

        <section class="editor-panel mb-4">
            <div class="editor-panel-header editor-panel-header-course">
                <h2 class="h5 mb-0">User Access Management</h2>
            </div>
            <div class="editor-panel-body">
                <div class="editor-table-shell">
                    <div class="table-responsive">
            <table id="users" class="table align-middle">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>net_id</th>
                    <th>access</th>
                    <th>remove</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="newName" id="newName" placeholder="Full Name">

                    </td>
                    <td>
                        <input type="text" name="newNetid" id="newNetid" placeholder="NetId">

                    </td>
                    <td>
                        <select name="newAccess" id="newAccess">
                            <option value='choose' disabled> Access Level</option>
                            <option value="teacher" selected>Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success" id="addUser" onclick="addUser()">
                            <i class="bi bi-person-fill-add" aria-hidden="true"></i> Add
                        </button>
                    </td>


                </tr>
                <tr>
                    <td colspan="4" style="height:.1em;background-color:gray;"></td>
                </tr>
                <?php
                while ($users = $result->fetch_assoc()) {
                    $teacherAccess = "";
                    $adminAccess = "";
                  
                    switch ($users['access']) {
                        case "teacher":
                            $teacherAccess = "selected";
                            break;
                        case "admin":
                            $adminAccess = "selected";
                            break;
                        
                    }
                ?>
                    <tr>
                        <td>
                            <input type='text' onchange="updateName(<?php echo $users['id']; ?>, this.value)" value="<?php echo $users['full_name']; ?>">
                        </td>
                        <td><input type='text' onchange="updateNetid(<?php echo $users['id']; ?>, this.value)" value="<?php echo $users['net_id'] ?>"> </td>
                        <td>
                            <select id="access" name="access" onchange="updateAccess(<?php echo $users['id']; ?>, this.value)">
                                <option value="teacher" <?php echo $teacherAccess; ?>>Teacher</option>
                                <option value="admin" <?php echo $adminAccess; ?>>Admin</option>
                               
                            </select>
                        </td>
                        <td>
                        <button type="button" class="btn btn-danger" id="removeUser" onclick="removeUser(<?php echo $users['id']; ?>)"><i class='bi bi-person-fill-x'></i> Remove</button>
                        </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php } ?>
    <?php curriculum_render_footer(array("path_prefix" => "..", "profile_path" => "editors/profile-editor.php", "include_bootstrap_bundle" => false)); ?>
</body>
</html>
