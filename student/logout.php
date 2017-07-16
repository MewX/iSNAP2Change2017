<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 7/17/2017
 * Time: 01:12 AM
 */

session_start();

// test is logged
if( isset($_SESSION['studentID']) )
    unset($_SESSION['studentID']);
if( isset($_SESSION['studentUsername']) )
    unset($_SESSION['studentUsername']);

// goto home page
header("Location: welcome.php"); // ==> ../index.php
exit;
