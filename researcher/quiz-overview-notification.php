<div class="well row">
    <h4><?php echo $pageNameForView; ?> Overview Notification</h4>
    <div class="alert alert-info">
        <p>View quizzes by filtering or searching. You can create/update/delete any quiz.</p>
    </div>
    <div class="alert alert-info">
        <p>If you want to create a <b>survey quiz</b>, the best practice is to create an MCQ quiz.
            You can put survey link in the learning material, and set a question with only ONE answer.
            The survey quiz should have at least one mark.</p>
    </div>
    <?php include_once("quiz-overview-warning.php"); ?>
</div>