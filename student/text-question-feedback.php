<?php
    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "text-question-feedback";

    if ($_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST['student_id']) && isset($_POST['quiz_id']) && isset($_POST['answer_arr']) && isset($_POST['status'])) {
            $studentID = $_POST['student_id'];
            $quizID = $_POST['quiz_id'];
            $answerArr = json_decode($_POST['answer_arr'], true);
            $status = $_POST['status'];
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

        //update SAQ_Question_Record
        foreach ($answerArr as $saqID => $answer) {
            updateSAQQuestionRecord($conn, intval($saqID), $studentID, $answer);
        }

        //update Quiz_Record
        updateQuizRecord($conn, $quizID, $studentID, $status);

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
    $feedback["status"] = $status;
    echo json_encode($feedback);
