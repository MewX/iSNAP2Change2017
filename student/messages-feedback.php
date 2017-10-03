<?php
    require_once("../mysql-lib.php");
    require_once("../debug.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        $action = $_POST['action'];
        // TODO: write this
        // TODO: but lots of changes will be required
        if ($action == "UPDATE" && isset($_POST['student_id']) && isset($_POST['subject']) && isset($_POST['content'])) {
            $studentID = $_POST['student_id'];
            $subject = $_POST['subject'];
            $content = $_POST['content'];
        } else if ($action == "DELETE" && isset($_POST['question_id'])) {
            $questionID = $_POST['question_id'];
        } else if ($action == "VIEW" && isset($_POST['question_id'])) {
            $questionID = $_POST['question_id'];
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
            //update Student Question
            updateStudentQuestion($conn, $studentID, $subject, $content, $sendTime);
        }

        if ($action == "DELETE") {
            //delete Student Question
            deleteStudentQuestion($conn, $questionID);
            $feedback["questionID"] = $questionID;
        }

        if ($action == "VIEW") {
            updateStudentQuesViewedStatus($conn, $questionID);
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
?>