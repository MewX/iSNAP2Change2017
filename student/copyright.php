<?php
require_once("../mysql-lib.php");
require_once("../achievement-lib.php");
require_once("../debug.php");
$pageName = "resources";

$NOJUMP = true;
require('student-validation.php');

$conn = db_connect();
// logged in
if (isset($studentID)) {
    achSetResourcePage($conn, $studentID);
    achCheckAndSetQuizMaster($conn, $studentID);
}
db_close($conn);
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
            text-align: justify;
        }

        .top-buffer { margin-top:24px; }
    </style>
</head>
<body>

<? require("./top-nav-bar.php") ?>

<div class="content-wrapper" style="padding-top: 60px; min-height: calc(100vh - 127px);">
    <div class="snap-facts-container">
        <div class="snap-facts-header">
            <div class="snap-facts-desc h1" style="color: white; margin-top: 100px; margin-bottom: 24px">Copyright</div>
            <div class="extra-activities-intro">© 2017 HARSHANI JAYASINGHE AND THE UNIVERSITY OF ADELAIDE
                ALL RIGHTS RESERVED [01/11/2017]
            </div>
            <br>
            <div class="extra-activities-intro">
                The contents of this website is protected by copyright law. Copyright in this material resides with the
                Commonwealth of Australia or various other rights holders, as indicated. Except as permitted by the copyright
                law applicable to you, you may not reproduce or communicate any of the content on the Smoking, Nicotine Adolescent
                Prevention Program (SNAP2 ) website, including files downloadable from this website, without the permission
                of the copyright owners.
            </div>
            <br>
            <div class="extra-activities-intro">
                This includes games, designs, images, interactive activities and content from the SNAP2  website.
            </div>
            <br>
            <div class="extra-activities-intro">
                The Australian Copyright Act allows certain uses of content from the internet without the copyright owner’s
                permission. This includes uses by educational institutions and by Commonwealth and State governments,
                provided fair compensation is paid. For more information,
                see <a href="www.copyright.com.au">www.copyright.com.au</a> and <a href="www.copyright.org.au">www.copyright.org.au</a>.
            </div>
            <br>
            <div class="extra-activities-intro">
                The owners of copyright in the content on this website may receive compensation for the use of their content
                by educational institutions and governments, including from licensing schemes managed by Copyright Agency.
            </div>
            <br>
            <div class="extra-activities-intro">
                We may change these terms of use from time to time. Check before re-using any content from this website.
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

