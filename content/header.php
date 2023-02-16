<?php
$newLevelMenuItem = "";
$coursesMenu = "";
$query = $elc_db->prepare("Select Levels.level_id, Levels.level_name, Levels.level_short_name from Levels where active=1 order by level_order ASC");
        $query->execute();
        $result = $query->get_result();

while ($levels = $result->fetch_assoc()) {
    $newLevelMenuItem = $newLevelMenuItem."<li><a class='dropdown-item' href='levels.php#".$levels['level_short_name']."'>".$levels['level_name']."</a></li>";
    $coursesMenu = $coursesMenu."<li><a class='dropdown-item' href='levels.php#".$levels['level_short_name']."'>".$levels['level_name']."</a> <ul class='dropdown-menu dropdown-submenu'>";
            
    $course_query = $elc_db->prepare("Select Courses.course_id, Courses.course_name, Courses.level_id, Courses.course_short_name from Courses where Courses.level_id = ? order by course_order ASC");
    $course_query->bind_param('s', $levels['level_id']);
    $course_query->execute();
    $course_result=$course_query->get_result();

    while ($courses = $course_result->fetch_assoc()) {
        $courses['course_name'] = str_replace('Fluency', '', $courses['course_name']);
        $coursesMenu = $coursesMenu."<li><a class='dropdown-item' href='course.php?course_id=".$courses['course_id']."'>".$courses['course_name']."</a></li>";
    }
    $coursesMenu = $coursesMenu."</li></ul>";
}

        
?>
<div id="header" class="container-fluid sticky-top">
    <div class="row justify-content-between p-3    " id="byu-bar">
        <div class="col-4"><a href="http://www.byu.edu"><img src="images/BYU-white.png" /></a></div>
        <div class="col-8" id="user">

            <svg width="1.5em" height="1.5em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                <path fill="currentcolor"
                    d="M50 95c-26 0-34-18-34-18 3-12 8-18 17-18 5 5 10 7 17 7s12-2 17-7c9 0 14 6 17 18 0 0-7 18-34 18z">
                </path>
                <circle cx="50" cy="50" r="45" fill="none" stroke="currentcolor" stroke-width="10"></circle>
                <circle fill="currentcolor" cx="50" cy="40" r="20"></circle>
            </svg>


            <?php echo $button;?>

        </div>
    </div>
    <nav class="w-100 navbar sticky-top navbar-expand-sm bg-white" data-bs-theme="light">
        <div class="container-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav justify-content-between w-100">


                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Our Curriculum</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="levels.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Level Descriptors
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            echo $newLevelMenuItem;
                            
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Courses</a>
                    
                    <ul class="dropdown-menu">
                    <?php
                    echo $coursesMenu;
                    ?>
                    </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile </a>
                    </li>
                    <?php
                        require_once"editors/admins.php";
                        if ($auth && $access) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="editors/index.php">Edit </a>
                    </li>
                    <?php
                        }
                        ?>

                </ul>

            </div>
        </div>
    </nav>
</div>
<div class="jumbotron" id="elc-bar">
    <div class="container-sm" data-bs-theme="dark">
        <?php
        
        echo "<h1>".$name."</h1>";
        ?>
    </div>
</div>
</div>