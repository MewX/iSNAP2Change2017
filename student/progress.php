<?php
    //check login status
    require_once('./student-validation.php');

    require_once("../mysql-lib.php");
    require_once("../debug.php");

    function convertIndicator($number)
    {
        $indicator = array('th','st','nd','rd','th','th','th','th','th','th');
        if (($number % 100) >= 11 && ($number % 100) <= 13)
            return "th";
        else
            return $indicator[$number % 10];
    }

    $conn = null;

    try{
        $conn = db_connect();

        //get student information
        $student = getStudent($conn, $studentID);

        //get student rank in class
        $classRank = getStudentRankByClass($conn, $studentID);
        $stuNumInClass = getStudentsNumByClass($conn, $studentID);
        $classRanIndicator = convertIndicator($classRank);
        $classGameRank = getStudentGameRankByClass($conn, $studentID);
        $classGameIndicator = convertIndicator($classGameRank);

        //get student rank in total
        $totalRank = getStudentRank($conn, $studentID);
        $gameRank = getStudentRankByGame($conn, $studentID);
        $totalStuNum = getStudentsNum($conn);
        $totalRankIndicator = convertIndicator($totalRank);
        $gameRankIndicator = convertIndicator($gameRank);

        //get students' rank
        $leaderboardRes = getStudentsRank($conn);
        $gameLeaderboardRes = getStudentGameRank($conn);

        //get
        $taskProgress = array();

        for ($i = 0; $i < 7; $i++) {
            $taskProgress[$i] = array();
            $taskProgress[$i]["compltdTaskNum"] = getQuizCompltdNumByTopic($conn, $studentID, $i+1);
            $taskProgress[$i]["totalTaskNum"] = getQuizNumByTopic($conn, $i+1);
            $taskProgress[$i]["totalTaskScore"] = calculateStudentScoreByTopic($conn, $studentID, $i+1);
        }

        //get student week
        $studentWeek = getStudentWeek($conn, $studentID);

        $activeWeek = $studentWeek;

        //get max week
        $maxWeek = getMaxWeek($conn)->WeekNum;

        //get material topics
        $activities = array();
        for($i = 0; $i < $studentWeek; $i++) {
            $tempMainActivities = getQuizzesStatusByWeek($conn, $studentID, ($i+1), 0);
            $tempExtraActivities = getQuizzesStatusByWeek($conn, $studentID, ($i+1), 1);
            array_push($activities, array_merge($tempMainActivities , $tempExtraActivities));
        }

    }catch(Exception $e) {
        if($conn != null) {
            db_close($conn);
        }

        debug_err($e);
        //to do: handle sql error
        //...
        exit;
    }

    db_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Progress | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/vendor/jquery.fullpage.min.css">
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>

    <style>
        .progress-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .progress-header {
            margin-top: 20px;
            margin-bottom: 40px;
            text-align: center;
        }
        .progress-icon {
            width: 128px;
            height: 128px;
            background-size: 100% 100%;
            margin: 0 auto 20px;
            background-image: url("./img/progress_icon.png");
        }
        .progress-title {
            margin-bottom: 5px;
        }
        .progress-user {
            max-width: 600px;
            margin: 0 auto 40px;
        }
        .progress-summary {
            text-align: center;
        }
        .progress-summary-item {
            margin-bottom: 20px;
        }

        .class-rank {
            text-align: center;
            margin-bottom: 40px;
        }
        .class-rank-number {
            color: #fcee2d;
        }
        .class-rank-number-label {
            font-size: 30px;
            position: relative;
            top: -17px;
        }

        .leaderboard {
            text-align: center;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;

        }
        td {
            padding: 5px;
        }
        thead {
            color: #fcee2d;
        }
        tbody tr {
            border-top: 2px solid #fcee2d;
        }
        .leaderboard-number-label {
            font-size: 12px;
            position: relative;
            top: -6px;
        }
        tbody tr:nth-child(-n + 4) .leaderboard-number {
            display: inline-block;
            width: 60px;
            height: 60px;
            background-size: 100% 100%;
            text-indent: -999em;
        }

        tbody tr:nth-child(1) .leaderboard-number {
            background-image: url("./img/first_place_icon.png");
        }
        tbody tr:nth-child(2) .leaderboard-number {
            background-image: url("./img/second_place_icon.png");
        }
        tbody tr:nth-child(3) .leaderboard-number {
            background-image: url("./img/third_place_icon.png");
        }
        tbody tr:nth-child(4) .leaderboard-number {
            background-image: url("./img/fourth_place_icon.png");
        }
        .progress-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .progress-category {
            float: left;
            width: 20%;
            padding: 10px;
            display: flex;
            justify-content: center;
        }
        .progress-detail {
            float: left;
            padding: 10px;
            width: 60%;
            text-align: center;
        }
        .progress-points {
            float: left;
            width: 20%;
            text-align: center;
            padding: 20px 10px 10px;
        }
        .progress-category-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-size: 100% 100%;
        }
        .progress-category-name {
            display: inline-block;
            height: 40px;
            line-height: 40px;
            margin-left: 10px;
        }
        .progress-bar-container {
            margin-top: 10px;
            position: relative;
            float: left;
            height: 20px;
            width: 80%;
            border-radius: 10px;
            background-color: #fff;
        }
        .progress-bar {
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 10px;
            height: 20px;
        }
        .progress-accurate {
            margin-top: 10px;
            float: left;
            width: 10%;
            text-align: center;
        }

        .activities-detail {
            padding-top: 20px;
        }
        .activities-header {
            text-align: center;
        }

        .activities-title {
            font-size: 28px;
        }

        .activities-tab {
            padding-top: 40px;
            padding-bottom: 30px;
            text-align: center;
        }
        .activities-tab-title {
            font-size: 14px;
            margin: 10px 0;
        }
        .activities-tab-item {
            width: 48px;
            height: 48px;
            line-height: 44px;
            margin: 0 10px;
            display: inline-block;
            border: 2px solid;
            border-radius: 50%;
            color:  #fcee2d;
            font-size: 32px;
            cursor: pointer;
        }

        .activities-tab-item-disabled {
            text-indent: -999em;
            border: 0;
            background-image: url("./img/locked_icon.png");
            cursor: not-allowed;
            background-size: 100% 100%;
        }

        .activities-tab-content {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            overflow: hidden;
        }

        .activities-week-detail {
            display: none;
        }
        .activities-week-detail-active {
            display: block;
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
            animation: fadein 2s ease-out infinite;
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
        <div id="fullpage">
            <div class="section active">
                <div class="progress-container">
                    <div class="progress-header">
                        <div class="progress-icon"></div>
                        <div class="progress-title h2">Progress</div>
                        <div class="progress-prompt p1">View your SNAP² progress</div>
                    </div>
                    <div class="progress-user">
                        <div class="mini-row">
                            <div class="h2" style="text-align: center;">Username: <?php echo $student->Username ?></div>
                        </div>
                    </div>
                    <div class="progress-summary">
                        <div class="progress-summary-item h2">Total Score: <?php echo $student->Score ?></div>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="progress-container">
                    <div class="activities-header">
                        <div class="activities-title">Quiz</div>
                        <br>
                    </div>
                    <div class="mini-row">
                        <div class="col-6">
                            <div class="class-rank">
                                <div class="h3 class-rank-title">Class Quiz Rank</div>
                                <div class="p1 class-rank-sub-title">Your are ranked</div>
                                <div class="h1 class-rank-number">
                                    <?php echo $classRank ?>
                                    <span class="class-rank-number-label"><?php echo $classRanIndicator ?></span>
                                </div>
                                <div class="p1 class-rank-summary">
                                    In your class out of <?php echo $stuNumInClass ?> students.
                                </div>
                            </div>
                            <div class="class-rank">
                                <div class="h3 class-rank-title">Overall Quiz Rank</div>
                                <div class="p1 class-rank-sub-title">Your are ranked</div>
                                <div class="h1 class-rank-number">
                                    <?php echo $totalRank ?>
                                    <span class="class-rank-number-label"><?php echo $totalRankIndicator ?></span>
                                </div>
                                <div class="p1 class-rank-summary">
                                    overall out of <?php echo $totalStuNum ?> students.
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="leaderboard">
                                <div class="h3 leaderboard-title">Quiz Leaderboard</div>
                                <table class="p1">
                                    <thead>
                                    <tr>
                                        <td>Rank</td>
                                        <td>Username</td>
                                        <td>Score</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                            <?php  for($i = 0; $i < count($leaderboardRes); $i++) { ?>
                                    <tr>
                                        <td>
                                            <span class="leaderboard-number">
                                                <?php echo $i+1 ?>
                                                <span class="leaderboard-number-label">th</span>
                                            </span>
                                        </td>
                                        <td><?php echo $leaderboardRes[$i]->Username ?></td>
                                        <td><?php echo $leaderboardRes[$i]->Score ?></td>
                                    </tr>
                            <?php   } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="progress-container">
                    <div class="activities-header">
                        <div class="activities-title">Game</div>
                        <br>
                    </div>
                    <div class="mini-row">
                        <div class="col-6">
                            <div class="class-rank">
                                <div class="h3 class-rank-title">Class Game Rank</div>
                                <div class="p1 class-rank-sub-title">Your are ranked</div>
                                <div class="h1 class-rank-number">
                                    <?php echo $classGameRank ?>
                                    <span class="class-rank-number-label"><?php echo $classGameIndicator ?></span>
                                </div>
                                <div class="p1 class-rank-summary">
                                    In your class out of <?php echo $stuNumInClass ?> students.
                                </div>
                            </div>
                            <div class="class-rank">
                                <div class="h3 class-rank-title">Overall Game Rank</div>
                                <div class="p1 class-rank-sub-title">Your are ranked</div>
                                <div class="h1 class-rank-number">
                                    <?php echo $gameRank ?>
                                    <span class="class-rank-number-label"><?php echo $gameRankIndicator ?></span>
                                </div>
                                <div class="p1 class-rank-summary">
                                    overall out of <?php echo $totalStuNum ?> students.
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="leaderboard">
                                <div class="h3 leaderboard-title">Game Leaderboard</div>
                                <table class="p1">
                                    <thead>
                                    <tr>
                                        <td>Rank</td>
                                        <td>Username</td>
                                        <td>Score</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  for($i = 0; $i < count($gameLeaderboardRes); $i++) { ?>
                                        <tr>
                                            <td>
                                            <span class="leaderboard-number">
                                                <?php echo $i+1 ?>
                                                <span class="leaderboard-number-label">th</span>
                                            </span>
                                            </td>
                                            <td><?php echo $gameLeaderboardRes[$i]->Username ?></td>
                                            <td><?php echo $gameLeaderboardRes[$i]->Score ?></td>
                                        </tr>
                                    <?php   } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="activities-detail">
                    <div class="activities-header">
                        <div class="activities-title">Weekly Tasks</div>
                    </div>
                    <div class="activities-tab">
                        <h2 class="activities-tab-title">Select Your week</h2>
                        <h3 class="activities-tab-title">(Note: it's a good practice to start a new activity from <a target="_self" href="game-home.php" style="text-decoration: underline;">home</a>,
                            some timing issues might triggered if you click on an time-limited activity here.)</h3>
                        <div class="activities-tab-list">
                        <?php
                            for($i = 0; $i < $studentWeek; $i++) { ?>
                                <div class="activities-tab-item"><?php echo ($i+1) ?></div>
                            <?php               }
                            for($i = $studentWeek; $i < $maxWeek; $i++) { ?>
                                <div class="activities-tab-item activities-tab-item-disabled"><?php echo ($i+1) ?></div>
                            <?php               } ?>
                        </div>
                    </div>
                    <div class="activities-tab-content">
                        <?php
                        // $studentWeek is the total week that a student can access
                        for ($i = 0; $i < $studentWeek; $i++) {
                        if ($i == ($studentWeek - 1)) { ?>
                        <div class="activities-week-detail activities-week-detail-active mini-row">
                            <?php } else { ?>
                            <div class="activities-week-detail mini-row">
                                <?php }

                                // $activities[$i] is the number of activities in week $j
                                for ($j = 0; $j < count($activities[$i]); $j++) { ?>
                                    <div class="col-6">
                                        <?php
                                        // list of question type, $activities[$i][$j] is the questions
                                        switch ($activities[$i][$j]['QuizType']) {
                                            case "MCQ":
                                                if (isset($activities[$i][$j]['Status'])) { ?>
                                                    <a href="game-home.php">
                                                        <div class="game-nav-item game-nav-item-completed game-multiple-choice-quiz" >
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Multiple Choice Question</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Multiple Choice Question on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                            <div class="game-nav-status">Completed</div>
                                                        </div>
                                                    </a>
                                                <?php               } else { ?>
                                                    <a href="pre-task-material.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-multiple-choice-quiz">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Multiple Choice Question</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Multiple Choice Question on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                        </div>
                                                    </a>
                                                <?php               }
                                                break;
                                            case "SAQ":
                                                if (isset($activities[$i][$j]['Status'])) {
                                                    if ($activities[$i][$j]['Status'] == "UNGRADED" || $activities[$i][$j]['Status'] == "GRADED") { ?>
                                                        <a href="game-home.php">
                                                            <div class="game-nav-item game-nav-item-completed game-short-answer-question">
                                                                <div class="game-nav-logo"></div>
                                                                <div class="game-nav-title">Short Answer Question</div>
                                                                <div class="game-nav-divider"></div>
                                                                <div class="game-nav-desc">Complete Short Answer Question on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                                <div class="game-nav-status">Completed</div>
                                                                <?php                           if ($activities[$i][$j]['Status'] == "GRADED") { ?>
                                                                    <div class="game-nav-feedback game-nav-feedback-animate">Teacher's Feedback Available</div>
                                                                <?php                           } ?>
                                                            </div>
                                                        </a>
                                                    <?php                   }

                                                    if ($activities[$i][$j]['Status'] == "UNSUBMITTED") { ?>
                                                        <a href="game-home.php">
                                                            <div class="game-nav-item game-short-answer-question">
                                                                <div class="game-nav-logo"></div>
                                                                <div class="game-nav-title">Short Answer Question</div>
                                                                <div class="game-nav-divider"></div>
                                                                <div class="game-nav-desc">Complete Short Answer Question on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                            </div>
                                                        </a>
                                                    <?php                       }
                                                } else { ?>
                                                    <a href="pre-task-material.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-short-answer-question">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Short Answer Question</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Short Answer Question on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                        </div>
                                                    </a>
                                                <?php               }
                                                break;
                                            case "Matching":
                                                if (isset($activities[$i][$j]['Status'])) { ?>
                                                    <a href="game-home.php">
                                                        <div class="game-nav-item game-nav-item-completed game-matching">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Matching</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Matching on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                            <div class="game-nav-status">Completed</div>
                                                        </div>
                                                    </a>
                                                <?php               } else { ?>
                                                    <a href="pre-task-material.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-matching">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Matching</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Matching on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                        </div>
                                                    </a>
                                                <?php               }
                                                break;
                                            case "Poster":
                                                if (isset($activities[$i][$j]['Status'])) {
                                                    if ($activities[$i][$j]['Status'] == "UNGRADED" || $activities[$i][$j]['Status'] == "GRADED") { ?>
                                                        <a href="poster.php?quiz_id=<?php echo $activities[$i][$j]['QuizID'] ?>">
                                                            <div class="game-nav-item game-nav-item-completed game-poster">
                                                                <div class="game-nav-logo"></div>
                                                                <div class="game-nav-title">Poster</div>
                                                                <div class="game-nav-divider"></div>
                                                                <div class="game-nav-desc">Complete Poster on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                                <div class="game-nav-status">Completed</div>
                                                            </div>
                                                        </a>
                                                    <?php                   }

                                                    if ($activities[$i][$j]['Status'] == "UNSUBMITTED") { ?>
                                                        <a href="poster.php?quiz_id=<?php echo $activities[$i][$j]['QuizID'] ?>">
                                                            <div class="game-nav-item game-poster">
                                                                <div class="game-nav-logo"></div>
                                                                <div class="game-nav-title">Poster</div>
                                                                <div class="game-nav-divider"></div>
                                                                <div class="game-nav-desc">Complete Poster on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                            </div>
                                                        </a>
                                                    <?php                   }
                                                } else { ?>
                                                    <a href="pre-task-material.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-poster">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Poster</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Poster on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                        </div>
                                                    </a>
                                                <?php               }
                                                break;
                                            case "Calculator":
                                                if (isset($activities[$i][$j]['Status'])) { ?>
                                                    <a href="cost-calculator.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-nav-item-completed game-cost-calculator">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Cost Calculator</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Cost Calculator on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                            <div class="game-nav-status">Completed</div>
                                                        </div>
                                                    </a>
                                                <?php               } else { ?>
                                                    <a href="pre-task-material.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-cost-calculator">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Cost Calculator</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Cost Calculator on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                        </div>
                                                    </a>
                                                <?php               }
                                                break;
                                            case "Video":
                                                if (isset($activities[$i][$j]['Status'])) {
                                                    if ($activities[$i][$j]['Status'] == "UNGRADED" || $activities[$i][$j]['Status'] == "GRADED") { ?>
                                                        <a href="video.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                            <div class="game-nav-item game-nav-item-completed game-video">
                                                                <div class="game-nav-logo"></div>
                                                                <div class="game-nav-title">Video</div>
                                                                <div class="game-nav-divider"></div>
                                                                <div class="game-nav-desc">Complete Video on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                                <div class="game-nav-status">Completed</div>
                                                                <?php                       if ($activities[$i][$j]['Status'] == "GRADED") {
                                                                    if ($activities[$i][$j]['Viewed'] == 0) { ?>
                                                                        <div class="game-nav-feedback game-nav-feedback-animate">Teacher's Feedback Available</div>
                                                                    <?php                           } else { ?>
                                                                        <div class="game-nav-feedback">Teacher's Feedback Available</div>
                                                                    <?php                           }
                                                                } ?>
                                                            </div>
                                                        </a>
                                                    <?php               }

                                                    if ($activities[$i][$j]['Status'] == "UNSUBMITTED") { ?>
                                                        <a href="video.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                            <div class="game-nav-item game-video">
                                                                <div class="game-nav-logo"></div>
                                                                <div class="game-nav-title">Video</div>
                                                                <div class="game-nav-divider"></div>
                                                                <div class="game-nav-desc">Complete Video on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                            </div>
                                                        </a>
                                                    <?php                   }
                                                } else { ?>
                                                    <a href="pre-task-material.php?quiz_id=<?php echo $activities[$i][$j]['QuizID']?>">
                                                        <div class="game-nav-item game-video">
                                                            <div class="game-nav-logo"></div>
                                                            <div class="game-nav-title">Video</div>
                                                            <div class="game-nav-divider"></div>
                                                            <div class="game-nav-desc">Complete Video on <?php echo $activities[$i][$j]['TopicName']?> to receive <?php echo $activities[$i][$j]['Points']?> points.</div>
                                                        </div>
                                                    </a>
                                                <?php               }
                                                break;

                                        } ?>
                                    </div>
                                <?php    } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? require("./left-nav-bar.php") ?>
    <? require("./footer-bar.php") ?>
</div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script src="./js/vendor/jquery.js"></script>
<script src="./js/vendor/jquery.fullpage.min.js"></script>
<script src="./js/snap.js"></script>
<script>
    $('#fullpage').fullpage({
        navigation: true
    });

    var TabCtrl = {
        cls: {
            tabActive: 'activities-tab-item-active',
            tabDisabled: 'activities-tab-item-disabled',
            tabContentActive: 'activities-week-detail-active'
        },
        init: function (opt) {
            opt = opt || {
                    onTabChange: $.noop
                };
            this.onTabChange = opt.onTabChange;
            this.cacheElements();
            this.addListeners();
        },
        cacheElements: function () {
            var $main = $('.activities-tab');
            this.$main = $main;
            this.$tabItems = $main.find('.activities-tab-item');
            this.$tabContent = $('.activities-tab-content');
            this.$tabContentItems = this.$tabContent.find('.activities-week-detail');
        },
        addListeners: function () {
            var that = this;

            this.$main.on('click', '.activities-tab-item', function (e) {
                var $target = $(e.currentTarget);
                var cls = that.cls;

                if (!$target.hasClass(cls.tabActive) && !$target.hasClass(cls.tabDisabled)) {
                    var index = that.$tabItems.index(e.currentTarget);
                    that.activeItem(index);
                    that.onTabChange(index);
                }
            })
        },
        activeItem: function (index) {
            this.$tabItems.removeClass(this.cls.tabActive)
                .eq(index)
                .addClass(this.cls.tabActive);
            this.$tabContentItems.removeClass(this.cls.tabContentActive)
                .eq(index)
                .addClass(this.cls.tabContentActive);
        }
    };

    TabCtrl.init({
        onTabChange: function (index) {
            MaterialCtrl.showNavPanel(index);
        }
    });

    TabCtrl.activeItem(<?php echo $activeWeek-1 ?>);

</script>
</body>
</html>

