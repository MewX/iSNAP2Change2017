<!--Learning Material-->
<div class="panel panel-default">
    <div class="panel-heading">
        Learning Material Editor
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="height: 700px;">
        <div class="heading" style="color: black; max-height:10vh; text-align:center; border-bottom: 1px solid #eee;">
        </div>
        <iframe id="learning-material-editor" src="learning-material-editor.php?quizID=<?php echo $quizID; ?>"
                scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true"
                name="Learning Material Editor" title="Learning Material Editor"
                style="width: 100%; height:100%;"></iframe>
    </div>
    <!-- /.panel-body -->

    <div class="panel-footer">
        <h4><?php echo $pageNameForView; ?> Notification</h4>
        <div class="alert alert-info">
            <p>You need to click the save button to save your changes in the editor</p>
        </div>
        <div class="alert alert-info">
            <p>If you want to upload a picture on your computer to this editor, please:<br>
                1. Upload your picture to https://imgur.com/upload<br>
                2. Click get share link, copy the BBCode (Forums)<br>
                3. In our editor, click the image icon, paste this link in to Source text box.<br>
                4. Remove[img] and [/img/ before/after this link<br>
                5. click ok<br>
            </p>
        </div>
    </div>
</div>
<!-- /.panel -->