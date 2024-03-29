<?php
    require_once('student-validation.php');
    require_once("../mysql-lib.php");
    require_once("../debug.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["quiz_id"])){
            $quizID = $_GET["quiz_id"];
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $conn = null;

    try {
        $conn = db_connect();

        $week = getWeekByQuiz($conn, $quizID);

        //check whether the week is locked or not
        if ($week > getStudentWeek($conn, $studentID)) {
            echo '<script>alert("This is a locked quiz!")</script>';
            echo '<script>window.location="game-home.php"</script>';
        }

        //check quiz status
        $status = getQuizStatus($conn, $quizID, $studentID);

        //check quiz extra attr
        if (getQuizExtraAttr($conn, $quizID) == 1) {
            $backPage = "extra-activities.php?week=".$week;
        } else {
            $backPage = "weekly-task.php?week=".$week;
        }

        //get matching questions
        $matchingQuestions = getMatchingBuckets($conn, $quizID);

        $matchingOptions = getMatchingOptions($conn, $quizID);
        
        $btnDisabled = "";

        if ($status == "UNANSWERED") {
            shuffle($matchingOptions);
        } else if ($status == "GRADED") {
            $btnDisabled = "disabled";
        }

    } catch(Exception $e) {
        if($conn != null) {
            db_close($conn);
        }
        exit;
    }

    db_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Matching | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/vendor/dragula.min.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <style>
        .match-container {
            max-width: 1000px;
            margin: 20px auto;
            text-align: center;
        }
        .match-intro {
            margin: 10px auto 20px;
            max-width: 400px;
        }
        .match-content {
            margin-bottom: 40px;
        }
        .word-item {
            color: #fcee2d;
            height: 100px;
            line-height: 100px;
            border-bottom: 2px solid;
        }
        .definition-item {
            border-radius: 10px;
            background-color: rgb(61, 61, 61);
            padding: 10px;
            height: 84px;
            margin-bottom: 20px;
            text-align: left;
            overflow: hidden;
            cursor: move;
        }
        .task-operation {
            right: 50px;
            top: 50px;
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
        <div class="match-container">
            <div class="match-header">
                <div class="match-title h2">Matching Activity</div>
                <div class="p1 match-intro"><?php echo $matchingQuestions[0]->Description ?></div>
            </div>

            <div class="match-content">
                <div class="mini-row">
                    <div class="col-6 word-list">
<?php       for ($i = 0; $i < count($matchingQuestions); $i++) { ?>
                        <div class="word-item h3" data-id="<?php echo $matchingQuestions[$i]->MatchingID ?>"><?php echo $matchingQuestions[$i]->Question ?></div>
<?php       } ?>
                    </div>
                    <div class="col-6 definition-list">
<?php       for ($j = 0; $j < count($matchingOptions); $j++) { ?>
                        <div class="definition-item p1" data-id="<?php echo $matchingOptions[$j]->OptionID ?>" draggable="true"><?php echo $matchingOptions[$j]->Content ?></div>
<?php       } ?>
                    </div>
                </div>
            </div>

            <form class="question-form">
                <button type="submit" class="question-submit" <?php echo $btnDisabled?>>
                    <span class="question-submit-icon"></span>
                </button>
            </form>

        </div>
        <? require("./quiz-timer.php") ?>
    </div>

    <? require("./quiz-button-sets.php") ?>
    <? require("./footer-bar.php") ?>
</div>

<script src="./js/vendor/dragula.min.js"></script>
<script>
<?php
        if ($status == "UNANSWERED") { ?>
            var drake = dragula([document.querySelector('.definition-list')]);
<?php    } ?>

    var FormCtrl = {
        init: function (opt) {
            this.opt = $.extend({
                onSubmit: $.noop
            }, opt);
            this.cacheElements();
            this.addListeners()
        },
        cacheElements: function () {
            this.$form = $('.question-form')
        },
        addListeners: function () {
            var that = this;
            this.$form.on('submit', function (e) {
                e.preventDefault();
                if(confirm("Do you want to submit this quiz?")){
                    that.opt.onSubmit(that.getData())
                }
            })
        },
        getData: function () {
            var $wordItems = $('.word-item');
            var $definitionItems = $('.definition-item');

            var data = {};
            $wordItems.each(function (index) {
                var answer = [];
                answer.push($definitionItems.eq(index).data('id'));
                data[this.getAttribute('data-id')] = answer
            });
            return data
        }
    };

    FormCtrl.init({
        onSubmit: function (data) {
            $.ajax({
                url: "matching-question-feedback.php",
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
        if (feedback.message != "success") {
            alert(feedback.message + ". Please try again!");
            return;
        }

        if (feedback.result == "pass") {
            snap.alert({
                content: 'Congratulations! You have completed this task.',
                onClose: function () {
                    drake.destroy();
                    $('.definition-item').removeClass('border-incorrect');
                    $('.question-submit').attr("disabled","disabled");
                }
            });

        } else if (feedback.result == "fail") {
            snap.alert({
                content: 'Sorry! Please try again.',
                onClose: function () {
                    setFeedback(feedback.detail)
                }
            })
        }
    }

    function setFeedback(details, feedbackCls) {
        $('.definition-item').removeClass('border-incorrect');

        feedbackCls = feedbackCls || 'border-incorrect';
        var errorItemSelector = details.map(function (id) {
            return '[data-id=' + id+ ']'
        }).join(',');
        $('.definition-list').find(errorItemSelector)
            .addClass(feedbackCls)
    }
</script>
</body>
</html>


