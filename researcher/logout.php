<?php

session_start();

// test is logged
if( isset($_SESSION['researcherID']) )
    unset($_SESSION['researcherID']);
if( isset($_SESSION['researcherUsername']) )
    unset($_SESSION['researcherUsername']);

// goto home page
header("Location: index.php"); // ==> ../index.php
exit;
