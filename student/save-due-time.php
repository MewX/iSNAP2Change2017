<?php
    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "save-due-time";


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["student_id"]) && isset($_POST["week"])){
            $studentID = $_POST["student_id"];
            $week = $_POST["week"];
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $feedback = array();
    $conn = null;

    try {
        $conn = db_connect();
        createStuWeekRecord($conn, $studentID, $week);

        $dueTime = DateTime::createFromFormat('Y-m-d H:i:s', getStuWeekRecord($conn, $studentID, $week));
        $currentTime = new DateTime();
        $timeRemain = $dueTime->getTimestamp() - $currentTime->getTimestamp();
    } catch(Exception $e) {
        if($conn != null) {
            db_close($conn);
        }

        debug_err($e);
        $feedback["message"] = $e->getMessage();
        echo json_encode($feedback);
        exit;
    }
    db_close($conn);

    $feedback["message"] = "success";
    $feedback["time"] = $timeRemain;
    echo json_encode($feedback);
