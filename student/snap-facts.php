<?php
    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "snap-facts";

    $NOJUMP = true;
    require('student-validation.php');

    $conn = null;

    try {
        $conn = db_connect();

        //get fact topics
        $topicRes = getFactTopics($conn);

        //randomly select three topics to show
        $topicArr = array();
        foreach($topicRes as $singleTopic) {
            array_push($topicArr, $singleTopic->TopicID);
        }

        //randomly select one fact from each topic
        $factRes = array();
        if (count($topicArr) != 0) {
            $factsRes = getFactsByTopicID($conn, $topicArr[0]);
            $selectedRes = array_rand($factsRes, 3 > count($factsRes) ? count($factsRes) : 3);
            for ($i = 0; $i < count($selectedRes); $i ++) {
                array_push($factRes, $factsRes[$selectedRes[$i]]);
            }
        }
    } catch(Exception $e) {
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
    <title>SNAP² Facts | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="./css/home.css"/>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/vendor/animate.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <script src="./js/vendor/wow.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <style>
        .snap-facts-logo {
            display: block;
            width: 200px;
            height: 130px;
            margin: 20px auto;
            background-size: 100% 100%;
            background-image: url("./img/snap_facts_icon.png");
        }
        .snap-facts-desc {
            width: 400px;
            margin: 0 auto 20px;
            text-align: center;
        }
        .snap-facts-all {
            width: 800px;
            margin: 0 auto;
            padding-bottom: 20px;
            text-align: center;
        }
        .snap-facts-list {
            flex-wrap: wrap;
            display: flex;
            justify-content: center;
        }
        .snap-facts-item {
            margin: 0 10px 20px;
            /*float: left;*/
        }
        .snap-facts-link {
            display: block;
            color: inherit;
            width: 128px;
        }
        .snap-facts-item-name {
            display: block;
            height: 60px;
        }
        .snap-facts-item-logo {
            display: block;
            width: 128px;
            height: 128px;
            background-size: 100% 100%;
        }
        .snap-facts-item-smoking {
            color: #fcee2d;
        }
        .snap-facts-item-nutrition {
            color: #f7751e;
        }
        .snap-facts-item-alcohol {
            color: #93c;
        }
        .snap-facts-item-physical {
            color: #db1b1b;
        }
        .snap-facts-item-health {
            color: #db1b1b;
        }
        .snap-facts-item-sexual {
            color: #af24d1;
        }
        .snap-facts-item-drugs {
            color: #2fedc9;
        }


        .week-facts {
            max-width: 1000px;
            margin: 20px auto 20px;
            text-align: center;
        }
        .week-facts-title {
            color: #fcee2d;
            margin-bottom: 20px;
        }
        .week-facts-item {
            width: 33.33%;
            padding: 0 10px;
            float: left;
            margin-bottom: 20px;
        }

        .week-facts-item-smoking .week-facts-name{
            color: #fcee2d;
        }
        .week-facts-item-nutrition .week-facts-name{
            color: #f7751e;
        }
        .week-facts-item-alcohol .week-facts-name{
            color: #93c;
        }
        .week-facts-item-physical .week-facts-name{
            color: #db1b1b;
        }
        .week-facts-item-health .week-facts-name{
            color: #db1b1b;
        }
        .week-facts-item-sexual .week-facts-name{
            color: #af24d1;
        }
        .week-facts-item-drugs .week-facts-name{
            color: #2fedc9;
        }

        .week-facts-icon {
            display: block;
            width: 128px;
            height: 128px;
            background-size: 100% 100%;
            margin: 0 auto;
        }
        .week-facts-name {
            border-bottom: 2px solid;
            margin-bottom: 20px;
            display: block;
            font-size: 24px;
        }
        .week-facts-intro {
            color: #fff;
            font-size: 20px;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-static-top" id="nav">
    <div class="container">
        <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
        <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="glyphicon glyphicon-bar"></span>
            <span class="glyphicon glyphicon-bar"></span>
            <span class="glyphicon glyphicon-bar"></span>
        </a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a class="navbar-brand" href="./welcome.php">
                        <img alt="Brand" src="./img/Snap_Single_Wordform_White.png" style="height: 100%;">
                    </a>
                </li>
                <li class="divider"></li>
                <? if (isset($studentID)) { ?>
                    <li><a href="game-home.php">Dashboard</a></li>
                <? } ?>
                <li><a>SNAP² Facts</a></li>
                <li><a href="./resources.php">Resources</a></li>
            </ul>
            <ul class="nav pull-right navbar-nav">
                <? if (isset($studentID)) { ?>
                    <li>
                        <div class="setting-icon dropdown" style="margin-right: 0">
                            <ul class="dropdown-menu" style="margin-top: 0">
                                <li class="dropdown-item"><a href="settings.php">Settings</a></li>
                                <li class="dropdown-item"><a href="logout.php">Log out</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a class="setting-text"><?php echo $_SESSION["studentUsername"] ?></a></li>
                <? } else { ?>
                    <li><a href="#" data-toggle="modal" data-target="#myModal"><i
                                class="glyphicon glyphicon-off"></i> LOGIN</a></li>
                <? } ?>
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width:100%;">
    <div class="modal-dialog" role="document" style="height:450px;">
        <div class="modal-content" style="height:90%;">
            <div class="modal-body">
                <button id="login-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;"><span aria-hidden="true">&times;</span></button>
                <div class="col-xs-6 col-xs-offset-3">
                    <img src="./img/Snap_Logo_Inverted.png" style="height:20%; width: 100%;">
                    <div style="text-align: center; margin-top: 15%">
                        <span id="login-fail-text" style="color:red"></span>
                    </div>
                    <div class="input-group input-group-lg" style="margin-top:5%; text-align: center;">
                        <input id="username" type="text" style="text-align: center; border-radius: 10px; color:white; border: none; background-color: black;" class="form-control" placeholder="Username" onfocus="this.placeholder=''" onblur="this.placeholder='Username'" aria-describedby="sizing-addon1" autocomplete="off">
                    </div>
                    <div class="input-group input-group-lg" style="margin-top:5%; text-align: center;">
                        <input id="password" type="password" style="text-align: center; border-radius: 10px; border: none; color:white; background-color: black;" class="form-control" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'" aria-describedby="sizing-addon1">
                    </div>
                    <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top:5%; border-radius: 10px; border-color: #FCEE2D !important; color:#FCEE2D; background-color: black; opacity: 0.7;" onclick="validStudent()">Log In</button>
                    <div style="text-align: center; margin-top: 5%">
                        <span style="color: white;"> Don't have an account?</span>
                        <a href='#' onclick="location.href = 'valid-token.php';" style='color:#FCEE2D;'>Sign Up</a>
                    </div>

                    <script>
                        $(function(){
                            $('.modal-body').keypress(function(e){
                                if(e.which === 13) {
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


    <div class="content-wrapper" style="padding-top: 60px; min-height: calc(100vh - 127px);">
        <div class="snap-facts-container">
            <div class="snap-facts-header">
                <a href="#" class="snap-facts-logo"></a>
                <div class="snap-facts-desc p1">
                    SNAP² is all about providing information. <br/> Pick your category to start finding out more.
                </div>
            </div>

            <div class="snap-facts-all">
                <ul class="snap-facts-list">
                    <li class="snap-facts-item snap-facts-item-smoking">
                        <a href="snap-facts-detail.php?topic_id=1" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-smoking"></span>
                            <span class="snap-facts-item-name h4">Smoking</span>
                        </a>
                    </li>
                    <li class="snap-facts-item snap-facts-item-nutrition">
                        <a href="snap-facts-detail.php?topic_id=2" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-nutrition"></span>
                            <span class="snap-facts-item-name h4" >Nutirtion</span>
                        </a>
                    </li>
                    <li class="snap-facts-item snap-facts-item-alcohol">
                        <a href="snap-facts-detail.php?topic_id=3" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-alcohol"></span>
                            <span class="snap-facts-item-name h4" >Alcohol</span>
                        </a>
                    </li>
                    <li class="snap-facts-item snap-facts-item-physical">
                        <a href="snap-facts-detail.php?topic_id=4" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-physical"></span>
                            <span class="snap-facts-item-name h4" >Physical</span>
                        </a>
                    </li>
                    <li class="snap-facts-item snap-facts-item-health">
                        <a href="snap-facts-detail.php?topic_id=8" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-health"></span>
                            <span class="snap-facts-item-name h4" >Health and Wellbeing</span>
                        </a>
                    </li>
                    <li class="snap-facts-item snap-facts-item-sexual">
                        <a href="snap-facts-detail.php?topic_id=7" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-sexual"></span>
                            <span class="snap-facts-item-name h4" >Sexual Health</span>
                        </a>
                    </li>
                    <li class="snap-facts-item snap-facts-item-drugs">
                        <a href="snap-facts-detail.php?topic_id=6" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-drugs"></span>
                            <span class="snap-facts-item-name h4" >Drugs</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="week-facts">
            <h2 class="week-facts-title h1">Facts of the Week</h2>
            <div class="week-facts-content">
                <div class="week-facts-list">
                    <div class="clearfix">

                        <? for ($i = 0; $i < count($factRes); $i ++) { ?>
                        <div class="week-facts-item week-facts-item-smoking">
                            <a class="week-facts-divnk">
                                <span class="week-facts-icon image-icon-smoking"></span>
                                <span class="week-facts-name"><? echo strtoupper($factRes[$i]->TopicName) . " FACT #" . $factRes[$i]->SnapFactID ?></span>
                                <span class="week-facts-intro"><? echo $factRes[$i]->Content; ?></span>
                            </a>
                        </div>
                        <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
    $(document).ready(function () {

        $('.scrollToTop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });

        $('#nav').affix({
            offset: {
                top: 0 - $('#nav').height()
            }
        });

        $('body').scrollspy({target: '#nav'});

        $('.scroll-top').click(function () {
            $('body,html').animate({scrollTop: 0}, 1000);
        });

        /* smooth scrolling for nav sections */
        $('#nav .navbar-nav li>a').click(function () {
            var link = $(this).attr('href');
            var posi = $(link).offset();
            $('body,html').animate({scrollTop: posi}, 700);
        });

        $('#login-close-btn').click(function () {
            $('#login-fail-text').text("");
            $('#username').val("");
            $('#password').val("");
        });
    })

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

    function parseFeedback(feedback) {
        if(feedback.message !== "success"){
            alert(feedback.message + ". Please try again!");
            return;
        }

        if(feedback.result === "valid"){
            location.href = 'game-home.php';
        } else {
            $('#login-fail-text').text("Invalid username and/or password!");
            $('#password').val("");
        }
    }
</script>
</body>
</html>

