<?php
include_once("../../../connectFiles/connect_cis.php");

include_once("../cas-go.php");

if ($net_id == "blm39" || $net_id == "karimay") {
} else {
    echo "access denied";
}

$query = $elc_db->prepare("Select * from User_access order by id desc");
$query->execute();
$result = $query->get_result();

?>

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
        function updateName(id, full_name) {
            var fd = new FormData();
            fd.append('id', id);
            fd.append('full_name', full_name);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    document.querySelector("#update").innerHTML = xmlHttp.responseText;
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
                    document.querySelector("#update").innerHTML = xmlHttp.responseText;
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
                    document.querySelector("#update").innerHTML = xmlHttp.responseText;
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
                document.querySelector("#update").innerHTML = "Please complete all fields.";

            } else {
                console.log(full_name);
                console.log(net_id);
                console.log(access);
                fd.append('full_name', full_name);
                fd.append('net_id', net_id);
                fd.append('access', access);
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        document.querySelector("#update").innerHTML = xmlHttp.responseText;
                    }
                }
                xmlHttp.open("post", "phpScripts/addUser.php");
                xmlHttp.send(fd);
                location.reload();
            }
        }
        function removeUser(id) {
            var fd = new FormData();
            fd.append('id', id);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    document.querySelector("#update").innerHTML = xmlHttp.responseText;
                }
            }
            xmlHttp.open("post", "phpScripts/removeUser.php");
            xmlHttp.send(fd);
            location.reload();
        }
    </script>
    <style>
        table {
            width: 100%;
        }

        td,
        option {
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        input,
        select {
            width: 100%;
            line-height: 2em;

        }

        select {
            font-size: 1.7em;
        }

        .full_width {
            width: 100%
        }
    </style>

</head>

<body>
    <?php require_once("../content/header-short.php"); ?>
    

        <div id="title" class="container-fluid">
        Curriculum Editor - Access Table <br />
        <a class="btn btn-primary" id="go_back" href="https://elc.byu.edu/curriculum/">View the Curriculum Portfolio</a>
           


 
<div class="container-md pt-4">
        <div class="content">
            <table id="newUser">
               
            </table>


            <div id="update" style="height: 2em;"></div>
            <table id="users">
                <tr>
                    <th>Full Name</th>
                    <th>net_id</th>
                    <th>access</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="newName" id="newName" placeholder="Full Name">

                    </td>
                    <td>
                        <input type="text" name="newNetid" id="newNetid" placeholder="NetId">

                    </td>
                    <td>
                        <select name="newAccess" id="newAccess">
                            <option value='choose' disabled selected> Access Level</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                    <td> <a class="button full_width" id="addUser" onclick="addUser()">Add User</a>
                    </td>


                </tr>
                <tr>
                    <td colspan="4" style="height:.1em;background-color:gray;"></td>
                </tr>
                <?php
                while ($users = $result->fetch_assoc()) {
                    $teacherAccess = "";
                    $adminAccess = "";
                    $noaccess = "";
                    switch ($users['access']) {
                        case "teacher":
                            $teacherAccess = "selected";
                            break;
                        case "admin":
                            $adminAccess = "selected";
                            break;
                        case "no access":
                            $noaccess = "selected";
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
                                <option value="no access" <?php echo $noaccess; ?>>No Access</option>
                            </select>
                        </td>
                        <td>
                        <a class="button full_width" id="removeUser" onclick="removeUser(<?php echo $users['id']; ?>)">Remove User</a>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
                </div>
</body>