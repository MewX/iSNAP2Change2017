<?php
    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "resources";

    $NOJUMP = true;
    require('student-validation.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Resources | SNAP²</title>
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
        .snap-facts-desc {
            width: 400px;
            margin: 0 auto 20px;
            text-align: center;
        }

        .break-line {
            word-wrap: break-word;      /* IE 5.5-7 */
            white-space: -moz-pre-wrap; /* Firefox 1.0-2.0 */
            white-space: pre-wrap;      /* current browsers */
        }

        .post .content
        {
            padding: 15px;
        }

        .post .post-img-content
        {
            position: relative;
            margin-bottom: 8px;
        }
        .post .post-title
        {
            display: table-cell;
            vertical-align: bottom;
            z-index: 2;
            position: absolute;
        }
        .post .post-title b
        {
            background-color: rgba(51, 51, 51, 0.58);
            display: inline-block;
            margin-bottom: 5px;
            color: #FFF;
            padding: 10px 15px;
            margin-top: 5px;
        }

        .extra-activities-intro {
            width: 600px;
            font-family: "Maitree", serif;
            font-size: 18px;
            margin: 0 auto;
            color: white;
        }

        .top-buffer { margin-top:24px; }
    </style>
</head>
<body>

<? require("./top-nav-bar.php") ?>

    <div class="content-wrapper" style="padding-top: 60px; min-height: calc(100vh - 127px);">
        <div class="snap-facts-container">
            <div class="snap-facts-header">
                <div class="snap-facts-desc h1" style="color: white; margin-top: 100px; margin-bottom: 24px">Resources</div>
                <div class="extra-activities-intro">The following resources are initiatives targeting and raising awareness of smoking and its damaging effects on youth:</div>
            </div>
            <div class="row" style="color: white; font-size: 16pt; margin-top: 24px">
                <div class="col-6  col-xs-offset-3">
                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>Truth</b><br /></span>
                                <a href="https://www.thetruth.com/" target="_blank">
                                    <img src="img/websites/thetruth.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>No Smokes</b><br /></span>
                                <a href="http://nosmokes.com.au/" target="_blank">
                                    <img src="img/websites/nosmokes.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row top-buffer" style="color: white; font-size: 16pt">
                <div class="col-6  col-xs-offset-3">
                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>Smarter than Smoking</b><br /></span>
                                <a href="http://www.smarterthansmoking.org.au/" target="_blank">
                                    <img src="img/websites/smarterthansmoking.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>Quit Now</b><br /></span>
                                <a href="http://www.quitnow.gov.au/" target="_blank">
                                    <img src="img/websites/quitnow.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row top-buffer" style="color: white; font-size: 16pt">
                <div class="col-6  col-xs-offset-3">
                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>Reachout</b><br /></span>
                                <a href="http://www.cyh.com/HealthTopics/HealthTopicDetails.aspx?p=243&np=163&id=2326" target="_blank">
                                    <img src="img/websites/cyh.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>Cancer Council SA</b><br /></span>
                                <a href="https://www.cancersa.org.au/quitline" target="_blank">
                                    <img src="img/websites/cancersa.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row top-buffer" style="color: white; font-size: 16pt">
                <div class="col-6  col-xs-offset-3">
                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>Centres for Disease Control and Prevention</b><br /></span>
                                <a href="https://www.cdc.gov/tobacco/basic_information/youth/index.htm" target="_blank">
                                    <img src="img/websites/cdc.jpg" class="img-responsive" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="post">
                            <div class="post-img-content">
                                <span class="post-title"><b>QUIT Helpline: 137 848</b><br /></span>
                                <img src="img/websites/sahealth.jpg" class="img-responsive" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<? require("./footer-bar.php") ?>
<script>
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

