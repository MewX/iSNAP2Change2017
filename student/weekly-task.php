<?php
    //check login status
    require_once('./student-validation.php');

    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "weekly-task";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["week"])) {
            $week = $_GET["week"];
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $conn = null;
    try{
        $conn = db_connect();

        //check whether the week is locked or not
        if ($week > getStudentWeek($conn, $studentID)) {
            echo '<script>alert("This is a locked week!")</script>';
            echo '<script>window.location="game-home.php"</script>';
            exit;
        }

        //get all quizzes by studentID and week
        $quizzesRes = getQuizzesStatusByWeek($conn, $studentID, $week, 0);
        $timer = getTimerByWeek($conn, $week)->Timer;
        echo "<script>console.log( 'Debug Objects: " . $timer . "' );</script>";

    } catch(Exception $e) {
        if($conn != null) {
            db_close($conn);
        }
        debug_err($e);
        exit;
    }

    db_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Weekly Task | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./js/snap.js"></script>
    <style>
        .week-detail {
            max-width: 1000px;
            margin: 0 auto 0 auto;
            padding-top: 3%;
        }

        .week-item {
            width: 154px;
            height: 154px;
            display: block;
            margin: 0 auto;
        }
        .week-link {
            display: block;
            width: 100%;
        }
        .slick-current .week-img {
            width: 120px;
            height: 120px;
        }
        .week-img {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            display: block;
            background-size: 100% 100%;
        }
        .week-text {
            display: block;
            text-align: center;
            font-size: 20px;
        }
        .week-1 .week-img {
            background-image: url("./img/one_icon.png");
        }
        .week-2 .week-img {
            background-image: url("./img/two_icon.png");
        }
        .week-3 .week-img {
            background-image: url("./img/three_icon.png");
        }
        .week-4 .week-img {
            background-image: url("./img/four_icon.png");
        }
        .week-5 .week-img {
            background-image: url("./img/five_icon.png");
        }
        .week-6 .week-img {
            background-image: url("./img/six_icon.png");
        }
        .week-7 .week-img {
            background-image: url("./img/seven_icon.png");
        }
        .week-8 .week-img {
            background-image: url("./img/eight_icon.png");
        }
        .week-9 .week-img {
            background-image: url("./img/nine_icon.png");
        }
        .week-10 .week-img {
            background-image: url("./img/ten_icon.png");
        }
        .week-11 .week-img {
            background-image: url("./img/11_icon.png");
        }
        .week-12 .week-img {
            background-image: url("./img/12_icon.png");
        }
        .week-13 .week-img {
            background-image: url("./img/13_icon.png");
        }
        .week-14 .week-img {
            background-image: url("./img/14_icon.png");
        }
        .week-15 .week-img {
            background-image: url("./img/15_icon.png");
        }
        .week-more .week-img {
            background-image: url("./img/extra_week_icon.png");
        }

        .game-nav {
            max-width: 1000px;
            margin: 20px auto 0;
            text-align: center;
            overflow: hidden;
        }
        .game-nav-item {
            width: 340px;
            margin: 20px auto;
            position: relative;
        }
        .game-nav-item-completed .game-nav-logo,
        .game-nav-item-completed .game-nav-title,
        .game-nav-item-completed .game-nav-divider,
        .game-nav-item-completed .game-nav-desc {
            opacity: 0.5;
        }
        .game-nav-item-completed .game-nav-status,
        .game-nav-item-completed .game-nav-feedback {
            display: block;
        }
        .game-nav-status {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            color: #fff;
            font-size: 70px;
            display: none;
        }
        .game-nav-feedback {
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            text-align: center;
            color: #fcee2d;
            font-size: 20px;
            display: none;
        }
        .game-nav-feedback-animate {
            animation: fadein 1s linear alternate infinite;
        }
        @keyframes fadein {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        .game-nav-logo {
            display: block;
            width: 128px;
            height: 128px;
            margin: 0 auto 0 auto;
            background-size: 100% 100%;
        }

        .game-multiple-choice-quiz {
            color: #f7751e;
        }
        .game-multiple-choice-quiz .game-nav-logo {
            background-image: url("./img/quiz_icon.png");
        }
        .game-short-answer-question {
            color: #00f8cd;
        }
        .game-short-answer-question .game-nav-logo {
            background-image: url("./img/short_answer_question_icon.png");
        }
        .game-poster {
            color: #f7751e;
        }
        .game-poster .game-nav-logo {
            background-image: url("./img/poster_icon.png");
        }
        .game-matching {
            color: #AF24D1;
        }
        .game-matching .game-nav-logo {
            background-image: url("./img/matching_icon.png");
        }
        .game-cost-calculator {
            color: #FCEE2D;
        }
        .game-cost-calculator .game-nav-logo {
            background-image: url("./img/calculator_icon.png");
        }
        .game-video {
            color: #AF24D1;
        }
        .game-video .game-nav-logo {
            background-image: url("./img/video_icon.png");
        }
        .game-nav-title {
            font-size: 24px;
        }
        .game-nav-divider {
            border-top: 2px solid;
        }
        .game-nav-desc {
            width: 340px;
            margin: 0 auto 0 auto;
            color: #fff;
        }

    </style>
</head>
<body>

<div class="page-wrapper">
    <? require("./top-nav-bar.php") ?>

    <div class="content-wrapper">
        <div class="week-detail">
<?php
    if ($week <= 15 && $week >= 1) { ?>
        <div class="week-item week-<? echo $week ?>">
            <a class="week-link">
                <span class="week-img"></span>
                <span class="week-text">Week <? echo $week ?></span>
            </a>
        </div>
<?  } else { ?>
        <div class="week-item week-more">
            <a class="week-link">
                <span class="week-img"></span>
                <span class="week-text">Extra Week</span>
            </a>
        </div>
<?  }?>

            <? require("./quiz-timer.php") ?>

            <div class="game-nav">
<?php
            for ($i=0; $i<count($quizzesRes); $i++) { ?>
                <div class="col-6">
<?php
                //list of question type
                switch ($quizzesRes[$i]['QuizType']) {
                    case "MCQ":
                        if (isset($quizzesRes[$i]['Status'])) {
                            try {
                                $conn = db_connect();
                                $quizID = $quizzesRes[$i]["QuizID"];
                                $attemptInfo = getMCQAttemptInfo($conn, $quizID, $studentID);
                            } catch (Exception $e) {
                                debug_err($e);
                            }
                            db_close($conn);
                            if (isset($attemptInfo) && $attemptInfo->Attempt >= 3) {?>
                            <a href="multiple-choice-question.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                                <div class="game-nav-item game-nav-item-completed game-multiple-choice-quiz" >
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Multiple Choice Question</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Multiple Choice Question on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                    <div class="game-nav-status">Completed</div>
                                </div>
                            </a>
<?php                       } else {?>
                                <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID'] ?>">
                                    <div class="game-nav-item game-multiple-choice-quiz">
                                        <div class="game-nav-logo"></div>
                                        <div class="game-nav-title">Multiple Choice Question</div>
                                        <div class="game-nav-divider"></div>
                                        <div class="game-nav-desc">Complete Multiple Choice Question on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                    </div>
                                </a>
<?php                       } ?>
<?php                   } else { ?>
                            <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID'] ?>">
                                <div class="game-nav-item game-multiple-choice-quiz">
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Multiple Choice Question</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Multiple Choice Question on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                </div>
                            </a>
<?php                   }
                        break;
                    case "SAQ":
                         if (isset($quizzesRes[$i]['Status'])) {
                            if ($quizzesRes[$i]['Status'] == "UNGRADED" || $quizzesRes[$i]['Status'] == "GRADED") { ?>
                            <a href="short-answer-question.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID'] ?>">
                                <div class="game-nav-item game-nav-item-completed game-short-answer-question">
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Short Answer Question</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Short Answer Question on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                    <div class="game-nav-status">Completed</div>
<?php                           if ($quizzesRes[$i]['Status'] == "GRADED") {
                                    if ($quizzesRes[$i]['Viewed'] == 0) { ?>
                                    <div class="game-nav-feedback game-nav-feedback-animate">Teacher's Feedback Available</div>
<?php                               } else { ?>
                                    <div class="game-nav-feedback">Feedback Viewed</div>
<?php                               }
                                } ?>
                                </div>
                            </a>
<?php                       }

                            if ($quizzesRes[$i]['Status'] == "UNSUBMITTED") { ?>
                            <a href="short-answer-question.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID'] ?>">
                                <div class="game-nav-item game-short-answer-question">
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Short Answer Question</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Short Answer Question on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                </div>
                            </a>
<?php                       }
                        } else { ?>
                            <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                                <div class="game-nav-item game-short-answer-question">
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Short Answer Question</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Short Answer Question on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                </div>
                            </a>
<?php                   }
                        break;
                case "Matching":
                    $matchingCategory = getMaxMatchingOptionNum($conn, $quizzesRes[$i]['QuizID']) > 1 ? 1 : 0;

                    if ($matchingCategory == 1) {
                        $matchingUrl = "many-to-one-matching.php?quiz_id=".$quizzesRes[$i]['QuizID'];
                    } else {
                        $matchingUrl = "one-to-one-matching.php?quiz_id=".$quizzesRes[$i]['QuizID'];
                    }

                    if (isset($quizzesRes[$i]['Status'])) { ?>
                        <a href="<?php echo $matchingUrl ?>">
                            <div class="game-nav-item game-nav-item-completed game-matching">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Matching</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Matching on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                <div class="game-nav-status">Completed</div>
                            </div>
                        </a>
<?php               } else { ?>
                        <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-matching">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Matching</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Matching on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                            </div>
                        </a>
<?php               }
                    break;
                    case "Poster":
                    if (isset($quizzesRes[$i]['Status'])) {
                        if ($quizzesRes[$i]['Status'] == "UNGRADED" || $quizzesRes[$i]['Status'] == "GRADED") { ?>
                            <a href="poster.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID'] ?>">
                                <div class="game-nav-item game-nav-item-completed game-poster">
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Poster</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Poster on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                    <div class="game-nav-status">Completed</div>

<?php                       if ($quizzesRes[$i]['Status'] == "GRADED") {
                                if ($quizzesRes[$i]['Viewed'] == 0) { ?>
                                    <div class="game-nav-feedback game-nav-feedback-animate">Teacher's Feedback Available</div>
<?php                           } else { ?>
                                    <div class="game-nav-feedback">Feedback Viewed</div>
<?php                           }
                              } ?>
                                </div>
                            </a>
<?php                   }
                        if ($quizzesRes[$i]['Status'] == "UNSUBMITTED") { ?>
                            <a href="poster.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID'] ?>">
                                <div class="game-nav-item game-poster">
                                    <div class="game-nav-logo"></div>
                                    <div class="game-nav-title">Poster</div>
                                    <div class="game-nav-divider"></div>
                                    <div class="game-nav-desc">Complete Poster on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                </div>
                            </a>
<?php                   }
                    } else { ?>
                        <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-poster">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Poster</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Poster on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                            </div>
                        </a>
<?php               }
                    break;
                case "Calculator":
                    if (isset($quizzesRes[$i]['Status'])) { ?>
                        <a href="cost-calculator.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-nav-item-completed game-cost-calculator">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Cost Calculator</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Cost Calculator on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                <div class="game-nav-status">Completed</div>
                            </div>
                        </a>
<?php               } else { ?>
                        <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-cost-calculator">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Cost Calculator</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Cost Calculator on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                            </div>
                        </a>
<?php               }
                    break;
                case "Video":
                    if (isset($quizzesRes[$i]['Status'])) {
                        if ($quizzesRes[$i]['Status'] == "UNGRADED" || $quizzesRes[$i]['Status'] == "GRADED") { ?>
                        <a href="video.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-nav-item-completed game-video">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Video</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Video on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                                <div class="game-nav-status">Completed</div>
<?php                       if ($quizzesRes[$i]['Status'] == "GRADED") {
                                if ($quizzesRes[$i]['Viewed'] == 0) { ?>
                                <div class="game-nav-feedback game-nav-feedback-animate">Teacher's Feedback Available</div>
<?php                           } else { ?>
                                <div class="game-nav-feedback">Feedback Viewed</div>
<?php                           }
                           } ?>
                            </div>
                        </a>
<?php               }

                        if ($quizzesRes[$i]['Status'] == "UNSUBMITTED") { ?>
                        <a href="video.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-video">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Video</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Video on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                            </div>
                        </a>
<?php                   }
                    } else { ?>
                        <a href="pre-task-material.php?quiz_id=<?php echo $quizzesRes[$i]['QuizID']?>">
                            <div class="game-nav-item game-video">
                                <div class="game-nav-logo"></div>
                                <div class="game-nav-title">Video</div>
                                <div class="game-nav-divider"></div>
                                <div class="game-nav-desc">Complete Video on <?php echo $quizzesRes[$i]['TopicName']?> to receive <?php echo $quizzesRes[$i]['Points']?> points.</div>
                            </div>
                        </a>
<?php               }
                    break;

                } ?>
                </div>
<?php       }    ?>

            </div>
        </div>
    </div>

    <? require("./left-nav-bar.php") ?>
    <? require("./footer-bar.php") ?>
</div>
</body>
</html>

