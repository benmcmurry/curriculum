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
                <p> Click on a course below to see a list of teachers who have taught it before. </p>
                <h2> Who has taught my course before? </h2>
                <p> Click on a course below to see a list of teachers who have taught it before. </p>
                <table class='whohas'></table>
                <h3 class='whohas'>Foundations_Prep - Vocabulary</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:emgigger@gmail.com'>Emily Gigger</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Nettgen/Barwick</td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td>Steele/Shimizu</td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations_Prep - All Skills</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td>Schramm/Kim</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kat.93.kitty@gmail.com'>Kathryn Mitchell</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:rlbriney@gmail.com'>Rachel Briney</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Smith/Kebeker</td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td>Marshall/Bessey</td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations Prep - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td>Briney/Mitchell</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lynnec213@gmail.com'>Lynne Crandall</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Brodie/Ferrin</td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td>Griggs/Trimble</td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations Prep - Writing</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:wschramm4649@gmail.com'>Wesley Schramm</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:soon6774@gmail.com'>Jeongsoon Kim</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Stephens/Crandell</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Coca/Perego</td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td>Zerbe/Walton</td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations A - Speaking Accuracy</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:chew.e@hotmail.com'>Elisabet Chew</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kcnettgen@gmail.com'>Krista Nettgen</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations A - Listening & Speaking Fluency</h3>
                <table class='whohas'>
                    <tr>
                        <td>Thu Hoang</td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenna.snyde@gmail.com '>Jenna Snyder</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kat.93.kitty@gmail.com'>Kathryn Mitchell</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:linvilleea@s.dcsdk12.org'>Elizabeth Robinson</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td>Robinson/Snyder</td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenna.snyde@gmail.com '>Jenna Snyder</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:melann9195@gmail.com'>Melissa Young</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judychinabyu@gmail.com '>Judy Ma</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations A - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:jenna.snyde@gmail.com '>Jenna Snyder</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaitlynvanwagoner@gmail.com'>Kaitlyn VanWagoner</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:melann9195@gmail.com'>Melissa Young</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mnoxon521@gmail.com'>Madeleine Burnett</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td>Burnett/Chan</td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jacoblhchan@gmail.com '>Jacob Chan</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Drake/Aaron</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations A - Writing & Grammar</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulacc02@gmail.com'>Paula Cabrera</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Eddington/Stephens</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations B - Speaking Accuracy</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:chew.e@hotmail.com'>Elisabet Chew</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td>Jeewoo Green</td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jexcassandra@gmail.com'>Cassandra Sanders</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>DeHoyos/Lynn</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>DeHoyos/Lynn</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:stevenjcarter@gmail.com'>Steven Carter</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations B - Listening & Speaking Fluency</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:larissagrahl@hotmail.com'>Larissa Grahl</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judyjames@mac.com'>Judy James</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaitlynvanwagoner@gmail.com'>Kaitlyn VanWagoner</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judychinabyu@gmail.com '>Judy Ma</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judychinabyu@gmail.com '>Judy Ma</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:melann9195@gmail.com'>Melissa Young</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations B - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:	corbinritchie315@gmail.com  '>Corbin Ritchie</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:katherine.nobmann@gmail.com'>Katherine Nobmann</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ksenia.kszv@gmail.com'>Ksenia Zhao</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jexcassandra@gmail.com'>Cassandra Sanders</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:suzannebrigman@gmail.com '>Suzanne Brigman</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations B - Writing & Grammar</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:	corbinritchie315@gmail.com  '>Corbin Ritchie</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:derek23wilcox@gmail.com'>Derek Wilcox</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulacc02@gmail.com'>Paula Cabrera</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenellecox@sbcglobal.net'>Jenelle Cox</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kat.93.kitty@gmail.com'>Kathryn Mitchell</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:rachelamessenger@gmail.com'>Rachel Messenger</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judychinabyu@gmail.com '>Judy Ma</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judychinabyu@gmail.com '>Judy Ma</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations C - Applied Grammar</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jjeuiyong@gmail.com '>Josh Jung</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:decker.laura04@gmail.com'>Laura Decker</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jexcassandra@gmail.com'>Cassandra Sanders</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Drake/Aaron</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Drake/Aaron</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:stevenjcarter@gmail.com'>Steven Carter</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:stevenjcarter@gmail.com'>Steven Carter</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations C - Listening & Speaking</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:paulacc02@gmail.com'>Paula Cabrera</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:larissagrahl@hotmail.com'>Larissa Grahl</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:gatesgwen@gmail.com'>Gwyneth Gates</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:baker.allison@outlook.com'>Allison Baker</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:baker.allison@outlook.com'>Allison Baker</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:elderbiesinger@gmail.com'>Brad Biesinger</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:dayna.lee@hotmail.com'>Dayna Cuenca</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jacob.newman@gmail.com'>Jacob Newman</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations C - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:	corbinritchie315@gmail.com  '>Corbin Ritchie</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jodimikpetersen@gmail.com '>Jodi Petersen</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:constantine.fesenko@gmail.com'>Konstiantyn Fesenko</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>DeHoyos/Lynn</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Foundations C - Writing</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:blackwell.logan@gmail.com'>Logan Blackwell</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenna.snyde@gmail.com '>Jenna Snyder</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kcnettgen@gmail.com'>Krista Nettgen</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kcnettgen@gmail.com'>Krista Nettgen</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kcnettgen@gmail.com'>Krista Nettgen</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:dayna.lee@hotmail.com'>Dayna Cuenca</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:constantine.fesenko@gmail.com'>Konstiantyn Fesenko</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nataliemarie_23@hotmail.com'>Natalie Cole</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:popis412@hotmail.com'>Sofia Carreno</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bilikinrain@gmail.com'>Michelle Morgan</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bilikinrain@gmail.com'>Michelle Morgan</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic A - Applied Grammar</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:paulacc02@gmail.com'>Paula Cabrera</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:blackwell.logan@gmail.com'>Logan Blackwell</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:katherine.nobmann@gmail.com'>Katherine Nobmann</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kcnettgen@gmail.com'>Krista Nettgen</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaitlynvanwagoner@gmail.com'>Kaitlyn VanWagoner</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ritali1127@hotmail.com'>Rui Li</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jacoblhchan@gmail.com '>Jacob Chan</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:katherine.nobmann@gmail.com'>Katherine Nobmann</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2016</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic A - Directed Studies</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:benmcmurry@byu.edu'>Benjamin McMurry</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic A - Listening & Speaking</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:judyjames@mac.com'>Judy James</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judyjames@mac.com'>Judy James</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenellecox@sbcglobal.net'>Jenelle Cox</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judyjames@mac.com'>Judy James</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kat.93.kitty@gmail.com'>Kathryn Mitchell</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:constantine.fesenko@gmail.com'>Konstiantyn Fesenko</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic A - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:yutingl@uw.edu'>Ruby Li</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:wschramm4649@gmail.com'>Wesley Schramm</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:wschramm4649@gmail.com'>Wesley Schramm</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:wschramm4649@gmail.com'>Wesley Schramm</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jaredbsell@gmail.com'>Jared Sell</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaitlynvanwagoner@gmail.com'>Kaitlyn VanWagoner</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Eddington/Stephens</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>Eddington/Stephens</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:popis412@hotmail.com'>Sofia Carreno</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:carrie_drake@byu.edu'>Carrie Drake</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic A - Writing</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:gatesgwen@gmail.com'>Gwyneth Gates</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulacc02@gmail.com'>Paula Cabrera</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulacc02@gmail.com'>Paula Cabrera</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:elderbiesinger@gmail.com'>Brad Biesinger</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenna.snyde@gmail.com '>Jenna Snyder</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:elderbiesinger@gmail.com'>Brad Biesinger</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alisonmcmurry@gmail.com '>Alison McMurry</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:athelia.graham@gmail.com'>Athelia Graham</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:price.court@gmail.com'>Courtney Bodily</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mtcl23@hotmail.com'>Mayte Company</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:popis412@hotmail.com'>Sofia Carreno</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic B - Applied Grammar</h3>
                <table class='whohas'>
                    <tr>
                        <td>Marina Peterson</td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:katherine.nobmann@gmail.com'>Katherine Nobmann</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:stacymabel@gmail.com'>Stacy Galvez</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaitlynvanwagoner@gmail.com'>Kaitlyn VanWagoner</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>David/Healy</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:rachelamessenger@gmail.com'>Rachel Messenger</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jacob.newman@gmail.com'>Jacob Newman</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:brooke.e.eddington@gmail.com'>Brooke Eddington</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic B - Listening & Speaking</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenellecox@sbcglobal.net'>Jenelle Cox</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:syringa.domingo@gmail.com '>Joanah Domingo</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:price.court@gmail.com'>Courtney Bodily</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:amsjohnso@gmail.com'>Amy Johnson</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:suzannebrigman@gmail.com '>Suzanne Brigman</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:constantine.fesenko@gmail.com'>Konstiantyn Fesenko</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic B - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td>Nathan Foutz</td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:gatesgwen@gmail.com'>Gwyneth Gates</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:juanbyuh@gmail.com'>Juan Escalante</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:suzannebrigman@gmail.com '>Suzanne Brigman</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:suzannebrigman@gmail.com '>Suzanne Brigman</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicole.bay@gmail.com'>Nicole Bay</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:popis412@hotmail.com'>Sofia Carreno</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>Academic B - Writing</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karleyd4@gmail.com'>Karley Dickenson</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:maria.summers@gmail.com'>Maria Summers</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alchugg@gmail.com'>Alisha Chugg</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:erinhernandez03@gmail.com '>Erin Hernandez</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:decker.laura04@gmail.com'>Laura Decker</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:theicecreamqueen@gmail.com'>Chirstin Stephens</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:constantine.fesenko@gmail.com'>Konstiantyn Fesenko</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:dayna.lee@hotmail.com'>Dayna Cuenca</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:dayna.lee@hotmail.com'>Dayna Cuenca</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bowens2012@yahoo.com'>Brian Owens</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nataliemarie_23@hotmail.com'>Natalie Cole</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:dayna.lee@hotmail.com'>Dayna Cuenca</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep - Linguistic Accuracy</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judyjames@mac.com'>Judy James</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lisarhoffman@gmail.com'>Lisa Hoffman</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:melann9195@gmail.com'>Melissa Young</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:andreairvingonzalez@gmail.com'>Andrea Gonzalez</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nataliemarie_23@hotmail.com'>Natalie Cole</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nataliemarie_23@hotmail.com'>Natalie Cole</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hatuhart@gmail.com'>Judson Hart</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hatuhart@gmail.com'>Judson Hart</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:judychinabyu@gmail.com '>Judy Ma</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:emgigger@gmail.com'>Emily Gigger</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:lovezreal@hotmail.com'>Paul Scholes</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep - Listening & Speaking</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:benmcmurry@byu.edu'>Benjamin McMurry</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:katherine.nobmann@gmail.com'>Katherine Nobmann</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kbdevenport@gmail.com'>Katie Blanco</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jenna.snyde@gmail.com '>Jenna Snyder</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:johnnyzea1@yahoo.com '>Johnny Zea</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kanepake@gmail.com  '>Corbin Rivera</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mar.e.garceau@gmail.com'>Mary Morton</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:athelia.graham@gmail.com'>Athelia Graham</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:athelia.graham@gmail.com'>Athelia Graham</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:constantine.fesenko@gmail.com'>Konstiantyn Fesenko</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:baker.allison@outlook.com'>Allison Baker</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:wschramm4649@gmail.com'>Wesley Schramm</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td>Aislin Davis</td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:	corbinritchie315@gmail.com  '>Corbin Ritchie</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:baker.allison@outlook.com'>Allison Baker</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:jexcassandra@gmail.com'>Cassandra Sanders</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:gatesgwen@gmail.com'>Gwyneth Gates</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:bradenchase@me.com'>Braden Chase</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaitlynvanwagoner@gmail.com'>Kaitlyn VanWagoner</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:marailleux@gmail.com'>Mariah Krauel</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:paulcave87@gmail.com '>Paul Cave</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>David/Healy</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td>David/Healy</td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:athelia.graham@gmail.com'>Athelia Graham</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:vadimlds@gmail.com'>Vadym Malyshkevych</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:irabaskova@gmail.com'>Irina Baskova</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep - Writing</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:bilikinrain@gmail.com'>Michelle Morgan</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Winter 2018</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alisonmcmurry@gmail.com '>Alison McMurry</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:ethan.michael.lynn@gmail.com'>Ethan Lynn</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:annebennion@gmail.com'>Anne Bennion</a></td>
                        <td>Fall 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:cnutt86@gmail.com'>Chris Nuttall</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:becca.aaron@gmail.com'>Rebecca Aaron</a></td>
                        <td>Summer 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:alisonmcmurry@gmail.com '>Alison McMurry</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hhealy@live.com'>Heidi Healy</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Winter 2017</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:candice.snow@byu.edu'>Candice Snow</a></td>
                        <td>Fall 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:mornie@byu.edu'>Mornie Merrill</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:emgigger@gmail.com'>Emily Gigger</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:emgigger@gmail.com'>Emily Gigger</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:emgigger@gmail.com'>Emily Gigger</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Fall 2015</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:emgigger@gmail.com'>Emily Gigger</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep (before Fall 2016) - Linguistic Accuracy</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:nataliemarie_23@hotmail.com'>Natalie Cole</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:hatuhart@gmail.com'>Judson Hart</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:deborah_dehoyos@byu.edu'>Deborah DeHoyos</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep (before Fall 2016) - University Skills</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:karinamay.jackson@gmail.com'>Karina Jackson</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:price.court@gmail.com'>Courtney Bodily</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep (before Fall 2016) - Reading</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:decker.laura04@gmail.com'>Laura Decker</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:sarahlutz86@gmail.com'>Sarah Lutz</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>
                <h3 class='whohas'>University Prep (before Fall 2016) - Writing</h3>
                <table class='whohas'>
                    <tr>
                        <td><a href='mailto:kaylanymeyer@gmail.com '>Kayla Nymeyer</a></td>
                        <td>Summer 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Winter 2016</td>
                    </tr>
                    <tr>
                        <td><a href='mailto:nicholaselidavid@gmail.com'>Nicholas David</a></td>
                        <td>Fall 2015</td>
                    </tr>
                </table>

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