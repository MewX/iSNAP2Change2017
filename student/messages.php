<?php
//check login status
require_once('./student-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");

$conn = null;

try {
    $conn = db_connect();

    //get quiz viewed attribute
    $quizViewedAttrs = getQuizViewdAttr($conn, $studentID);

    //get student question viewed attribute
    $studentQuesViewedAttrs = getUnreadMessages($conn, $studentID);

    //get student week
    $studentWeek = getStudentWeek($conn, $studentID);

} catch (Exception $e) {
    if ($conn != null) {
        db_close($conn);
    }
    debug_err($e);
}

db_close($conn);
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
    <div class="header-wrapper">
        <div class="header">
            <a class="home-link" href="welcome.php">SNAP²</a>
            <ul class="nav-list">
                <li class="nav-item"><a class="nav-link" href="game-home.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="snap-facts.php">SNAP² Facts</a></li>
                <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
            </ul>
            <div class="settings">
                <div class="info-item info-notification">
                    <a class="info-icon" href="javascript:;"></a>
                    <?php if (count($quizViewedAttrs) != 0) { ?>
                        <span class="info-number"><?php echo count($quizViewedAttrs) ?></span>
                    <?php } ?>
                    <ul class="info-message-list">
                        <?php for ($i = 0; $i < count($quizViewedAttrs); $i++) {
                            if ($quizViewedAttrs[$i]["extraQuiz"] == 0) {
                                $url = "weekly-task.php?week=" . $quizViewedAttrs[$i]["week"];
                            } else {
                                $url = "extra-activities.php?week=" . $quizViewedAttrs[$i]["week"];
                            } ?>
                            <li class="info-message-item">
                                <a href="<?php echo $url ?>">
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
                    <a class="info-icon" href="javascript:;"></a>
                    <?php if (count($studentQuesViewedAttrs) != 0) { ?>
                        <span class="info-number"><?php echo count($studentQuesViewedAttrs) ?></span>
                    <?php } ?>
                    <ul class="info-message-list">
                        <li class="info-message-item">
                            <?php
                            for ($i = 0; $i < count($studentQuesViewedAttrs); $i++) { ?>
                                <a href="messages.php">
                                    You message about <?php echo $studentQuesViewedAttrs[$i]->Subject ?> has been
                                    replied.
                                </a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>

                <div class="setting-icon dropdown">
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="settings.php">Settings</a></li>
                        <li class="dropdown-item"><a href="logout.php">Log out</a></li>
                    </ul>
                </div>
                <a class="setting-text"><?php echo $_SESSION["studentUsername"] ?></a>
            </div>
        </div>
    </div>

    <!-- Real messages -->
    <!-- Codes from: https://bootsnipp.com/snippets/featured/simple-chat -->
    <div class="content-wrapper">
        <div class="inbox-header">
            <div class="inbox-icon"></div>
            <h2 class="h2 inbox-title" style="color: white">Messages</h2>
            <div class="p1 inbox-prompt" style="color: white">View your messages and replies.</div>
        </div>
        <div class="col-4 col-sm-offset-4 frame" style="float: none">
            <ul id="msgall" class="msgframe"></ul>
            <div class="msgframe">
                <div class="msj-rta macro" style="margin:auto">
                    <div class="text text-r" style="background:whitesmoke !important">
<!--                        <input class="mytext" placeholder="Type a message"/>-->
                        <textarea class="scrollabletextbox mytext" name="note" placeholder="Input your message here" id="msgtext"></textarea>
                    </div>
                    <button type="button" class="btn btn-default" style="width: 10%" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>

    <ul class="sitenav">
        <li class="sitenav-item sitenav-game-home"><a href="games.php" data-toggle="tooltip" title="Game Home"></a></li>
        <li class="sitenav-item sitenav-extra-activities"><a href="extra-activities.php" data-toggle="tooltip" title="Extra Activities"></a></li>
        <li class="sitenav-item sitenav-progress"><a href="progress.php" data-toggle="tooltip" title="Progress"></a></li>
        <li class="sitenav-item sitenav-reading-material"><a href="reading-material.php" data-toggle="tooltip" title="Reading Materials"></a></li>
    </ul>

    <div class="footer-wrapper">
        <div class="footer">
            <div class="footer-content">
                <a href="#" class="footer-logo"></a>
                <ul class="footer-nav">
                    <li class="footer-nav-item"><a href="#">Any Legal Stuff</a></li>
                    <li class="footer-nav-item"><a href="#">Acknowledgements</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    var me = {};
    me.avatar = "https://lh6.googleusercontent.com/-lr2nyjhhjXw/AAAAAAAAAAI/AAAAAAAARmE/MdtfUmC0M4s/photo.jpg?sz=48";

    var you = {};
    you.avatar = "https://a11.t26.net/taringa/avatares/9/1/2/F/7/8/Demon_King1/48x48_5C5.jpg";

    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        return hours + ':' + minutes + ' ' + ampm;
    }

    //-- No use time. It is a javaScript effect.
    function insertChat(who, text, time = 0) {
        var control = "";
        var date = formatAMPM(new Date());

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
            control = '<li style="width:100%;">' +
                '<div class="msj-rta macro">' +
                '<div class="text text-r">' +
                content.join("") +
                '<p><small>' + date + '</small></p>' +
                '</div>' +
                '<div class="avatar" style="padding:0px 0px 0px 10px !important"><img class="img-circle" style="width:100%;" src="' + you.avatar + '" /></div>' +
                '</li>';
        } else {
            control = '<li style="width:100%">' +
                '<div class="msj macro">' +
                '<div class="avatar"><img class="img-circle" style="width:100%;" src="' + me.avatar + '" /></div>' +
                '<div class="text text-l">' +
                content.join("") +
                '<p><small>' + date + '</small></p>' +
                '</div>' +
                '</div>' +
                '</li>';
        }
        setTimeout(
            function () {
                $("#msgall").append(control);
            }, time);
    }

    function resetChat() {
        $("#msgall").empty();
    }

    function sendMessage() {
        var text = $("#msgtext").val().trim();
        if (text !== "") {
            // TODO: send message to server

            // then decide to add to context and remove or not
            insertChat("me", text);
            $(this).val('');
        }
        $("#msgtext").val(""); // clear box
    }

    //-- Clear Chat
    resetChat();

    //-- Print Messages
    insertChat("me", "Hello Tom...", 0);
    insertChat("you", "Hi, Pablo", 1500);
    insertChat("me", "What would you like to talk about today?", 3500);
    //    insertChat("you", "Tell me a joke",7000);
    //    insertChat("me", "Spaceman: Computer! Computer! Do we bring battery?!", 9500);
    //    insertChat("you", "LOL", 12000);


    //--------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------


    function onItemDelete(itemId) {
        $.ajax({
            url: "messages-feedback.php",
            data: {
                question_id: itemId,
                action: 'DELETE'
            },
            type: "POST",
            dataType: "json"
        })

            .done(function (feedback) {
                parseDeleteFeedback(feedback);
            })

            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    }

    var $body = $('body');

    $body.on('click', '.inbox-subject', function (e) {
        var $item = $(e.currentTarget).closest('.inbox-item')
        DetailCtrl.show($item.data('id'))
    })
    $body.on('click', '.inbox-delete', function (e) {
        var $item = $(e.currentTarget).closest('.inbox-item')
        var itemId = $item.data('id')
        snap.confirm({
            title: 'Delete this message?',
            content: 'are you sure you want to delete this message? This action cannot be undo!',
            confirm: 'Delete',
            cancel: 'Cancel',
            onConfirm: function () {
                onItemDelete(itemId)
            }
        })
    })

    var DetailCtrl = {
        init: function () {
            this.cacheElements()
            this.addListeners()
        },

        cacheElements: function () {
            var $main = $('.detail-container')
            this.$main = $main
            this.$detailBoxes = $main.find('.detail-box')

        },
        addListeners: function () {
            var that = this
            this.$main.on('click', '.detail-close', function () {
                that.hide()
            })
        },
        hide: function () {
            this.$main.hide()
        },
        show: function (targetId) {
            this.$detailBoxes
                .removeClass('detail-box-active')
                .filter('[data-id=' + targetId + ']')
                .addClass('detail-box-active')

            this.$main.show();

            $.ajax({
                url: "messages-feedback.php",
                data: {
                    question_id: targetId,
                    action: 'VIEW'
                },
                type: "POST",
                dataType: "json"
            })

                .done(function (feedback) {
                    parseViewFeedback(feedback);
                })

                .fail(function (xhr, status, errorThrown) {
                    alert("Sorry, there was a problem!");
                    console.log("Error: " + errorThrown);
                    console.log("Status: " + status);
                    console.dir(xhr);
                });
        }
    }
    DetailCtrl.init();


    function onMessageSend(data) {
        console.log(data);

        var sendTime = new Date();

        var dd = sendTime.getDate();
        var mm = sendTime.getMonth() + 1;
        var yyyy = sendTime.getFullYear();

        if (dd < 10) {
            dd = "0" + dd;
        }

        if (mm < 10) {
            mm = "0" + mm;
        }

        sendTime = yyyy + "-" + mm + "-" + dd + " " + sendTime.getHours() + ":" + sendTime.getMinutes() + ":" + sendTime.getSeconds();

        $.ajax({
            url: "messages-feedback.php",
            data: {
                student_id: <?php echo $studentID?>,
                subject: data.title,
                content: data.content,
                action: 'UPDATE'
            },
            type: "POST",
            dataType: "json"
        })

            .done(function (feedback) {
                parseUpdateFeedback(feedback);
            })

            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    }

    function parseDeleteFeedback(feedback) {
        if (feedback.message != "success") {
            snap.alert({
                content: 'Sorry. Please try again',
                onClose: function () {
                }
            });
        } else if (feedback.message == "success") {
            snap.alert({
                content: 'You have deleted this message',
                onClose: function () {
                    deleteMessage(feedback.questionID)
                }
            });
        }
    }

    function parseUpdateFeedback(feedback) {
        if (feedback.message != "success") {
            snap.alert({
                content: 'Sorry. Please try again',
                onClose: function () {
                }
            });
        } else if (feedback.message == "success") {
            snap.alert({
                content: 'You have sent a message to the researcher. Please wait for reply',
                onClose: function () {
                    window.location.href = "messages.php";
                }
            });
        }
    }

    function parseViewFeedback(feedback) {
        if (feedback.message != "success") {
            snap.alert({
                content: 'Sorry. Please try again',
                onClose: function () {
                }
            });
        }
    }

    function deleteMessage(id) {
        $('.inbox-item').filter('[data-id=' + id + ']')
            .remove()
    }
</script>
</body>
</html>

