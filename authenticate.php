<?php
if(!isset($_SESSION)){session_start();}
if(!isset($_SESSION['password']))
{
    //Destroy anything they have in their old session.
    session_destroy();
    //If they do not have an active session we redirect them to the login page
    echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=http://elc.byu.edu/curriculum/login.php'>";
    //Kill current page since the user needs to login first
    exit();
}
else{
}
?>