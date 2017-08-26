<?php
    require_once("../debug.php");

    session_start();

/**
 * If $NOJUMP is set, then the web page wil not jump if student is not logged in.
 */
    if (isset($_SESSION['studentID']) && isset($_SESSION['studentUsername'])) {
        $studentID = $_SESSION['studentID'];
        $studentUsername = $_SESSION['studentUsername'];
    } else if (isset($NOJUMP)) {
        // do nothing
    } else {
        debug_log("You have not logged in.");
        header("location:welcome.php");
        exit;
    }
