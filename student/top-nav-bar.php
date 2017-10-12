<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 10/11/2017
 * Time: 11:13 PM
 */
require_once('./student-validation.php');
require_once("../mysql-lib.php");

if (!isset($INEXAM)) {
    if (!isset($conn) || $conn == null)
        $conn = db_connect();

    // get quiz viewed attribute
    $quizViewedAttrs = getQuizViewdAttr($conn, $studentID);

    // get student question viewed attribute
    $studentQuesViewedAttrs = getAllUnreadMessagesForStu($conn, $studentID);
}

?>

<div class="header-wrapper">
    <div class="header">
        <a class="home-link" href="<? echo isset($INEXAM) ? '#' : 'welcome.php' ?>">SNAP²</a>

        <? if (!isset($INEXAM)) { ?>
        <ul class="nav-list">
            <li class="nav-item"><a class="nav-link" href="game-home.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="snap-facts.php">SNAP² Facts</a></li>
            <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        </ul>
        <? } ?>

        <div class="settings">
            <? if (!isset($INEXAM)) { ?>
            <div class="info-item info-notification">
                <a class="info-icon" href="#"></a>
                <?php
                $quizFeedbackCount = count($quizViewedAttrs);
                if ($quizFeedbackCount != 0) { ?>
                    <span class="info-number"><?php echo $quizFeedbackCount > 9 ? "9+" : $quizFeedbackCount; ?></span>
                <?php } ?>
                <ul class="info-message-list">
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
                </ul>
            </div>
            <div class="info-item info-message">
                <a class="info-icon" href="./messages.php"></a>
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

            <a class="setting-text"><?php echo $studentUsername ?></a>
        </div>
    </div>
</div>
