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
        //randomly select three facts from smoking
        $factRes = array();

        $factsRes = getFactsByTopicID($conn, 1);
        $randFactKey = array_rand($factsRes, 3);
        for($i = 0; $i < 3; $i++) {
            $factRes[$i] = $factsRes[$randFactKey[$i]];
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
            padding-bottom: 0px;
            text-align: center;
        }
        .snap-facts-list {
            flex-wrap: wrap;
            display: flex;
            justify-content: center;
        }
        .snap-facts-item {
            margin: 0 10px 00px;
            /*float: left;*/
        }
        .snap-facts-link {
            display: block;
            color: inherit;
            width: 128px;
        }
        .snap-facts-item-name {
            display: block;
            height: 10px;
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
            font-size: 25px;
        }
        .week-facts-recource {
            color: #dfdfdf;
            font-size: 12px;
        }

    </style>
</head>
<body>

<? require("./top-nav-bar.php") ?>

    <div class="content-wrapper" style="padding-top: 60px; min-height: calc(100vh - 127px);">
        <div class="snap-facts-container">
            <div class="snap-facts-header">
                <a href="#" class="snap-facts-logo"></a>
                <div class="snap-facts-desc p1">
                    SNAP² is all about providing information.
                </div>
            </div>
            <br>
            <div class="snap-facts-all">
                <ul class="snap-facts-list">
                    <li class="snap-facts-item snap-facts-item-smoking">
                        <a href="snap-facts-detail.php?topic_id=1" class="snap-facts-link">
                            <span class="snap-facts-item-logo image-icon-smoking"></span>
                            <span class="snap-facts-item-name h4">Smoking</span>
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
                                <br>
                                <br>
                                <span class="week-facts-name"><? echo strtoupper($factRes[$i]->TopicName)." FACT #".$factRes[$i]->SnapFactID ?></span>
                                <p class="week-facts-intro" onclick="showSource(this)">
                                    <? echo $factRes[$i]->Content; ?>
                                </p>
                                <p class="week-facts-recource" style="display: none">
                                    <strong>Source: </strong><? echo $factRes[$i]->Recource; ?>
                                </p>
                            </a>
                        </div>
                        <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? require("./footer-bar.php") ?>
<script>
    function showSource(e){
        if(e.parentElement.childNodes[9].style.display == 'none'){
            e.parentElement.childNodes[9].style.display = 'block';
        }else{
            e.parentElement.childNodes[9].style.display = 'none';
        }
    }

    $(document).ready(function () {
        $('.scrollToTop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });

        $('.scroll-top').click(function () {
            $('body,html').animate({scrollTop: 0}, 1000);
        });
    });


</script>
</body>
</html>

