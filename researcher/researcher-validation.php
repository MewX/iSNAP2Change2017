<?php
session_start();

if (isset($_SESSION['researcherID']) && isset($_SESSION['researcherUsername'])) {
    $researcherID = $_SESSION['researcherID'];
    $researcherUsername = $_SESSION['researcherUsername'];
} else {
    header("location:index.php");
    exit;
}
?>
