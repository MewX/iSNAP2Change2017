<?php
    require_once('./student-validation.php');
    require_once("../mysql-lib.php");
    require_once("../debug.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == "UPDATE" && isset($_POST['content'])) {
            // new message
            $content = $_POST['content'];
        } else if ($action == "DELETE" && isset($_POST['message_id'])) {
            // delete message
            $messageId = $_POST['message_id'];
        } else if ($action == "VIEW") {
            // mark as read
            // nothing to do
        } else {
            debug_log("Illegal state!");
            header("location:welcome.php");
            exit;
        }
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $feedback = array();
    $conn = null;

    try {
        $conn = db_connect();
        $conn->beginTransaction();

        if ($action == "UPDATE") {
            // new message to researcher
            addNewMessage($conn, $studentID, $content, true);
        } else if ($action == "DELETE") {
            // delete student message
            deleteMessagesByStu($conn, $messageId);
        } else if ($action == "VIEW") {
            // mark a message as read from student
            markMessageAsReadForStu($conn, $studentID);
        }

        $conn->commit();
    } catch(Exception $e) {
        if ($conn != null) {
            $conn->rollBack();
            db_close($conn);
        }

        debug_err($e);
        $feedback["message"] = $e->getMessage();
        echo json_encode($feedback);
        exit;
    }

    db_close($conn);
    $feedback["message"] = "success";
    echo json_encode($feedback);
