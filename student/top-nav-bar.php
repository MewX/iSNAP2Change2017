<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 10/11/2017
 * Time: 11:13 PM
 */
$NOJUMP = true;
require_once('./student-validation.php');
require_once("../mysql-lib.php");
require_once("../achievement-lib.php");

if (!isset($INEXAM)) {
    if (!isset($conn) || $conn == null)
        $conn = db_connect();

    // get quiz viewed attribute
    $quizViewedAttrs = getQuizViewdAttr($conn, $studentID);

    // get student question viewed attribute
    $studentQuesViewedAttrs = getAllUnreadMessagesForStu($conn, $studentID);

    // get student achievements notifications
    $allAch = achGetAllAchievementsByStudentId($conn, $studentID)[0];
    $newAchievements = array();
    if ($allAch->QuizMasterViewed != $allAch->QuizMaster) array_push($newAchievements, "QuizMaster");
    if ($allAch->AllSnapFactsViewed != $allAch->AllSnapFacts) array_push($newAchievements, "AllSnapFacts");
    if ($allAch->ResourcePageViewed != $allAch->ResourcePage) array_push($newAchievements, "ResourcePage");
    if ($allAch->QuizLeaderBoardTopTenOnceViewed != $allAch->QuizLeaderBoardTopTenOnce) array_push($newAchievements, "QuizLeaderBoardTopTenOnce");
    if ($allAch->LearningFromMistakesViewed != $allAch->LearningFromMistakes) array_push($newAchievements, "LearningFromMistakes");
    if ($allAch->HeadOfClassViewed != $allAch->HeadOfClass) array_push($newAchievements, "HeadOfClass");
    if ($allAch->WeeklyGeniusViewed != $allAch->WeeklyGenius) array_push($newAchievements, "WeeklyGenius");
    if ($allAch->GotItRightViewed != $allAch->GotItRight) array_push($newAchievements, "GotItRight");
    if ($allAch->AcedViewed != $allAch->Aced) array_push($newAchievements, "Aced");
    if ($allAch->HatTrickViewed != $allAch->HatTrick) array_push($newAchievements, "HatTrick");
    if ($allAch->MasterExtraContentViewed != $allAch->MasterExtraContent) array_push($newAchievements, "MasterExtraContent");
    if ($allAch->LoginMasterViewed != $allAch->LoginMaster) array_push($newAchievements, "LoginMaster");
    if ($allAch->LoginWeek1Viewed != $allAch->LoginWeek1) array_push($newAchievements, "LoginWeek1");
    if ($allAch->LoginWeek2Viewed != $allAch->LoginWeek2) array_push($newAchievements, "LoginWeek2");
    if ($allAch->LoginWeek3Viewed != $allAch->LoginWeek3) array_push($newAchievements, "LoginWeek3");
    if ($allAch->LoginWeek4Viewed != $allAch->LoginWeek4) array_push($newAchievements, "LoginWeek4");
    if ($allAch->LoginWeek5Viewed != $allAch->LoginWeek5) array_push($newAchievements, "LoginWeek5");
    if ($allAch->LoginWeek6Viewed != $allAch->LoginWeek6) array_push($newAchievements, "LoginWeek6");
    if ($allAch->LoginWeek7Viewed != $allAch->LoginWeek7) array_push($newAchievements, "LoginWeek7");
    if ($allAch->LoginWeek8Viewed != $allAch->LoginWeek8) array_push($newAchievements, "LoginWeek8");
    if ($allAch->LoginWeek9Viewed != $allAch->LoginWeek9) array_push($newAchievements, "LoginWeek9");
    if ($allAch->LoginWeek10Viewed != $allAch->LoginWeek10) array_push($newAchievements, "LoginWeek10");
    if ($allAch->MasterGamingViewed != $allAch->MasterGaming) array_push($newAchievements, "MasterGaming");
    if ($allAch->LaunchSportsNinjaViewed != $allAch->LaunchSportsNinja) array_push($newAchievements, "LaunchSportsNinja");
    if ($allAch->PlayEveryGameModeSnViewed != $allAch->PlayEveryGameModeSn) array_push($newAchievements, "PlayEveryGameModeSn");
    if ($allAch->BeatScoreSnAViewed != $allAch->BeatScoreSnA) array_push($newAchievements, "BeatScoreSnA");
    if ($allAch->BeatScoreSnBViewed != $allAch->BeatScoreSnB) array_push($newAchievements, "BeatScoreSnB");
    if ($allAch->BeatScoreSnCViewed != $allAch->BeatScoreSnC) array_push($newAchievements, "BeatScoreSnC");
    if ($allAch->LaunchMealCrusherViewed != $allAch->LaunchMealCrusher) array_push($newAchievements, "LaunchMealCrusher");
    if ($allAch->PlayEveryGameModeMcViewed != $allAch->PlayEveryGameModeMc) array_push($newAchievements, "PlayEveryGameModeMc");
    if ($allAch->BeatScoreMcAViewed != $allAch->BeatScoreMcA) array_push($newAchievements, "BeatScoreMcA");
    if ($allAch->BeatScoreMcBViewed != $allAch->BeatScoreMcB) array_push($newAchievements, "BeatScoreMcB");
    if ($allAch->BeatScoreMcCViewed != $allAch->BeatScoreMcC) array_push($newAchievements, "BeatScoreMcC");

}

?>

<div class="header-wrapper">
    <div class="header">
        <a class="home-link" href="<? echo isset($INEXAM) ? '#' : 'welcome.php' ?>">SNAP²</a>

        <? if (!isset($INEXAM)) { ?>
        <ul class="nav-list">
            <? if (isset($studentID)) { ?>
            <li class="nav-item"><a class="nav-link" href="game-home.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="competition.php">Competitions</a></li>
            <? } ?>
            <li class="nav-item"><a class="nav-link" href="snap-facts.php">SNAP² Facts</a></li>
            <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        </ul>
        <? } ?>

        <div class="settings">
            <? if (!isset($INEXAM) && isset($studentID)) { ?>
            <div class="info-item info-notification">
                <a class="info-icon" href="#" title="Marking notifications"></a>
                <?php
                $quizFeedbackCount = count($quizViewedAttrs) + count($newAchievements);
                if ($quizFeedbackCount != 0) { ?>
                    <span class="info-number"><?php echo $quizFeedbackCount > 9 ? "9+" : $quizFeedbackCount; ?></span>
                <?php } ?>
                <ul class="info-message-list">
                    <!-- Feedback notifications -->
                    <?php for ($i = 0; $i < count($quizViewedAttrs); $i++) {
                        if ($quizViewedAttrs[$i]["extraQuiz"] == 0) {
                            $url = "weekly-task.php?week=" . $quizViewedAttrs[$i]["week"];
                        } else {
                            $url = "extra-activities.php?week=" . $quizViewedAttrs[$i]["week"];
                        } ?>
                        <li class="info-message-item">
                            <a href="<?php echo $url ?>" style="color: white;">
                                <?php
                                $message = "A ";

                                switch ($quizViewedAttrs[$i]["quizType"]) {
                                    case "Video":
                                        $message = $message . "Video task";
                                        break;
                                    case "Image":
                                        $message = $message . "Image task";
                                        break;
                                    case "SAQ":
                                        $message = $message . "Short Answer Question task";
                                        break;
                                    case "Poster":
                                        $message = $message . "Poster task";
                                        break;
                                }

                                $message = $message . " in Week " . $quizViewedAttrs[$i]["week"] . " has feedback for you.";
                                echo $message;
                                ?>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- Achievement notifications -->
                    <?php for ($i = 0; $i < count($newAchievements); $i++) { ?>
                        <li class="info-message-item">
                            <a href="./achievements.php" style="color: white;">
                                 You've earned a new achievement - <? echo $newAchievements[$i] ?>!
                            </a>
                        </li>
                    <? } ?>

                </ul>
            </div>
            <div class="info-item info-message">
                <a class="info-icon" href="./messages.php" title="Click to view all messages."></a>
                <?php
                $messageCount = count($studentQuesViewedAttrs);
                if ($messageCount != 0) { ?>
                    <span class="info-number"><?php echo $messageCount > 9 ? "9+" : $messageCount; ?></span>
                <?php } ?>
            </div>

            <div class="setting-icon dropdown">
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a href="settings.php">Settings</a></li>
                    <li class="dropdown-item"><a href="logout.php">Log out</a></li>
                </ul>
            </div>
            <? } ?>

            <? if (isset($studentID)) { ?>
            <a class="setting-text" style="color: white"><?php echo $studentUsername ?></a>
            <? } else { ?>
            <a class="setting-text" style="color: white; cursor: pointer;" href="#" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-off"></i> LOGIN</a>
            <? } ?>
        </div>
    </div>
</div>

<? if (!isset($studentID)) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width:100%;">
        <div class="modal-dialog" role="document" style="height:450px;">
            <div class="modal-content" style="height:90%;">
                <div class="modal-body">
                    <button id="login-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white;"><span aria-hidden="true">&times;</span></button>
                    <div class="col-xs-6 col-xs-offset-3">
                        <img src="./img/Snap_Logo_Inverted.png" style="height:20%; width: 100%;">
                        <div style="text-align: center; margin-top: 15%">
                            <span id="login-fail-text" style="color:red"></span>
                        </div>
                        <div class="input-group input-group-lg" style="margin-top:5%; text-align: center;">
                            <input id="username" type="text"
                                   style="text-align: center; border-radius: 10px; color:white; border: none; background-color: black;"
                                   class="form-control" placeholder="Username" onfocus="this.placeholder=''"
                                   onblur="this.placeholder='Username'" aria-describedby="sizing-addon1"
                                   autocomplete="off">
                        </div>
                        <div class="input-group input-group-lg" style="margin-top:5%; text-align: center;">
                            <input id="password" type="password"
                                   style="text-align: center; border-radius: 10px; border: none; color:white; background-color: black;"
                                   class="form-control" placeholder="Password" onfocus="this.placeholder=''"
                                   onblur="this.placeholder='Password'" aria-describedby="sizing-addon1">
                        </div>
                        <button type="button" class="btn btn-primary btn-lg btn-block"
                                style="margin-top:5%; border-radius: 10px; border-color: #FCEE2D !important; color:#FCEE2D; background-color: black; opacity: 0.7;"
                                onclick="validStudent()">Log In
                        </button>
                        <div style="text-align: center; margin-top: 5%">
                            <span style="color: white;"> Don't have an account?</span>
                            <a href='#' onclick="location.href = 'valid-token.php';" style='color:#FCEE2D;'>Sign Up</a>
                        </div>

                        <script>
                            $(function () {
                                $('.modal-body').keypress(function (e) {
                                    if (e.which === 13) {
                                        validStudent();
                                    }
                                })
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script language="JavaScript">
        function validStudent() {
            var username = $('#username').val();
            var password = $('#password').val();

            $.ajax({
                url: "login.php",
                data: {
                    username: username,
                    password: password
                },
                type: "POST",
                dataType: "json"
            })
                .done(function (feedback) {
                    if (feedback.message !== "success") {
                        alert(feedback.message + ". Please try again!");
                        return;
                    }

                    if (feedback.result === "valid") {
                        location.href = 'game-home.php';
                    } else {
                        $('#login-fail-text').text("Invalid username and/or password!");
                        $('#password').val("");
                    }
                })
                .fail(function (xhr, status, errorThrown) {
                    alert("Sorry, there was a problem!");
                    console.log("Error: " + errorThrown);
                    console.log("Status: " + status);
                    console.dir(xhr);
                });
        }
    </script>
<? } ?>
