<?php
	require_once('student-validation.php');
    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "multiple-choice-question";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["quiz_id"])){
        $quizID = $_GET["quiz_id"];
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["quiz_id"]) && isset($_POST["student_id"]) && isset($_POST["attempt"])){
        $quizID = $_POST["quiz_id"];
        $studentID = $_POST["student_id"];
        $attempt = $_POST["attempt"];
        try{
            $conn = db_connect();
            updateMCQAttempt($conn, $quizID, $studentID, 3);
        }catch(Exception $e) {
            if ($conn != null) {
                db_close($conn);
            }

            debug_err($pageName, $e);
            //to do: handle sql error
            //...
            exit;
        }
        db_close($conn);
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $conn = null;

    try{
        $conn = db_connect();

        $week = getWeekByQuiz($conn, $quizID);

        //check whether the week is locked or not
        if ($week > getStudentWeek($conn, $studentID)) {
            echo '<script>alert("This is a locked quiz!")</script>';
            echo '<script>window.location="game-home.php"</script>';
        }

        //check quiz status
        $status = getQuizStatus($conn, $quizID, $studentID);
        $attemptInfo = getMCQAttemptInfo($conn, $quizID, $studentID);
        //student can not attempt one quiz more than 3 times
        if($attemptInfo->Attempt<3){
            $status = 'UNANSWERED';
        }else{
            $status = 'GRADED';
        }

        //get learning material
        $materialRes = getLearningMaterial($conn, $quizID);

        //get mcq questions
        $mcqQuestions = getMCQQuestionsByQuizID($conn, $quizID, $studentID);
        $mcqOptions = array();
        $feedback = array();

        for ($i = 0; $i < count($mcqQuestions); $i++) {
            //get mcq options
            $options = getOptions($conn, $mcqQuestions[$i]->MCQID);

            array_push($mcqOptions, $options);

            //if graded
            if ($status == "GRADED") {
                $singleFeedback = array();

                foreach($options as $row) {
                    $feedbackDetails = array();
                    $feedbackDetails["correctAns"] = $mcqQuestions[$i]->CorrectChoice;
                    $feedbackDetails["Explanation"] = $row->Explanation;
                    $feedbackDetails["studentAns"] = $mcqQuestions[$i]->Choice;
                    array_push($singleFeedback, $feedbackDetails);
                }

                array_push($feedback, $singleFeedback);
            }
        }
    } catch(Exception $e) {
        if ($conn != null) {
            db_close($conn);
        }

        debug_err($pageName, $e);
        exit;
    }

    db_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Multiple Chocie Question | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <style>
        .task-operation {
            right: 350px;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <?php
    $INEXAM = true;
    require("./top-nav-bar.php");
    ?>

    <div class="content-wrapper">
        <ul class="quiz-nav-list">
<?php
        for ($i = 0; $i < count($mcqQuestions); $i++) { ?>
            <li class="quiz-nav-item">
                <span class="quiz-nav-label"></span>
                <span class="
                <?php
                if($status == "GRADED"){
                    if($mcqQuestions[$i]->Choice == $mcqQuestions[$i]->CorrectChoice){
                        echo "quiz-nav-state quiz-nav-state-correct";
                    }else{
                        echo "quiz-nav-state quiz-nav-state-incorrect";
                    }
                }
                ?>"></span>
            </li>
<?php   } ?>
        </ul>

        <div class="quiz-list">
<?php   for ($i = 0; $i < count($mcqQuestions); $i++) {
            if ($i == 0) {
                $active = "quiz-item-active";
            } ?>
            <div class="quiz-item <?php echo $active ?>" data-id="<?php echo $mcqQuestions[$i]->MCQID ?>">
                <div class="h3 quiz-header">
                    <div class="quiz-label">
                        <span class="image-icon-speech"></span>
                    </div>
                    <div class="quiz-title"><?php echo 'Q'.($i+1).'. '.$mcqQuestions[$i]->Question ?></div>
                </div>
                <ul class="quiz-answer-list">
<?php       for ($j = 0; $j < count($mcqOptions[$i]); $j++) { ?>
                    <li class="quiz-answer-item
                    <?php
                        if($status == "GRADED" && $feedback[$i][$j]["correctAns"] == $feedback[$i][$j]["studentAns"]
                        && $feedback[$i][$j]["studentAns"] == $mcqOptions[$i][$j]->OptionID){
                            echo "quiz-answer-item-correct";
                        }else if($status == "GRADED" && $feedback[$i][$j]["correctAns"] != $feedback[$i][$j]["studentAns"]
                            && $feedback[$i][$j]["studentAns"] == $mcqOptions[$i][$j]->OptionID){
                            echo "quiz-answer-item-incorrect";
                        }
                    ?>" data-answer="<?php echo $mcqOptions[$i][$j]->OptionID ?>">
                        <div class="quiz-label">
                            <span class="image-icon-speech"></span>
                        </div>
                        <div class="quiz-answer-content">
                            <?php echo $mcqOptions[$i][$j]->Content ?>
<?php
                            if ($status == "GRADED") { ?>
                                <div class="quiz-feedback">
                                    <div class="quiz-feedback-title">
<?php
                                if ($feedback[$i][$j]["correctAns"] == $mcqOptions[$i][$j]->OptionID) { ?>
                                    This is correct:
<?php                           } else { ?>
                                    This is incorrect:
<?php                           }?>
                                    </div>
                                    <div class="quiz-feedback-content"><?php echo $feedback[$i][$j]["Explanation"] ?></div>
                                </div>
<?php                       } ?>
                        </div>
                    </li>
<?php       } ?>
                </ul>
                <div class="quiz-nav-container">
                    <span class="quiz-nav-prev quiz-nav"></span>
                    <span class="quiz-nav-next quiz-nav"></span>
                </div>

                <form class="question-form">

<?php
                if($status == "UNANSWERED"){ ?>
                    <button type="submit" class="question-submit">
                        <span class="question-submit-icon"></span>
                    </button>
<?php           }
                if($status == "GRADED"){ ?>
                    <button type="submit" class="question-submit" disabled="disabled">
                        <span class="question-submit-icon"></span>
                    </button>
<?php           } ?>

                </form>
            </div>
<?php   } ?>
        </div>

    </div>

    <ul class="task-operation">
        <li class="cancel-task">
            <a href="weekly-task.php?week=<?php echo $week?>" title="Cancel Task"></a>
        </li>
    </ul>

    <div class="attachment">
        <ul class="attachment-nav">
            <li class="attachment-nav-item">SNAP² <br>FACTS</li>
        </ul>
    </div>

    <? require("./footer-bar.php") ?>
</div>

<script src="./js/snap.js"></script>
<script>
    snap.initAttachmentCtrl();

    var quizNav = new snap.QuizNav();

    var QuizCtrl = {
        cls: {
            answerSelected: 'quiz-answer-item-selected'
        },
        init: function (opt) {
            this.opt = $.extend({
                onSubmit: $.noop
            }, opt);
            this.cacheElements();
            this.addListeners()
        },
        cacheElements: function () {
            this.$form = $('.question-form');
            this.$quizItems = $('.quiz-item')
        },
        addListeners: function () {
            var that = this;
            var $doc = $(document);
            this.$form.on('submit', function (e) {
                e.preventDefault();
                if(confirm("Do you want to submit this quiz?")){
                    that.opt.onSubmit(that.getData())
                }
            });
            $doc.on('click', '.quiz-answer-item', function (e) {
                var $target = $(e.currentTarget)
                var isOriginalSelected = $target.hasClass(that.cls.answerSelected);
                var $quiz = $target.closest('.quiz-item');
                $quiz.find('.quiz-answer-item').removeClass(that.cls.answerSelected);
                if (!isOriginalSelected) {
                    $target.addClass(that.cls.answerSelected)
                }


                var index = that.$quizItems.index($quiz);

                if ($quiz.find('.quiz-answer-item-selected').length) {
                    quizNav.fillItem(index)
                } else {
                    quizNav.unfillItem(index)
                }
            })
        },
        getData: function () {
            var result = {};
            this.$quizItems.each(function () {
                var $quiz = $(this);
                var id = $quiz.data('id');
                var answer = $quiz.find('.quiz-answer-item-selected').data('answer');

                if (answer == undefined) {
                    result[id] = null;
                } else {
                    result[id] = $quiz.find('.quiz-answer-item-selected').data('answer');
                }
            });
            return result
        },
        setFeedback: function (data) {
            detail = data || [];
            var that = this;
            var $quizItems = this.$quizItems;
            var feedbackTpl =
                '         <div class="quiz-feedback">' +
                '             <div class="quiz-feedback-title">This is correct:</div>' +
                '             <div class="quiz-feedback-content">aaa</div>' +
                '         </div>'
                detail.forEach(function (quizState) {
                var $quizItem = $quizItems.filter('[data-id="' + quizState.MCQID +'"]');
                var $quizAnswers = $quizItem.find('.quiz-answer-item');
                var isCorrect = false;

                for (var key in quizState.explanation) {
                    var $answerItem = $quizAnswers.filter('[data-answer="' + key + '"]');
                    var answerId = $answerItem.data('answer');
                    var $feedback = $(feedbackTpl)

                    $feedback.find('.quiz-feedback-title')
                        .text(answerId == quizState.correctAns ? 'This is correct:' : 'This is incorrect')
                    $feedback.find('.quiz-feedback-content').text(quizState.explanation[key])
                    $answerItem.find('.quiz-answer-content')
                        .append($feedback)

                    if (answerId == quizState.correctAns) {
                        $answerItem.addClass('quiz-answer-item-correct')
                    }

                    if ($answerItem.hasClass('quiz-answer-item-selected')) {
                        if (answerId == quizState.correctAns) {
                            isCorrect = true
                        } else {
                            $answerItem.addClass('quiz-answer-item-incorrect')
                        }
                    }
                }

                quizNav.feedback($quizItems.index($quizItem), isCorrect)
            })
        }
    };

    QuizCtrl.init({
        onSubmit: function (data) {
            $.ajax({
                url: "multiple-choice-question-feedback.php",
                data: {
                    student_id: <?php echo $studentID?>,
                    quiz_id: <?php echo $quizID?>,
                    answer_arr: JSON.stringify(data)
                },
                type: "POST",
                dataType : "json"
            })

                .done(function(feedback) {
                    parseFeedback(feedback);
                })

                .fail(function( xhr, status, errorThrown ) {
                    alert( "Sorry, there was a problem!" );
                    console.log( "Error: " + errorThrown );
                    console.log( "Status: " + status );
                    console.dir( xhr );
                });
        }
    });



    function parseFeedback(feedback) {
        console.log(feedback.detail);
        if (feedback.message != "success") {
            alert(feedback.message + ". Please try again!");
            return;
        }

        if (feedback.result == "pass") {
            if(feedback.attempt>=3){
                snap.alert({
                    content: 'You have finished this quiz. Your final score is: ' + <?php echo $attemptInfo->HighestGrade?> + '/' + feedback.quesNum + '. '
                });
                $(".question-submit").attr("disabled",true);
                //QuizCtrl.setFeedback(feedback.detail);
                location.reload();
            }else{
                snap.alert({
                    content: 'This is your ' + feedback.attempt + ' attempt. The result for this attempt is: ' +
                    feedback.score + '/' + feedback.quesNum + '. '
                });
                snap.$alert.on('click', '.snap-alert-confirm', function () {
                    snap.confirm({
                        title: 'Finish this quiz?',
                        content:'You still have ' + (3-feedback.attempt) + ' chances for this quiz. Do you want to give up these ' +
                        'chances and finish this quiz? '
                    })
                    snap.$confirm.on('click', '.snap-alert-confirm', function () {
                        //give up the rest of chance, set attempt = 3;
                        var StudentID = <?php echo $studentID ?>;
                        var QuizID = <?php echo $quizID ?>;
                        var data = {
                            attempt: 3,
                            student_id: StudentID,
                            quiz_id: QuizID
                        }
                        $.ajax({
                            url:'multiple-choice-question.php',
                            type:'post',
                            datatype:'json',
                            data: data
                        })
                        $(".question-submit").attr("disabled",true);
                        //QuizCtrl.setFeedback(feedback.detail);
                        location.reload();
                    })
                    snap.$confirm.on('click', '.snap-alert-cancel', function () {
                        //redirect to week page if still have chance
                        document.location.href="weekly-task.php?week=<?php echo $week?>";
                    })

                })
            }
        } else if (feedback.result == "fail") {
            snap.alert({
                content: 'Sorry! You have failed this quiz. The result is: ' + feedback.score + '/' + feedback.quesNum + '.'
            })
        }
    }


</script>
</body>
</html>
