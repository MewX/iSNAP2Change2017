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
        $quizLeaderboardRes = getStudentsRank($conn);
        $gameLeaderboardRes = getStudentGameRank($conn);
        //get fact topics
        $topicRes = getFactTopics($conn);

        //randomly select three topics to show
        $topicArr = array();

        foreach($topicRes as $singleTopic) {
            array_push($topicArr, $singleTopic->TopicID);
        }

        //randomly select three facts from smoking
        $factRes = array();

        $factsRes = getFactsByTopicID($conn, 1);
        $randFactKey = array_rand($factsRes, 3);
        for($i = 0; $i < 3; $i++) {
            $factRes[$i] = $factsRes[$randFactKey[$i]];
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

        <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
        <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="./css/home.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/common.css">
        <link rel="stylesheet" type="text/css" href="./css/vendor/animate.css"/>

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
                <span class="wow fadeInLeftBig" wow-data-delay="0.15s" wow-data-duration="0.3s">To inspire a healthier future</span>
                <!-- <input type="image" src="./img/Refresh.png" name="saveForm" class="btTxt" id="scrollDown" style="border: none;" /> -->
            </div>
        </header>

        <? require("./top-nav-bar.php") ?>

        <!-- Page 2 -->
        <div class="pg2" id="2">
            <div class="pg2_div" style="margin-top:4%; height: 100%; width: 100%;">
                <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-0" style="height: 100%;">
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
                                <span style="color: white; font-size: 3.2vh;"> Download Games </span>

                            </div>

                            <div class="col-xs-8 col-xs-offset-2" style="text-align: center; height: 65%;">
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <img src="./img/sportNinja.jpg" alt="..." style="border-radius:30px;">
                                            <div class="carousel-caption">
                                                <a href="games.php" style="font-size: 3vh; color:rgb(255,255,255); border: 0px solid rgb(255,255,255); border-bottom-color: rgb(255,255,255); border-bottom-width: 2px; ">SPORT NINJA</a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="./img/Candy.jpg" alt="..." style="border-radius:30px;">
                                            <div class="carousel-caption">
                                                <a href="games.php" style="font-size: 3vh; color:rgb(255,255,255); border: 0px solid rgb(255,255,255); border-bottom-color: rgb(255,255,255); border-bottom-width: 2px; ">MEAL CRUSH</a>
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
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    </ol>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 col-md-3 col-md-offset-0" style="background-color: black; padding-right:0px; padding-left:0px; padding-bottom:0px; height: 100%;">
                    <div class="scoreboard" style="height: 100%;">
                        <div class="scoreboard_header" style="height: 15%; text-align: center;">
                            <img src="./img/leader_board_icon.png" alt="..." style="width: 17%; height: 70%;">
                            <br>
                            <span style="text-align:center; color:white; font-size: 3.2vh;">Quiz Leaderboard</span>
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
                                <?php  for($i = 0; $i < count($quizLeaderboardRes); $i++) {
                switch ($quizLeaderboardRes[$i]->ranking-1) {
                    case 0: ?>
                        <tr style="font-size: 2.9vh;">
                            <td style="width: 35%;">
                                <img src="./img/first_place_icon.png" alt="..." style="width: 34%;">
                            </td> <?php ;
                        break;
                    case 1: ?>
                        <tr style="font-size: 2.9vh;">
                            <td style="width: 35%;">
                                <img src="./img/second_place_icon.png" alt="..." style="width: 30%;">
                            </td> <?php ;
                        break;
                    case 2: ?>
                        <tr style="font-size: 2.9vh;">
                            <td style="width: 50%;">
                                <img src="./img/third_place_icon.png" alt="..."  style="width: 28%;">
                            </td> <?php ;
                        break;
                    case 3: ?>
                        <tr style="font-size: 2.9vh;">
                            <td style="width: 50%;">
                                <img src="./img/fourth_place_icon.png" alt="..."  style="width: 25%;">
                            </td> <?php ;
                        break;
                    case 4: ?>
                        <tr style="font-size: 2.9vh;">
                            <td>
                                5th
                            </td> <?php ;
                        break;
                    case 5: ?>
                        <tr style="font-size: 2.9vh;">
                            <td>
                                6th
                            </td> <?php ;
                        break;
                    case 6: ?>
                        <tr style="font-size: 2.9vh;">
                            <td>
                                7th
                            </td> <?php ;
                        break;
                    case 7: ?>
                        <tr style="font-size: 2.9vh;">
                            <td>
                                8th
                            </td> <?php ;
                        break;
                    case 8: ?>
                        <tr style="font-size: 2.9vh;">
                            <td>
                                9th
                            </td> <?php ;
                        break;
                    case 9: ?>
                        <tr style="font-size: 2.9vh;">
                            <td>
                                10th
                            </td> <?php ;
                        break;
                }   ?>
                            <td class="header5"> <?php echo $quizLeaderboardRes[$i]->Username ?> </td>
                            <td class="header5"> <?php echo $quizLeaderboardRes[$i]->Score ?> </td>
                        </tr>
<?php   } ?>
                    </table>
                        </div>
                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 col-md-3 col-md-offset-1" style="background-color: black; padding-right:0px; padding-left:0px; padding-bottom:0px; height: 100%;">
                    <div class="scoreboard" style="height: 100%;">
                        <div class="scoreboard_header" style="height: 15%; text-align: center;">
                            <img src="./img/start_flag_icon.png" alt="..." style="width: 17%; height: 70%;">
                            <br>
                            <span style="text-align:center; color:white; font-size: 3.2vh;">Game Leaderboard</span>
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
                                <?php  for($i = 0; $i < count($gameLeaderboardRes); $i++) {
                                    switch ($gameLeaderboardRes[$i]->ranking-1) {
                                        case 0: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td style="width: 35%;">
                                                <img src="./img/first_place_icon.png" alt="..." style="width: 34%;">
                                            </td> <?php ;
                                            break;
                                        case 1: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td style="width: 35%;">
                                                <img src="./img/second_place_icon.png" alt="..." style="width: 30%;">
                                            </td> <?php ;
                                            break;
                                        case 2: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td style="width: 50%;">
                                                <img src="./img/third_place_icon.png" alt="..."  style="width: 28%;">
                                            </td> <?php ;
                                            break;
                                        case 3: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td style="width: 50%;">
                                                <img src="./img/fourth_place_icon.png" alt="..."  style="width: 25%;">
                                            </td> <?php ;
                                            break;
                                        case 4: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td>
                                                5th
                                            </td> <?php ;
                                            break;
                                        case 5: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td>
                                                6th
                                            </td> <?php ;
                                            break;
                                        case 6: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td>
                                                7th
                                            </td> <?php ;
                                            break;
                                        case 7: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td>
                                                8th
                                            </td> <?php ;
                                            break;
                                        case 8: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td>
                                                9th
                                            </td> <?php ;
                                            break;
                                        case 9: ?>
                                            <tr style="font-size: 2.9vh;">
                                            <td>
                                                10th
                                            </td> <?php ;
                                            break;
                                    }   ?>
                                    <td class="header5"> <?php echo $gameLeaderboardRes[$i]->Username ?> </td>
                                    <td class="header5"> <?php echo $gameLeaderboardRes[$i]->Score ?> </td>
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
                            <img src="./img/smoking_icon.png" style="height: 100%; width: 90%;">
                        </div>
                        <div class="col-xs-12" style="height: 75%;">
                            <div style="color:rgb(252,238,045); border: 0px solid rgb(252,238,045); border-bottom-color: rgb(252,238,045); border-bottom-width: 2px; font-size:3vh; width: 100%;margin-bottom: 20pt;padding-bottom:10pt; ">
                        <?php echo strtoupper($factRes[$i]->TopicName)." FACT #".$factRes[$i]->SnapFactID; ?>
                            </div>
                            <p class="fact" onclick="showSource(this)"><?php echo $factRes[$i]->Content; ?></p>
                            <p class="recource" style="display: none">
                                <strong>Source: </strong><? echo $factRes[$i]->Recource; ?>
                            </p>
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
<!--                <div class="col-xs-10 col-xs-offset-1 col-md-5 col-md-offset-1 contact1" style="margin-top:2%; height: 50%; ">-->
                <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-0 contact1" style="margin-top:2%; height: 50%; ">
                    <div class="col-md-9 col-md-offset-2">
                    <span class="p1">
                        <br>
                        Any questions or comments?
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
                    <br>
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
                </div>
                <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-0 contact2" style="margin-top:3%; height:50%; margin-bottom: 1%;">
                    <div class="col-md-9 col-md-offset-1">
                    <div class="logo">
                        <img src="./img/Snap_Logo_Inverted.png" style="width:60%; height: 60%;">
                    </div>
                    <div style="margin-top:3%;text-align: justify; color: white;font-family: Maitree, serif;">
<!--                        <span class="p1">Tobacco smoking is one of the largest causes of preventable illness and death in Australia. Research estimates that two in three lifetime smokers will die from a disease caused by their smoking. The most recent estimate of deaths caused by tobacco in Australia is for the financial year 2004–05.-->
<!--                        </span>-->
                        <p>Welcome to the SNAP² website. </p>

                        <p>The purpose of this website is to inspire a healthier future and reduce the uptake of youth smoking.
                            This website features an interactive 10-week course designed to be run out in schools educate youth about the harms of smoking, whilst also endeavouring to upskill youth in resistance and refusal skills to not give in to the pressure of smoking. Featured activities on the website include quizzes, videos, games, creative exercises and competitions.</p>

                        <p>An evaluation of the website will occur after the course is completed through a series of focus groups with youth, parents/guardians and teachers.</p>

                        <p>This website has been created for the purpose of Harshani Jayasinghe’s Doctorate of Philosophy with The University of Adelaide.</p>
                    </div>
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
            </div>
        </div>
        <div class="pg6" id="6" style="height: auto; min-height: 0;">
            <? require("./footer-bar.php") ?>
        </div>

        <div id="fb-root">
        </div>

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

                $('.scroll-top').click(function () {
                    $('body,html').animate({scrollTop: 0}, 1000);
                });
            });

            function showSource(e){
                if(e.parentElement.childNodes[5].style.display == 'none'){
                    e.parentElement.childNodes[5].style.display = 'block';
                }else{
                    e.parentElement.childNodes[5].style.display = 'none';
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
