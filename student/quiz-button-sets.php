<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 2017/11/22
 * Time: 16:45
 */


?>

<ul class="task-operation">
    <li class="cancel-task">
        <a href="weekly-task.php?week=<?php echo $week?>" title="Cancel Task"></a>
    </li>
</ul>

<div id="facts-attachment" class="attachment">
    <ul class="attachment-nav">
        <li id="facts-attachment-item" class="attachment-nav-item">SNAP² <br>FACTS</li>
    </ul>
</div>
<div id="pretask-attachment" class="attachment" style="top: 180px">
    <ul class="attachment-nav">
        <li id="pretask-attachment-item" class="attachment-nav-item">Pre-task<br>Materials</li>
    </ul>
</div>

<script src="./js/snap.js"></script>
<script>
    snap.initAttachmentCtrl();
</script>
