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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="./js/vendor/wow.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/home.css"/>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/vendor/animate.css"/>
    <style>
        .snap-facts-desc {
            width: 60%;
            margin: 0 auto 20px;
            text-align: center;
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
            width: 60%;
            font-family: "Maitree", serif;
            font-size: 18px;
            margin: 0 auto;
            color: white;
            text-align: justify;
        }

    </style>
</head>
<body>

<? require("./top-nav-bar.php") ?>

<div class="content-wrapper" style="padding-top: 60px; min-height: calc(100vh - 127px);">
    <div class="snap-facts-container">
        <p class="snap-facts-header">
            <p class="snap-facts-desc h1" style="color: white; margin-top: 100px; margin-bottom: 24px">Copyright</p>
            <p class="extra-activities-intro">© 2017 HARSHANI JAYASINGHE AND THE UNIVERSITY OF ADELAIDE
                ALL RIGHTS RESERVED [01/11/2017]
            </p>
            <br>
            <p class="extra-activities-intro">
                The contents of this website is protected by copyright law. Copyright in this material resides with the
                Commonwealth of Australia or various other rights holders, as indicated. Except as permitted by the copyright
                law applicable to you, you may not reproduce or communicate any of the content on the Smoking, Nicotine Adolescent
                Prevention Program (SNAP2 ) website, including files downloadable from this website, without the permission
                of the copyright owners.
            </p>
            <br>
            <p class="extra-activities-intro">
                This includes games, designs, images, interactive activities and content from the SNAP2  website.
            </p>
            <br>
            <p class="extra-activities-intro">
                The Australian Copyright Act allows certain uses of content from the internet without the copyright owner’s
                permission. This includes uses by educational institutions and by Commonwealth and State governments,
                provided fair compensation is paid. For more information,
                see <a href="www.copyright.com.au"><u>www.copyright.com.au</u></a> and <a href="www.copyright.org.au"><u>www.copyright.org.au</u></a>.
            </p>
            <br>
            <p class="extra-activities-intro">
                The owners of copyright in the content on this website may receive compensation for the use of their content
                by educational institutions and governments, including from licensing schemes managed by Copyright Agency.
            </p>
            <br>
            <p class="extra-activities-intro">
                We may change these terms of use from time to time. Check before re-using any content from this website.
            </p>
        <br>
        <hr>
        <br>
        <p class="extra-activities-intro">
            We have complied with the open source licenses for the 3rd-party open source packages that we use on this website
            and hence comply with their original copyrights and have not made any modifications to them.
        </p>
        <br>
        <p class="extra-activities-intro">
            Besides, we obey their open source licenses.
        </p>
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

