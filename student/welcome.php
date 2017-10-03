<?php
/**
 * Main entry
 */
    require_once('../mysql-lib.php');
    require_once('../debug.php');
    $pageName = "welcome";

    $NOJUMP = true;
    require ('student-validation.php');

    $conn = null;

    try {
        $conn = db_connect();

        //get students' rank
        $leaderboardRes = getStudentsRank($conn);

        //get fact topics
        $topicRes = getFactTopics($conn);

        //randomly select three topics to show
        $topicArr = array();

        foreach($topicRes as $singleTopic) {
            array_push($topicArr, $singleTopic->TopicID);
        }

        $randKeys = array_rand($topicArr, 3);

        //randomly select one fact from each topic
        $factRes = array();

        for($i = 0; $i < 3; $i++) {
            $factsRes = getFactsByTopicID($conn, $topicArr[$randKeys[$i]]);
            $randFactKey = array_rand($factsRes, 1);
            $factRes[$i] = $factsRes[$randFactKey];
        }
    } catch(Exception $e){
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
<html>
    <head>
        <title>SNAP²</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="./css/home.css"/>
        <link rel="stylesheet" href="./css/common.css">
        <link rel="stylesheet" type="text/css" href="./css/vendor/animate.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <script src="./js/vendor/wow.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>

        <header class="start" id="1">
            <div class="logo" style="display:flex;justify-content:center;align-items:center;width:100%;height:70%; margin-top: 5%;">
                <img class="wow flipInY" wow-data-delay="0.0s" wow-data-duration="0.9s" src="./img/Snap_Logo_Inverted.png" alt="SNAP" style="width:50%;height:68%;">
            </div>
            <div class="tagline" style="color: white; font-size: 5vh; display:flex;justify-content:center;align-items:center; margin-top:1%;">
                <span class="wow fadeInLeftBig" wow-data-delay="0.15s" wow-data-duration="0.3s">To inspire a healthier future.</span>
                <!-- <input type="image" src="./img/Refresh.png" name="saveForm" class="btTxt" id="scrollDown" style="border: none;" /> -->
            </div>
        </header>


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
                            <a class="navbar-brand">
                                <img alt="Brand" src="./img/Snap_Single_Wordform_White.png" style="height: 100%;">
                            </a>
                        </li>
                        <li class="divider"></li>
                        <? if (isset($studentID)) { ?>
                        <li><a href="game-home.php">Dashboard</a></li>
                        <? } ?>
                        <li><a href="./snap-facts.php">SNAP² Facts</a></li>
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

        <!-- Page 2 -->
        <div class="pg2" id="2">
            <div class="pg2_div" style="margin-top:4%; height: 100%; width: 100%;">
                <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-1" style="height: 100%;">
                    <div class="panel" style="background-color:black; border-radius:30px; height: 40%; width: 100%;">
                        <div class="panel-body" style="padding: 0px; height: 100%; width: 100%;">
                            <div class="col-xs-8 col-xs-offset-2" style="text-align: center; height: 55%;">

                                <img src="./img/achievement_logo.png" style="height: 60%; width: 20%;">
                                <br>
                                <span style="color: white; font-size: 3.2vh;"> Achievement of the week </span>

                            </div>
                            <div class="col-xs-8 col-xs-offset-2" style="text-align: center; height: 40%; margin-top:0.2%;">                            
                                <div style="width: 100%; border: 0px solid; border-bottom-color: #FCEE2D; border-bottom-width: 2px;">
                                    <span class="header4">Perfect Attendance</span></div>
                                <br>
                                <span class="p1">Log in every day for the entire SNAP² Program to unlock this achievement </span>
                            </div>                                                        
                        </div>
                    </div>

                    <div class="panel" style="background-color:black; border-radius:30px; height: 45%; width: 100%; margin-top: 3%;">
                        <div class="panel-body" style="padding: 0px; height: 100%; width: 100%;">
                            <div class="col-xs-8 col-xs-offset-2" style="text-align: center; height: 45%;">

                                <img src="./img/game_icon.png" style="height:65%; width: 20%;">
                                <br>
                                <span style="color: white; font-size: 3.2vh;"> Gaming High Scores </span>

                            </div>

                            <div class="col-xs-8 col-xs-offset-2" style="text-align: center; height: 65%;">                            
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                                    </ol>


                                    <div class="carousel-inner" role="listbox"> 
                                        <div class="item active">
                                            <img src="./img/Temple.jpg" alt="..." style="border-radius:30px;">
                                            <div class="carousel-caption">
                                                <div style="font-size: 2.5vh; color:rgb(54,232,197); border: 0px solid rgb(54,232,197); border-bottom-color: rgb(54,232,197); border-bottom-width: 2px; ">TEMPLE HIGH SCORE </div>
                                                <p style="font-size: 50px;">
                                                    34556
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="./img/Fruit.jpg" alt="..." style="border-radius:30px;">
                                            <div class="carousel-caption">
                                                <div style="font-size: 2.5vh; color:rgb(54,232,197); border: 0px solid rgb(54,232,197); border-bottom-color: rgb(54,232,197); border-bottom-width: 2px; ">FRUIT NINJA HIGH SCORE </div>
                                                <p style="font-size: 50px;">
                                                    34556
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="./img/Angry.jpg" alt="..." style="border-radius:30px;">
                                            <div class="carousel-caption">
                                                <div style="font-size: 2.5vh; color:rgb(54,232,197); border: 0px solid rgb(54,232,197); border-bottom-color: rgb(54,232,197); border-bottom-width: 2px; ">ANGRY BIRDS HIGH SCORE </div>
                                                <p style="font-size: 50px;">
                                                    34556
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="./img/Candy.jpg" alt="..." style="border-radius:30px;">
                                            <div class="carousel-caption">
                                                <div style="font-size: 2.5vh; color:rgb(54,232,197); border: 0px solid rgb(54,232,197); border-bottom-color: rgb(54,232,197); border-bottom-width: 2px; ">CANDY CRUSH HIGH SCORE </div>
                                                <p style="font-size: 50px;">
                                                    34556
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-0" style="background-color: black; padding-right:0px; padding-left:0px; padding-bottom:0px; height: 100%;">
                    <div class="scoreboard" style="height: 100%;">
                        <div class="scoreboard_header" style="height: 15%; text-align: center;">
                            <img src="./img/leader_board_icon.png" alt="..." style="width: 17%; height: 70%;">
                            <br>
                            <span style="text-align:center; color:white; font-size: 3.2vh;">Leaderboard</span>
                        </div>
                        <div class="table-res" style="height: 85%;">
                            <table class="table" style="background-color:black; text-align:center; color: white; vertical-align: middle !important;">
                                <thead style="color:#FCEE2D;">
                                <td>
                                    <span class="header4">Rank</span>
                                </td>
                                <td>
                                    <span class="header4">Username</span>
                                </td>
                                <td>
                                    <span class="header4">Score</span>
                                </td>
                                </thead>
                                <?php  for($i = 0; $i < count($leaderboardRes); $i++) {
                switch ($i) {
                    case 0: ?>
                        <tr style="font-size: 2.9vh;">
                            <td style="width: 35%;">
                                <img src="./img/first_place_icon.png" alt="..." style="width: 34%;">
                            </td> <?php ;
                        break;
                    case 1: ?>
                        <tr style="font-size: 2.7vh;">
                            <td style="width: 30%;">
                                <img src="./img/second_place_icon.png" alt="..." style="width: 30%;">
                            </td> <?php ;
                        break;
                    case 2: ?>
                        <tr style="font-size: 2.5vh;">
                            <td style="width: 40%;">
                                <img src="./img/third_place_icon.png" alt="..."  style="width: 28%;">
                            </td> <?php ;
                        break;
                    case 3: ?>
                        <tr style="font-size: 2.3vh;">
                            <td style="width: 40%;">
                                <img src="./img/fourth_place_icon.png" alt="..."  style="width: 25%;">
                            </td> <?php ;
                        break;
                    case 4: ?>
                        <tr style="font-size: 2.2vh;">
                            <td>
                                5th
                            </td> <?php ;
                        break;
                    case 5: ?>
                        <tr style="font-size: 2.2vh;">
                            <td>
                                6th
                            </td> <?php ;
                        break;
                    case 6: ?>
                        <tr style="font-size: 2.2vh;">
                            <td>
                                7th
                            </td> <?php ;
                        break;
                    case 7: ?>
                        <tr style="font-size: 2.2vh;">
                            <td>
                                8th
                            </td> <?php ;
                        break;
                    case 8: ?>
                        <tr style="font-size: 2.2vh;">
                            <td>
                                9th
                            </td> <?php ;
                        break;
                    case 9: ?>
                        <tr style="font-size: 2.2vh;">
                            <td>
                                10th
                            </td> <?php ;
                        break;
                }   ?>
                            <td class="header5"> <?php echo $leaderboardRes[$i]->Username ?> </td>
                            <td class="header5"> <?php echo $leaderboardRes[$i]->Score ?> </td>
                        </tr>
<?php   } ?>
                    </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>


        <!-- Page 4 -->
        <div class="pg4" id="4">
            <div class="pg3_heading" style="display:flex;justify-content:center;align-items:center;width:100%;height:15%;">
                <div style="width:50%;color:#FCEE2D; text-align:center; margin-top:2%; height: inherit;">
                    <span style="font-size: 5vh;">
                        Facts of the Week
                    </span>
                </div>
            </div>
            <div class="facts" style="width:100%; margin-top:5%; height:70%;">
                <div class="row" style="margin-left:0px; margin-right:0px; height: 100%; width: 100%;">
                <?php   for($i = 0; $i < 3; $i++) {
        if($i == 0) { ?>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4 col-md-offset-0 fact1" style="text-align: center; height: 100%; ">
                    <?php   } else if($i == 1) { ?>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4 col-md-offset-0 fact2" style="text-align: center; height: 100%; ">
<?php   } else if($i == 2) { ?>
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-0 fact3" style="text-align: center; height: 100%; ">
<?php   } ?>

                        <div class="col-xs-4 col-xs-offset-4" style="height: 25%;">
        <?php
            switch($factRes[$i]->TopicID) {
                case 1: ?>
                    <img src="./img/smoking_icon.png" style="height: 100%; width: 90%;"> <?php ;
                    break;
                case 2: ?>
                    <img src="./img/nutrition_icon.png" style="height: 100%; width: 90%;"> <?php ;
                    break;
                case 3: ?>
                    <img src="./img/alcohol_icon.png" style="height: 100%; width: 90%;"> <?php ;
                    break;
                case 4: ?>
                    <img src="./img/physical_activity_icon.png" style="height: 100%; width: 90%;"> <?php ;
                    break;
            } ?>
                        </div>
                        <div class="col-xs-12" style="height: 75%;">
                            <?php
                    switch($factRes[$i]->TopicID) {
                        case 1: ?>
                            <div style="color:rgb(252,238,045); border: 0px solid rgb(252,238,045); border-bottom-color: rgb(252,238,045); border-bottom-width: 2px; font-size:3vh; width: 100%;margin-bottom: 20pt;padding-bottom:10pt; "> <?php ;
                            break;
                        case 2: ?>
                            <div style="color:rgb(247,117,030); border: 0px solid rgb(247,117,030); border-bottom-color: rgb(247,117,030); border-bottom-width: 2px; font-size:3vh; width: 100%;margin-bottom: 20pt;padding-bottom:10pt;"> <?php ;
                            break;
                        case 3: ?>
                            <div style="color:rgb(175,36,209); border: 0px solid rgb(175,36,209); border-bottom-color: rgb(175,36,209); border-bottom-width: 2px; font-size:3vh; width: 100%;margin-bottom: 20pt;padding-bottom:10pt;"> <?php ;
                            break;
                        case 4: ?>
                            <div style="color:rgb(219,27,27); border: 0px solid rgb(219,27,27); border-bottom-color: rgb(219,27,27); border-bottom-width: 2px; font-size:3vh; width: 100%;margin-bottom: 20pt;padding-bottom:10pt;"> <?php ;
                            break;
                    }
                        echo strtoupper($factRes[$i]->TopicName)." FACT #".$factRes[$i]->SnapFactID; ?>
                            </div>
                            <span class="fact"><?php echo $factRes[$i]->Content; ?></span>
                        </div>
                    </div>
                  <?php   }   ?>
                </div>

            </div>
            <div class="pg3_footer" style="display:flex;justify-content:center;align-items:center;width:100%;height:10%; margin-top: 4%;">
                <div style="width:50%;color:white; text-align:center; height: 100%;">
                    <span class="p1">Want to know more?</span>
                    <br>
                    <span style="height: 50%;">
                        <a href="./snap-facts.php"><img src="./img/snap_facts_icon.png" style="height: inherit; width: 10%;"/></a>
                    </span>
                </div>
            </div>          </div>

        <!-- Page 5 -->
        <div class="pg5" id="5" style="height: auto; min-height: 0;">
            <div class="contact" style="width:100%; height:100%; text-align: center;">
                <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-1 contact1" style="margin-top:2%; height: 50%; ">
                    <span class="p1">Any questions or comments?
                        <br> Please contact us and we will reach out to you shortly.
                        <br>
                        <br>
                    </span>
                    <form>
                        <div class="form-group" style="text-align: center;">
                            <label class="header5" style="color: #FCEE2D">Name</label>
                            <input type="text" class="form-control" id="myName">
                        </div>
                        <div class="form-group" style="text-align: center;">
                            <label class="header5" style="color: #FCEE2D">Email</label>
                            <input type="email" class="form-control" id="emailID">
                        </div>
                        <textarea id="commentContent" class="form-control" rows="4" style="margin-top: 3%"></textarea>
                    </form>
                    <div class="sendbutton" style="display:flex;justify-content:center;align-items:center;width:100%;height:20%; margin-top:1%;">
                        <div style="width:50%;color:#FCEE2D; text-align:center;">
                            <span>
                            <a onclick="leaveComment();">
                                <img src="./img/send_icon.png" style="height: 75px; width: 75px;">
                            </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-10 col-xs-offset-1 col-md-3 col-md-offset-1 contact2" style="margin-top:3%; height:50%; margin-bottom: 1%;">
                    <div class="logo" style="height:35%;">
                        <img src="./img/Snap_Logo_Inverted.png" style="width:90%; height: 90%;">
                    </div>
                    <div style="margin-top:3%;text-align: justify">
                        <span class="p1">Tobacco smoking is one of the largest causes of preventable illness and death in Australia. Research estimates that two in three lifetime smokers will die from a disease caused by their smoking. The most recent estimate of deaths caused by tobacco in Australia is for the financial year 2004–05.
                        </span>
                    </div>
                </div>
                <div class="col-xs-4 col-xs-offset-4 col-md-2 col-md-offset-5" style="padding-bottom: 72px; height: 10%; margin-top:1%; margin-bottom: 1%;">
                    <div class="back2top" style="display:flex;justify-content:center;align-items:center;width:100%; height: 10%;">
                        <div style="width:50%;color:#FCEE2D; text-align:center; height: 100%;">
                            <span>
                                <a class='scrollToTop' href="#">
                                <img src="./img/back_to_top_icon.png" style="height: 30%; width: 30%;">
                                </a>
                            </span>
                            <br>
                            <span class="header5">Back to Top</span>
                        </div>
                    </div>
                </div>

                <nav class="navbar navbar-inverse navbar-fixed-bottom">
                    <div class="container">
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="active">
                                    <a class="navbar-brand" href="#">
                                        <img alt="Brand" src="./img/footer-logo.png" style="height: 100%;">
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li><span class="navbar-text navbar-right">Legal stuff - All rights reserved</span></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div id="fb-root"></div>

        <script>
            wow = new WOW(
                {
                    boxClass:     'wow',      // default
                    animateClass: 'animated', // default
                    offset:       0,          // default
                    mobile:       true,       // default
                    live:         true        // default
                }
            );
            wow.init();

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
            });

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

            function leaveComment() {
                var name = $('#myName').val();
                var email = $('#emailID').val();
                var content = $('#commentContent').val();

                $.ajax({
                    url: "visitor-comment-feedback.php",
                    data: {
                        name: name,
                        email: email,
                        content: content
                    },
                    type: "POST",
                    dataType: "json"
                })
                .done(function (feedback) {
                    if(feedback.message !== "success") {
                        alert(feedback.message + ". Please try again!");
                    } else {
                        $('#myName').val("");
                        $('#emailID').val("");
                        $('#commentContent').val("");
                        alert("Successfuly submission! Thank you!");
                    }
                })
                .fail(function (xhr, status, errorThrown) {
                    alert("Sorry, there was a problem! Please try again later.");
                    console.log("Error: " + errorThrown);
                    console.log("Status: " + status);
                    console.dir(xhr);
                });
            }
        </script>
                        
    </body>
</html>
