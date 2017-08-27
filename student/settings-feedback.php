<?php
/**
 * This file handles the requests for updating student profile.
 */

//check login status
require_once('./student-validation.php');

require_once("../mysql-lib.php");

$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["email"])
    && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["dob"]) && isset($_POST["gender"])
    && isset($_POST["identity"]) && isset($_POST["oldpass"]) && isset($_POST["newpass"])) {
    if (strtolower($studentUsername) != strtolower($_POST["name"])) {
        $feedback["message"] = "Session error, user name and id were not match";
    } else if (strlen($_POST["name"]) == 0 || strlen($_POST["name"]) > 200) {
        $feedback["message"] = "Name was too long or empty!";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $feedback["message"] = "Email was not valid!";
    } else if (strlen($_POST["newpass"]) > 0 && strlen($_POST["newpass"]) < 5) {
        $feedback["message"] = "New password was too short!";
    } else if (strlen($_POST["firstname"]) == 0 || strlen($_POST["firstname"]) > 200) {
        $feedback["message"] = "First name was too long or empty!";
    } else if (strlen($_POST["lastname"]) == 0 || strlen($_POST["lastname"]) > 200) {
        $feedback["message"] = "Last name was too long or empty!";
    } else if (strlen($_POST["dob"]) != 10) {
        $feedback["message"] = "Date of birth format wrong!";
    } else if (strlen($_POST["gender"]) != 4 && strlen($_POST["gender"]) != 6) {
        $feedback["message"] = "Gender was wrong!";
    } else if (strlen($_POST["identity"]) == 0 || strlen($_POST["identity"]) > 100) {
        $feedback["message"] = "Identity was wrong!";
    } else if (validStudent($conn, $_POST["name"], $_POST["oldpass"]) == null) {
        // old password was incorrect
        $feedback["message"] = "Old password was wrong!";
    } else if (!updateStudent($conn, $studentID, $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["gender"], $_POST["dob"], $_POST["identity"], $_POST["newpass"])) {
        // function updateStudent(PDO $conn, $id, $firstName, $lastName, $email, $gender, $dob, $identity, $password = null)
        $feedback["message"] = "Internal error.";
    } else {
        $feedback["message"] = "success";
    }
} else {
    $feedback["message"] = "Request invalid! " . json_encode($_POST);
}

echo json_encode($feedback);
