<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
require_once('researcher-validation.php');

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $update = $_POST['update'];
        $response = array();
        if ($update == -1) {
            // delete
            $messageID = $_POST['messageID'];
            deleteMessage($conn, $messageID);
            $response['status'] = 'success';
            $response['message'] = 'This was successful';
            echo json_encode($response);
            exit();
        }else if($update == 1){
            $messageID = $_POST['messageID'];
            markMessageAsRead($conn, $messageID);
            $response['status'] = 'success';
            $response['message'] = 'This was successful';
            echo json_encode($response);
            exit();
        }else if($update == 2){
            markAllMessageRead($conn);
            $response['status'] = 'success';
            $response['message'] = 'This was successful';
            echo json_encode($response);
            exit();
        }else if($update == 3){
            $content = $_POST['content'];
            $studentID = $_POST['studentId'];
            if(addNewMessage($conn, $studentID, "", $content, 0)){
                $response['status'] = 'success';
                $response['message'] = 'This was successful';
                echo json_encode($response);
                exit();
            }else{
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
    $messages = getAllMessages($conn);
    $unreadMessages = array();
    foreach ($messages as $key => $value){
        if($value->readOrNot == 0){
            $unreadMessages[] = $value;
            unset($messages[$key]);
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

db_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<!-- Header Library -->
<?php require_once('header-lib.php'); ?>

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
    <?php foreach($unreadMessages as $value){?>
        <div class="panel <?php echo ($value->readOrNot==0)?"panel-info" : "panel-default"?>"
             id = "<?php echo $value->id ?>"
             studentID = "<?php echo $value->StudentID ?>">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $value->Username ?>
                    <span class="pull-right text-muted">
                        <em><?php echo $value->time ?></em>
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $value->content ?>
            </div>
            <div class="panel-footer">
                <textarea type="text" value="enter your message here"></textarea>
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "reply(this)">
                    Reply
                </button>
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "deleteComment(this)" messageID = "<?php echo $value->id ?>">
                    Delete
                </button>
            </div>
        </div>
    <?php } ?>
    <?php foreach($messages as $value){?>
        <div class="panel <?php echo ($value->readOrNot==0)?"panel-info" : "panel-default"?>"
             id = "<?php echo $value->id ?>"
             studentID = "<?php echo $value->StudentID ?>">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $value->Username ?>
                    <span class="pull-right text-muted">
                        <em><?php echo $value->time ?></em>
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $value->content ?>
            </div>
            <div class="panel-footer">
                <textarea type="text" value="enter your message here"></textarea>
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "reply(this)">
                    Reply
                </button>
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "deleteComment(this)" messageID = "<?php echo $value->id ?>">
                    Delete
                </button>
            </div>
        </div>
    <?php } ?>
</div>

</body>
</html>

<script>
    function deleteComment(value){
        messageID = $(value).attr("messageID");
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "messages.php",
            data: {
                messageID: messageID,
                update: -1
            }
        })
            .done(function(feedback) {
                location.reload();
            })
    }

    function markAllRead(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "messages.php",
            data: {
                update: 2
            }
        })
            .done(function(feedback) {
                console.log(feedback.status);
                location.reload();
            })
    }

    function reply(value){
        content = $(value).parent().children()[0].value;
        studentID =  $(value).parent().parent().attr('studentID');
        console.log(studentID);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "messages.php",
            data: {
                update: 3,
                content: content,
                studentId: studentID
            }
        })
            .done(function(feedback) {
                location.reload();
            })
    }
</script>

