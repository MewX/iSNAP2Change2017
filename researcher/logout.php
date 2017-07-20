<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 7/17/2017
 * Time: 01:12 AM
 */

session_start();

// test is logged
if( isset($_SESSION['researcherID']) )
    unset($_SESSION['researcherID']);
if( isset($_SESSION['researcherUsername']) )
    unset($_SESSION['researcherUsername']);

// goto home page
header("Location: index.php"); // ==> ../index.php
exit;
