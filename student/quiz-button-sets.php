<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 2017/11/22
 * Time: 16:45
 *
 * The basic button set for quizzes.
 * This set does not contain the save buttons.
 */
?>

<ul class="task-operation">
    <li class="cancel-task">
        <a href="weekly-task.php?week=<?php echo $week?>" title="Cancel Task"></a>
    </li>
</ul>

<div class="attachment">
    <ul class="attachment-nav">
        <li id="facts-attach" class="attachment-nav-item">SNAP² <br>FACTS</li>
        <li id="pretask-attach" class="attachment-nav-item">PRE-TASK <br> MATERIALS</li>
    </ul>
</div>

<script src="./js/snap.js"></script>
<script>
    snap.initAttachmentCtrl();
</script>
