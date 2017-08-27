<?php
    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "multiple-choice-question-feedback";
    $MaxAttemptTime = 3;

    if ($_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST["student_id"]) && isset($_POST["quiz_id"]) && isset($_POST["answer_arr"])) {
            $studentID = $_POST["student_id"];
            $quizID = $_POST["quiz_id"];
            $answerArr = json_decode($_POST["answer_arr"], true);
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $conn = null;

    try {
        $conn = db_connect();

        $conn->beginTransaction();

        //Calculate Score
        $score = getMCQSubmissionCorrectNum($conn, $answerArr);
        $attemptInfo = getMCQAttemptInfo($conn, $quizID, $studentID);
        $attempt = 0;
        $highestGrade = 0;
        if($attemptInfo != null){
            $attempt = $attemptInfo->Attempt;
            $highestGrade = $attemptInfo->HighestGrade;
        }

        $feedback = array();
        $feedback["score"] = $score;
        $feedback["quesNum"] = count($answerArr);
        $feedback["detail"] = array();

        //if attempt no more than 3 times and the score is better than the highest one, update database.
        if ($score >= $highestGrade && $attempt < $MaxAttemptTime) {
        //if($score>$threshold){
            $feedback["result"] = "pass";

            foreach ($answerArr as $mcqID => $answer) {

                //update MCQ_Question_Record
                updateMCQQuestionRecord($conn, intval($mcqID), $studentID, $answer);

                $singleDetail = array();

                //get correct answer and options
                $mcqDetail = getOptions($conn, intval($mcqID));

                $singleDetail["MCQID"] = intval($mcqID);
                $singleDetail["correctAns"] = $mcqDetail[0]->CorrectChoice;
                $singleDetail["explanation"] = array();

                foreach($mcqDetail as $row){
                    $singleDetail["explanation"][$row->OptionID] = $row->Explanation;
                }

                array_push($feedback["detail"], $singleDetail);
            }

            //update quiz record
            $attempt += 1;
            updateQuizRecord($conn, $quizID, $studentID, "GRADED",$score);
            updateMCQAttemptRecord($conn, $quizID, $studentID, $attempt, $score);
            //update student score
            updateStudentScore($conn, $studentID);
            $feedback["attempt"] = $attempt;
            $conn->commit();
        } else {
            $attempt += 1;
            updateMCQAttemptRecord($conn, $quizID, $studentID, $attempt, $highestGrade);
            //if runout attempt times, give the feedback for the best attempt
            if($attempt>=3){
                $feedback["score"] = $highestGrade;
                $bestResult = getMCQQuestionRecord($conn, $quizID, $studentID);
                for($i=0; $i<count($bestResult); $i++){
                    $mcqID = $bestResult[$i]->MCQID;
                    $singleDetail = array();
                    //get correct answer and options
                    $mcqDetail = getOptions($conn, intval($mcqID));

                    $singleDetail["MCQID"] = intval($mcqID);
                    $singleDetail["correctAns"] = $mcqDetail[0]->CorrectChoice;
                    $singleDetail["explanation"] = array();

                    foreach($mcqDetail as $row){
                        $singleDetail["explanation"][$row->OptionID] = $row->Explanation;
                    }

                    array_push($feedback["detail"], $singleDetail);
                }
            }
            $feedback["attempt"] = $attempt;
            $feedback["result"] = "pass";
            $conn->commit();
        }
    } catch(Exception $e){
        if($conn != null) {
            $conn->rollBack();
            db_close($conn);
        }

        debug_err($pageName, $e);
        $feedback["message"] = $e->getMessage();
        echo json_encode($feedback);
        exit;
    }

    db_close($conn);
    $feedback["message"] = "success";
    echo json_encode($feedback);
?>
