<?php
/**
 * This file handles the requests for commenting.
 */

require_once("../mysql-lib.php");

$NOJUMP = true;
require('student-validation.php');

/**
 * 1. Query history best scores:
 * JSON Object:
 * {
 * type: "history",
 * gameid: 1
 * }
 *
 * Return value would be an array:
 * {
 * message: "success", // "success" or "failed"
 * data: [{
 * level: 1,
 * score: 20
 * },
 * {
 * level: 5,
 * score: 10
 * }, ...]
 * }
 *
 *
 * 2. Submit new score for a certain level
 * {
 * type: "submit",
 * gameid: 1,
 * level: 5
 * }
 *
 * Response data would be;
 * {
 * message: "success", // "success" or "failed"
 * }
 *
 *
 * 3. Query ranking list for one level
 * (not providing the ranking list for total score because it can be queried from website)
 * {
 * }
 *
 * Response data should be:
 * {
 * message: "success", // "success" or "failed"
 * }
 */

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
