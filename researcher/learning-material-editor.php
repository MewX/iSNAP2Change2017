<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['richContentTextArea'])) {
            $conn = db_connect();
            $content = $_POST['richContentTextArea'];
            $quizID = $_POST['quizID'];
            updateLearningMaterial($conn, $quizID, $content);
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    if (isset($_GET['quizID'])) {
        $quizID = $_GET['quizID'];
        $materialRes = getLearningMaterial($conn, $quizID);
        $phpSelf = $pageName . '.php?quizID=' . $quizID;
    }else if(isset($_GET['competitionID'])){
        $quizID = $_GET['competitionID'];
        $materialRes = getCompetition($conn, $quizID);
        $phpSelf = $pageName . '.php?competitionID=' . $quizID;
    }
} catch (Exception $e) {
    debug_err($e);
}

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap Core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.EditorManager.editors = []; //remove the old instances

        tinymce.init({
            selector: 'textarea',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | fontselect |  fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | emoticons link image media | preview | code',
            imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            image_advtab: true,
            browser_spellcheck: true,
            templates: [
                /**
                 * infograph list
                 * Add new infograph:
                 * 1.   put the file under /infograph
                 * 2.   {title: '[TITLE]', url: '../infograph/[FILENAME].html'}
                 * (remember to add comma after right bracket if needed to keep sane JSON format)
                 */
                {title: 'Infograph Demo', url: '../infograph/demo.html'},
                {title: 'Yet Another Demo', url: '../infograph/yet-another-demo.html'}
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ],
        });


    </script>
</head>
<body>
<form id="learningMaterial" method="post" action="<?php echo $phpSelf ?>" name="materialEditor">
    <label for="QuizID" style="display:none">QuizID</label>
    <input type="text" class="form-control" id="QuizID" name="quizID" style="display:none"
           value="<?php echo $quizID; ?>" required>
    <textarea id="materialContent" name="richContentTextArea">
        <?php echo $materialRes->Content; ?>
    </textarea>
    <input type="submit" name='submitbutton' value="Save" class='submit' hidden/> <span
        class="glyphicon glyphicon-info-sign"></span><b> Ctrl + S</b><br>
</form>

<?php
$quizType = getQuizType($conn, $quizID);
if ($quizType == "Video" || $quizType == "Image") { ?>
    <div class="alert alert-info">
        <p><strong>Reminder</strong> : This is <?php echo strtolower($quizType); ?> quiz. You should only insert one
            <?php echo strtolower($quizType); ?> by "Insert/edit <?php echo strtolower($quizType); ?>" button, other
            content is not expected.
    </div>
<?php }
db_close($conn);
?>
<?php require_once('sb-admin-lib.php'); ?>

<script>
//    $(document).ready(function () {
//        $("#learningMaterial :input").change(function () {
//            $("#learningMaterial").data("changed", true);
//        });
//    });
</script>

</body>
</html>