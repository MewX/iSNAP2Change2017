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
        if ($update == -1) {
            // delete
            $commentID = $_POST['commentID'];
            deleteComment($conn, $commentID);
        }else if($update == 1){
            $commentID = $_POST['commentID'];
            // markCommentRead($conn, $commentID);
            $response = array();
            $response['status'] = 'success';
            $response['message'] = 'This was successful';
            echo json_encode($response);
            exit();
        }else if($update == 2){
            markAllCommentRead($conn);
        }
        $response = array();
        $response['status'] = 'success';
        $response['message'] = 'This was successful';
        echo json_encode($response);
        exit();
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    $comments = getAllComments($conn);
    $unreadComments = array();
    foreach ($comments as $key => $value){
        if($value->readOrNot == 0){
            $unreadComments[] = $value;
            unset($comments[$key]);
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
            <h1 class="page-header">Comments
                <button type="button" class="btn btn-default text-muted pull-right"
                        onclick = "markAllRead()">
                    Mark All Read
                </button>
            </h1>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php foreach($unreadComments as $value){?>
        <div class="panel <?php echo ($value->readOrNot==0)?"panel-info" : "panel-default"?>" id = "<?php echo $value->id ?>">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $value->name ?>
                    <span class="pull-right text-muted">
                        <em><?php echo $value->time ?></em>
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $value->content ?>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                onclick = "reply(this)" email = "<?php echo $value->email ?>">
                    Reply to <?php echo $value->email ?>
                </button>
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "deleteComment(this)" commentID = "<?php echo $value->id ?>">
                    Delete
                </button>
            </div>
        </div>
    <?php } ?>
    <?php foreach($comments as $value){?>
        <div class="panel <?php echo ($value->readOrNot==0)?"panel-info" : "panel-default"?>" id = "<?php echo $value->id ?>">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $value->name ?>
                    <span class="pull-right text-muted">
                        <em><?php echo $value->time ?></em>
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $value->content ?>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "reply(this)" email = "<?php echo $value->email ?>">
                    Reply to <?php echo $value->email ?>
                </button>
                <button type="button" class="btn btn-default text-muted" aria-label="Right Align"
                        onclick = "deleteComment(this)" commentID = "<?php echo $value->id ?>">
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
        commentID = $(value).attr("commentID");
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "comments.php",
            data: {
                commentID: commentID,
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
            url: "comments.php",
            data: {
                update: 2
            }
        })
            .done(function(feedback) {
                location.reload();
            })
    }

    function reply(value){
        url = "mailto:" +  $(value).attr("email");
        window.location.href = url;
    }
</script>

