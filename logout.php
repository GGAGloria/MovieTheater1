<?php
    #set SESSION cookie to expire ==> delete cookie
    session_start();
    session_unset();
    session_destroy();
    print "<h2> Logging out </h2>";
    #Set redirection
    header("Refresh:3; url=index.html");
?>
