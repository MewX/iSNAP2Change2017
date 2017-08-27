<?php
/**
 * This file handles the requests for commenting.
 */

require_once("../mysql-lib.php");

$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["content"])) {
    if (strlen($_POST["name"]) == 0 || strlen($_POST["name"]) > 200) {
        $feedback["message"] = "Name was too long or empty!";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $feedback["message"] = "Email was not valid!";
    } else if (strlen($_POST["content"]) < 10) {
        $feedback["message"] = "Comment was too short!";
    } else if (!addComment($conn, $_POST["name"], $_POST["email"], $_POST["content"])) {
        $feedback["message"] = "Server side error!";
    } else {
        $feedback["message"] = "success";
    }
} else {
    $feedback["message"] = "Request invalid! " . json_encode($_POST);
}

echo json_encode($feedback);
