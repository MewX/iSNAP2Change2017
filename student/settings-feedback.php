<?php
/**
 * This file handles the requests for updating student profile.
 */

//check login status
require_once('./student-validation.php');

require_once("../mysql-lib.php");

$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["oldpass"]) && isset($_POST["newpass"])) {
    if (strlen($_POST["name"]) == 0 || strlen($_POST["name"]) > 200) {
        $feedback["message"] = "Name was too long or empty!";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $feedback["message"] = "Email was not valid!";
    } else if (strlen($_POST["oldpass"]) < 5) {
        $feedback["message"] = "New password was too short!";
    } else if (validStudent($conn, $_POST["name"], $password) != null) {

        $validRes = validStudent($conn, $username, $password);

        if($validRes != null) {
            $feedback["result"] = "valid";
            $_SESSION["studentID"] = $validRes['StudentID'];
            $_SESSION["studentUsername"] = $validRes['Username'];
        } else {
            $feedback["result"] = "invalid";
        }


    } else if (!addComment($conn, $_POST["name"], $_POST["email"], $_POST["content"])) {
        $feedback["message"] = "Server side error!";
    } else {
        $feedback["message"] = "success";
    }
} else {
    $feedback["message"] = "Request invalid! " . json_encode($_POST);
}

echo json_encode($feedback);
