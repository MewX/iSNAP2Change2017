<?php
//check login status
require_once('./student-validation.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Messages | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico"/>
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="./js/snap.js"></script>

    <style>
        .inbox-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .inbox-icon {
            width: 100px;
            height: 100px;
            background-size: 100% 100%;
            background-image: url("./img/text_to_speech_icon.png");
            margin: 0 auto 20px;
        }

        .mytext {
            border: 0;
            padding: 10px;
            background: whitesmoke;
            width: auto;
        }

        .text {
            width: 88%;
            display: flex;
            flex-direction: column;
        }

        /* for date time */
        .text > p:last-of-type {
            width: 100%;
            text-align: right;
            color: silver;
            margin-bottom: -7px;
            margin-top: auto;
        }

        .text-l {
            float: left;
            padding-right: 10px;
        }

        .text-r {
            float: right;
            padding-left: 10px;
        }

        .avatar {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 10%;
            float: left;
            padding-right: 10px;
        }

        .macro {
            margin-top: 5px;
            width: 90%;
            border-radius: 5px;
            padding: 5px;
            display: flex;
        }

        .msj-rta {
            float: right;
            background: whitesmoke;
        }

        .msj {
            float: left;
            background: white;
        }

        .frame {
            background: #e0e0de;
            height: auto;
            position: relative;
            overflow: hidden;
            padding: 0;
        }

        .frame > div:last-of-type {
            bottom: 5px;
            width: 100%;
            display: flex;
        }

        .msgframe {
            width: 100%;
            list-style-type: none;
            padding: 18px;
            bottom: 32px;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .msj:before {
            width: 0;
            height: 0;
            content: "";
            top: -5px;
            left: -14px;
            position: relative;
            border-style: solid;
            border-width: 0 13px 13px 0;
            border-color: transparent #ffffff transparent transparent;
        }

        input:focus {
            outline: none;
        }

        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            color: #d4d4d4;
        }

        ::-moz-placeholder { /* Firefox 19+ */
            color: #d4d4d4;
        }

        :-ms-input-placeholder { /* IE 10+ */
            color: #d4d4d4;
        }

        :-moz-placeholder { /* Firefox 18- */
            color: #d4d4d4;
        }

        .inbox-item span {
            float: left;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <? require('./top-nav-bar.php') ?>

    <!-- Real messages -->
    <!-- Codes from: https://bootsnipp.com/snippets/featured/simple-chat -->
    <div class="content-wrapper">
        <div class="inbox-header">
            <div class="inbox-icon"></div>
            <h2 class="h2 inbox-title" style="color: white">Messages</h2>
            <div class="p1 inbox-prompt" style="color: white">View messages and replies between you and researchers.</div>
        </div>
        <div class="col-4 col-sm-offset-4 frame" style="float: none">
            <ul id="msgall" class="msgframe"></ul>
            <div class="msgframe">
                <div class="msj-rta macro" style="margin:auto">
                    <div class="text text-r" style="background:whitesmoke !important">
                        <textarea class="scrollabletextbox mytext" name="note" placeholder="Input your message here" id="msgtext"></textarea>
                    </div>
                    <button type="button" class="btn btn-default" style="width: 100px" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>

    <? require("./left-nav-bar.php") ?>
    <? require("./footer-bar.php") ?>
</div>

<script>
    function formatAMPM(date) {
        var d = date.getDate();
        var m = date.getMonth() + 1;
        var y = date.getFullYear();

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        return hours + ':' + minutes + ' ' + ampm + " " + d + "/" + m + "/" + y;
    }

    function insertChat(who, text, messageId, inputDate = new Date()) {
        var control = "";
        var date = formatAMPM(inputDate);

        // parse message content
        var paragraphs = text.split("\n");
        console.log(paragraphs);
        var content = [];
        for (var i = 0; i < paragraphs.length; i ++) {
            content.push("<p>",
                paragraphs[i],
                "</p>");
        }

        if (who === "me") {
            control = '<li style="width:100%;" id="msg' + messageId + '">' +
                '<div class="msj-rta macro">' +
                '<div class="text text-r">' +
                content.join("") +
                '<p><small>' + date + '</small> <a onclick="deleteMessage(' + messageId + ')" style="color: silver; cursor: pointer">[delete]</a></p>' +
                '</div>' +
                '<div class="avatar" style="padding:0px 0px 0px 10px !important"></div>' +
                '</li>';
            // TODO: add delete button with message id inside
        } else {
            control = '<li style="width:100%" id="msg' + messageId + '">' +
                '<div class="msj macro">' +
                '<div class="avatar"><img class="img-circle" style="width:100%;" src="./img/footer-logo.png" /></div>' +
                '<div class="text text-l">' +
                content.join("") +
                '<p><small>' + date + '</small> <a onclick="deleteMessage(' + messageId + ')" style="color: silver; cursor: pointer">[delete]</a></p>' +
                '</div>' +
                '</div>' +
                '</li>';
        }
        $("#msgall").append(control);
    }

    function resetChat() {
        $("#msgall").empty();
    }

    function sendMessage() {
        var content = $("#msgtext").val().trim();
        if (content !== "") {
            // send message to server
            $.ajax({
                url: "messages-feedback.php",
                data: {
                    content: content,
                    action: 'UPDATE'
                },
                type: "POST",
                dataType: "json"
            })
                .done(function (feedback) {
                    if (feedback.message !== "success") {
                        snap.alert({
                            content: 'Sorry, failed. Please try again',
                            onClose: function () {
                            }
                        });
                    } else {
                        insertChat("me", content, feedback.messageId);
                        $("#msgtext").val(""); // clear box
                    }
                })
                .fail(function (xhr, status, errorThrown) {
                    alert("Sorry, there was a problem! Please try again later.");
                    console.log("Error: " + errorThrown);
                    console.log("Status: " + status);
                    console.dir(xhr);
                });
        }
    }

    // fetch message from server to write as these commands
    resetChat();
    <?php
        $conn = db_connect();
        $allMessage = getAllMessagesWithOneStu($conn, $studentID);
        for ($i = 0; $i < count($allMessage); $i ++) {
            if ($allMessage[$i]['deleteByStu']) continue;
            $sender = $allMessage[$i]['isFromStudent'] ? "me" : "researcher";
            echo 'insertChat("' . $sender . '", ' . json_encode($allMessage[$i]['content']) . ', '. $allMessage[$i]['id'] .
                ', new Date(' . strtotime($allMessage[$i]['time']) . '*1000));';
        }
        db_close($conn);
    ?>

    function deleteMessage(messageId) {
        snap.confirm({
            title: 'Delete this message?',
            content: 'are you sure you want to delete this message? This action cannot be undo!',
            confirm: 'Delete',
            cancel: 'Cancel',
            onConfirm: function () {
                $.ajax({
                    url: "messages-feedback.php",
                    data: {
                        message_id: messageId,
                        action: 'DELETE'
                    },
                    type: "POST",
                    dataType: "json"
                })
                    .done(function (feedback) {
                        if (feedback.message !== "success") {
                            snap.alert({
                                content: 'Sorry. Please try again',
                                onClose: function () {
                                }
                            });
                        } else {
                            $('#msg' + messageId).remove();
                        }
                    })
                    .fail(function (xhr, status, errorThrown) {
                        alert("Sorry, there was a problem!");
                        console.log("Error: " + errorThrown);
                        console.log("Status: " + status);
                        console.dir(xhr);
                    });
            }
        })
    }

    // mark current message as read at the end of the file
    $.ajax({
        url: "messages-feedback.php",
        data: {
            action: "VIEW"
        },
        type: "POST",
        dataType: "json"
    });

</script>
</body>
</html>

