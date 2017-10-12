<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
require_once('researcher-validation.php');

function renderOneMessage($value)
{?>
    <div class="panel-body">
        <?php foreach ($value as $oneMessage) { ?>
    <?php if ($oneMessage->isFromStudent) { ?>
        <div class="talk-bubble round">
            <div class="talktext">
                <p><?php echo htmlspecialchars($oneMessage->content, ENT_QUOTES); ?></p>
            </div>
        </div>
    <?php } else { ?>
        <div class="talk-bubble round pull-right">
            <div class="talktext">
                <p><?php echo htmlspecialchars($oneMessage->content, ENT_QUOTES); ?></p>
            </div>
        </div>
    <?php } ?>
<?php } ?>
    </div>
    <div class="panel-footer">
        <textarea type="text" value="enter your message here"></textarea>
        <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                onclick = "reply(this)">
            Reply
        </button>
        <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                onclick = "markAsRead(this)">
            Mark as read
        </button>
    </div>
<?php } ?>

<?php function renderMessages($messagesForStu)
{
    foreach ($messagesForStu as $value) {
        ?>
        <div class="panel <?php echo ($value[0]->readOrNot == 0) ? "panel-info" : "panel-default" ?>"
             id="<?php echo $value[0]->id ?>"
             studentID="<?php echo $value[0]->StudentID ?>">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">
                    <a data-toggle="collapse" href="#collapse<?php echo $value[0]->StudentID ?>">
                        <?php
                        echo $value[0]->Username
                        ?>
                    </a>
                    <span class="text-muted">
                        <em><?php echo $value[count($value) - 1]->time ?></em>
                    </span>
                    <button type="button" class="btn btn-default text-muted pull-right"
                            onclick="deleteMessages(this)" studentID="<?php echo $value[0]->StudentID ?>">
                        X
                    </button>
                </h3>
            </div>
            <div id="collapse<?php echo $value[0]->StudentID ?>" class="panel-collapse collapse in">
                <?php  renderOneMessage($value) ?>
            </div>

        </div>
    <?php }
    }


    function buildMessages($conn){
        $messages = getAllMessages($conn);
        $messagesForStu = array();
        $unreadMessages = array();
        foreach ($messages as $key => $value) {
            if ($value->deleteByRes == 0) {
                $messagesForStu[$value->Username][] = $value;
                if ($value->readOrNot == 0 && $value->isFromStudent == 1) {
                    $messagesForStu[$value->Username][0]->readOrNot = 0;
                }
            }
        }
        foreach ($messagesForStu as $key => $value) {
            if ($value[0]->readOrNot == 0) {
                $unreadMessages[] = $value;
                unset($messagesForStu[$key]);
            }
        }
        $messagesForStu = array_merge($unreadMessages, $messagesForStu);
        return $messagesForStu;
    }

    try {
        $conn = db_connect();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $update = $_POST['update'];
            $response = array();
            if ($update == -1) {
                // delete
                $studentID = $_POST['studentID'];
                deleteMessagesByRes($conn, $studentID);
                $messagesForStu = array();
                $messagesForStu = buildMessages($conn);
                renderMessages($messagesForStu);
                exit();
            } else if ($update == 1) {
                $messageID = $_POST['messageID'];
                markMessageAsRead($conn, $messageID);
                $messagesForStu = array();
                $messagesForStu = buildMessages($conn);
                renderMessages($messagesForStu);
                exit();
            } else if ($update == 2) {
                markAllMessageRead($conn);
                $messagesForStu = array();
                $messagesForStu = buildMessages($conn);
                renderMessages($messagesForStu);
                exit();
            } else if ($update == 3) {
                $content = $_POST['content'];
                $studentID = $_POST['studentId'];
                if (addNewMessage($conn, $studentID, $content, 0)) {
                    markMessageAsReadForRes($conn, $studentID);
                    $messagesForStu = array();
                    $messagesForStu = getAllMessagesWithOneStu($conn, $studentID);
                    renderOneMessage($messagesForStu);
                    exit();
                } else {
                    $response['status'] = 'fail';
                    $response['message'] = 'Please try again';
                    echo json_encode($response);
                    exit();
                }
            } else if ($update == 4) {
                $studentID = $_POST['studentId'];
                if (markMessageAsReadForRes($conn, $studentID)) {
                    $messagesForStu = array();
                    $messagesForStu = buildMessages($conn);
                    renderMessages($messagesForStu);
                    //echo json_encode($response);
                    exit();
                } else {
                    $response['status'] = 'fail';
                    $response['message'] = 'Please try again';
                    echo json_encode($response);
                    exit();
                }
            }

        }
    } catch (Exception $e) {
        debug_err($e);
    }

    try {
        $messagesForStu = array();
        $messagesForStu = buildMessages($conn);
    } catch (Exception $e) {
        debug_err($e);
    }

    db_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<!-- Header Library -->
<?php require_once('header-lib.php'); ?>

<style>

    /* container */
    .container {
        padding: 5% 5%;
    }

    /* CSS talk bubble */
    .talk-bubble {
        margin: 10px;
        display: inline-block;
        position: relative;
        width: 51%;
        height: auto;
        background-color: lightgrey;
    }

    .round{
        border-radius: 30px;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;

    }

    /* talk bubble contents */
    .talktext{
        padding: 1em;
        text-align: left;
        line-height: 1.5em;
    }
    .talktext p{
        /* remove webkit p margins */
        -webkit-margin-before: 0em;
        -webkit-margin-after: 0em;
    }
</style>


<body>

<div id="wrapper">
    <!-- Navigation Layout-->
    <?php require_once('navigation.php'); ?>
</div>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Messages
                <button type="button" class="btn btn-default text-muted pull-right"
                        onclick = "markAllRead()">
                    Mark All Read
                </button>
            </h1>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div id = "messages">
        <?php renderMessages($messagesForStu)?>
    </div>


</body>
</html>

<script>
    function deleteMessages(value){
        studentID = $(value).attr("studentID");
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "messages.php",
            data: {
                studentID: studentID,
                update: -1
            }
        })
            .done(function(feedback) {
                $("#messages").html(feedback);
            })
    }

    function markAllRead(){
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "messages.php",
            data: {
                update: 2
            }
        })
            .done(function(feedback) {
                $("#messages").html(feedback);
            })
    }

    function markAsRead(value){
        studentID =  $(value).parent().parent().parent().attr('studentID');

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "messages.php",
            data: {
                update: 4,
                studentId: studentID
            }
        })
            .done(function(feedback) {
                $("#"+studentID).removeClass("panel-info").addClass("panel-default");
            })
            .fail(function(arg){
                console.log(arg);
                console.log("out");
            })
    }

    function reply(value){
        content = $(value).parent().children()[0].value;
        studentID =  $(value).parent().parent().parent().attr('studentID');

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "messages.php",
            data: {
                update: 3,
                content: content,
                studentId: studentID
            }
        })
            .done(function(feedback) {
                $("#collapse"+studentID).html(feedback);
                $("#"+studentID).removeClass("panel-info").addClass("panel-default");
            })
            .fail(function(arg){
                console.log(arg);
                console.log("out");
            })
    }
</script>

