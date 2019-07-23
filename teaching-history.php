<?php
session_start();
    include_once("../../connectFiles/connect_cis.php");
    include_once("cas-go-r.php");
    include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="">

<head>
    <title>Curriculum Portfolio - English Language Center</title>

    <!-- 	Meta Information -->
    <meta charset="utf-8">
    <meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?php include_once("content/styles_and_scripts.html"); ?>
</head>

<body>
    <header>
        <?php include("content/header.php"); ?>
    </header>
    <nav>
        <?php include("content/nav-bar.php"); ?>
    </nav>
    <article>
        <div class='content-background'>
            <div class='content'>
                <h2> Who has taught my course before? </h2>
                <a href="https://docs.google.com/spreadsheets/d/138iErCbpoOxjGmPvZ0ycka9ABoSypjVw6qQbpHuas8w/edit?usp=sharing">Click here to see the spreadsheet.</a>
                
            </div>
        </div>
        <script type="text/javascript">
            $("h3.whohas").on("click", function () {
                // $("table.whohas").hide;
                $(this).next().toggle();
            });
        </script>
    </article>
    <footer>
        <?php include("content/footer.html"); ?>
    </footer>

</body>

</html>