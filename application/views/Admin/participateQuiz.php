<?php include 'includes/header.php'; ?>


<?php if (!empty($quiz)) : ?>
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

<!-- result modal -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="resultModalLabel">Quiz Results</h5>
            </div>
            <div class="modal-body">
                <p id="resultDetails"></p>
                <h3 id="resultScore"></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="continueButton">Continue</button>
            </div>
        </div>
    </div>
</div>

<?php $user_id =  $this->session->userdata('user_id'); ?>
<?php $user_id = (int)$user_id; ?>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

<script>
    $(document).ready(function() {

        $('#view_quiz').submit(function(e) {
            e.preventDefault();

            var quizData = {
                quiz_id: $('#quiz_id').val(),
                user_id: $('#user_id').val(),
                questions: []
            };

            $('.question-field .question').each(function() {
                var questionId = $(this).find('#question_id').val(); // Get question ID
                var questionText = $(this).find('h3').text().trim(); // Get question text

                var questionObj = {
                    question_id: questionId,
                    question_text: questionText,
                    answers: []
                };

                // Loop through each answer within the question
                $(this).find('.answers input[type="radio"]').each(function() {
                    var answerText = $(this).val();
                    var answerObj = {
                        answer_text: answerText,
                        is_selected: $(this).is(':checked')
                    };
                    questionObj.answers.push(answerObj);
                });

                quizData.questions.push(questionObj);
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('index.php/CheckQuiz/check_quizzes') ?>',
                data: JSON.stringify(quizData),
                contentType: 'application/json',
                success: function(data) {
                    // console.log(data);
                    var parsedData = JSON.parse(data);
                    var correctAnswers = parsedData.correct_answers;
                    var totalQuestions = parsedData.total_questions;
                    var user_id = parseInt(parsedData.user_id);
                    var quiz_id = parseInt(parsedData.quiz_id);

                    console.log(user_id, quiz_id, correctAnswers, totalQuestions);

                    var resultMessage = "You scored " + correctAnswers + " out of " + totalQuestions + " questions."
                    var resultScore = "You Scored " + ((correctAnswers / totalQuestions) * 100).toFixed(2) + "%";

                    $("#resultDetails").text(resultMessage);
                    $("#resultScore").text(resultScore);
                    $("#resultModal").modal('show');

                    $("#continueButton").click(function() {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url('index.php/CheckQuiz/save_quiz_marks') ?>',
                            data: JSON.stringify({
                                user_id: user_id,
                                quiz_id: quiz_id,
                                correct_answers: correctAnswers,
                                total_questions: totalQuestions,
                            }),
                            contentType: 'application/json',
                            success: function(data) {
                                console.log(data);
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                        $('#resultModal').modal('hide');
                        window.location.href = "<?php echo base_url('index.php/Admin/index'); ?>";
                    });

                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>