<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 10/12/2017
 * Time: 07:48 PM
 *
 * Require `$week` defined outside.
 */

// $week and $studentID should be pre-set
if (!isset($week) || !isset($studentID)) exit();

if (!isset($conn) || $conn == null)
    $conn = db_connect();

//get due time for this week
$dueTime = DateTime::createFromFormat('Y-m-d H:i:s', getStuWeekRecord($conn, $studentID, $week));
$currentTime = new DateTime();

?>
    <style>
        /**
         * count down timer
         **/
        .time-remain {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }
        .time-remain-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .time-remain-detail {
            margin: 20px 0 0 0;
        }
        .time-remain-item {
            width: 102px;
            height: 102px;
            border-radius: 50%;
            border: 2px solid #fff;
            margin: 0 30px;
            display: inline-block;
            font-size: 20px;
        }
        .time-remain-hour {
            border-color: #f4e62e;
        }
        .time-remain-minute {
            border-color: #af24d1;
        }
        .time-remain-second {
            border-color: #36e8c5;
        }
        .time-number {
            margin: 10px 0 0px 0;
        }

        .time-label {
            font-size: 20px;
        }
        .visually-hide {
            position: absolute;
            left: -9999em;
        }
        .countdown-container {
            position: relative;
        }
        .clock-item .inner {
            height: 0;
            padding-bottom: 100%;
            position: relative;
            width: 100%;
        }
        .clock-canvas {
            background-color: rgba(255, 255, 255, .1);
            border-radius: 50%;
            height: 0;
            padding-bottom: 100%;
        }
        .text {
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            margin-top: -50px;
            position: absolute;
            top: 50%;
            text-align: center;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
            width: 100%;
        }
        .text .val {
            font-size: 50px;
            line-height: 1;
            margin: 10px 0 10px 0;
        }
        .text .type-time {
            font-size: 20px;
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .clock-item {
                margin-bottom: 30px;
            }
        }
        @media (max-width: 767px) {
            .clock-item {
                margin: 0 30px 30px 30px;
            }
        }

        .clock-row {
            text-align: center;
        }
        .clock-item {
            display: inline-block;
            margin: 0 15px;
            width: 128px;
            height: 128px;
        }


    </style>
<div class="time-remain">
    <h2 class="time-remain-title">Please complete this week's quiz ASAP. Time remaining:</h2>
    <div class="countdown countdown-container ">
        <div class="clock clock-row">

            <!-- visually hide clock days -->
            <div class="clock-item visually-hide clock-days countdown-time-value">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-days" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-days type-time">DAYS</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->

            <div class="clock-item clock-hours countdown-time-value ">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-hours" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-hours type-time">HOURS</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->

            <div class="clock-item clock-minutes countdown-time-value ">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-minutes" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-minutes type-time">MINUTES</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->

            <div class="clock-item clock-seconds countdown-time-value">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-seconds" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-seconds type-time">SECONDS</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->
        </div><!-- /.clock -->
    </div><!-- /.countdown-wrapper -->
</div>

<script src="./js/vendor/jquery.final-countdown.min.js"></script>
<script src="./js/vendor/kinetic.js"></script>
<script src="./js/snap.js"></script>
<script>
    function setCounter(timeRemain) {
        console.log("total time: " + timeRemain);
        var timeNow = new Date();
        var timeDue = new Date();
        timeDue.setSeconds(timeDue.getSeconds() + timeRemain);

        if(timeRemain > 0) {
            $('.countdown').final_countdown({
                start: timeNow.getTime() / 1000,
                end: timeDue.getTime() / 1000,
                now: timeNow.getTime() / 1000
            }, function() {
                console.log("Time out.");
                snap.alert({
                    content: 'You\'re out of time! Your progress will be automatically submitted. After that, you will not be able to submit again.',
                    onClose: function () {
                        console.log('alert close')
                    }
                })
            });
        }
    }

<?php  if($dueTime != null) {
            $timeRemain = $dueTime->getTimestamp() - $currentTime->getTimestamp();
            echo "setCounter($timeRemain);";
        } else { ?>
            $.ajax({
                url: "save-due-time.php",
                data: {
                    student_id: <?php echo $studentID?>,
                    week: <?php echo $week?>
                },
                type: "POST",
                dataType : "json"
            })
                .done(function(feedback) {
                    parseNewTimerFeedback(feedback);
                })
                .fail(function( xhr, status, errorThrown ) {
                    alert( "Sorry, there was a problem on setting timer!" );
                    console.log( "Error: " + errorThrown );
                    console.log( "Status: " + status );
                    console.dir( xhr );
                });
<?php	} ?>

        function parseNewTimerFeedback(feedback) {
            if(feedback.message !== "success"){
                //alert(feedback.message + ". Please try again!");
                //jump to error page
                snap.alert({
                    content: feedback.message + '. Please try again!',
                    onClose: function () {
                        console.log('alert close')
                    }
                })
            } else {
                console.log(feedback);
                setCounter(feedback.time);
            }
        }
</script>
