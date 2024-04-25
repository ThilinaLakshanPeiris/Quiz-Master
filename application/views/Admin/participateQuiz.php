<?php include 'includes/header.php'; ?>


<?php if (!empty($quiz)) : ?>
    <?php echo json_encode($quiz)?>

    <form action="#" method="post" id="view_quiz">
        <h2><?php echo $quiz[0]['quiz_title']; ?></h2>
        <h4><?php echo $quiz[0]['categoryText'] ?></h4>
        <input type="hidden" id="quiz_id" value="<?php echo $quiz[0]['quizId'] ?>">
        <div class="question-field">
            <?php foreach ($quiz as $question) : ?>
                <div class="question">
                    <h3><?php echo $question['question'] ?></h3>
                    <input type="hidden" id="question_id" value="<?php echo $question['questionId'] ?>">
                    <div class="answers">
                        <?php foreach ($question['answers'] as $answers) : ?>
                            <input type="radio" name="selected_answer[<?php echo $question['questionId'] ?>]" value="<?php echo $answers['answerText']; ?>">
                            <label><?php echo $answers['answerText']; ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" value="Submit">Submit</button>
    </form>


<?php else : ?>
    <p>No Quiz Data Found!</p>
<?php endif; ?>


<?php $user_id =  $this->session->userdata('user_id'); ?>
<?php $user_id = (int)$user_id; ?>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

<?php include 'includes/footer.php'; ?>

