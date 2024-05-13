<?php include 'includes/header.php'; ?>


<?php if (!empty($quiz)) : ?>
    <div class="participateQuizContent shadow p-3 rounded-4">
        <form action="#" method="post" id="view_quiz">

            <div class="row">
                <div class="col-md-10">
                    <h3>Quiz Title: <?php echo $quiz[0]['quiz_title']; ?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <h3>Category: <?php echo $quiz[0]['categoryText'] ?>
                    </h3>
                </div>
            </div>
            <input type="hidden" id="quiz_id" value="<?php echo $quiz[0]['quizId'] ?>">
            <div class="question-field container-fluid">
                <?php foreach ($quiz as $index => $question) : ?>
                    <div class="question mt-2">
                        <h3><?php echo $index + 1 . ". " . $question['question'] ?></h3>
                        <input type="hidden" id="question_id" value="<?php echo $question['questionId'] ?>">
                        <div class="answers container-fluid row">
                            <?php foreach ($question['answers'] as $index => $answers) : ?>
                                <div class="col-md-10 mt-1">
                                    <input type="radio" class="ms-3 me-2" id="selected_answer_<?php echo $question['questionId'] ?>_<?php echo $index + 1; ?>" name="selected_answer[<?php echo $question['questionId'] ?>]" value="<?php echo $answers['answerText']; ?>">
                                    <label for="selected_answer_<?php echo $question['questionId'] ?>_<?php echo $index + 1; ?>"><?php echo $answers['answerText']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="d-flex justify-content-end mt-3 me-3">
                <button class="btn btn-primary me-3" type="submit" value="Submit">Submit</button>
                <button class="btn btn-danger me-3 ps-4 pe-4" id="exit_btn" value="Exit">Exit</button>
            </div>
        </form>
    </div>

<?php else : ?>
    <div class="emptyParticipationContainer shadow p-3 mb-5 rounded-3 grid">
        <div class="g-col-md-12 text-center">
            <h1>No Quiz Selected to participate!</h1>
            <h3>You can try following quizzes</h3>
        </div>
        <div class="g-col-md-12 container-fluid">
            <div id="secondaryQuizList">
                <div class="spinner-grow text-secondary loadSpin" role="status" style="display:hidden;">
                </div>
            </div>
        </div>
    </div>
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

<!-- rate modal -->
<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="resultModalLabel">Rate Now</h5>
            </div>
            <div class="modal-body text-center container-fluid row align-items-center">
                <div class="text-danger fs-3 col-md-2">Bad</div>
                <div class="btn-group rating-btn-group col-md-7 " role="group" aria-label="Horizontal radio toggle button group">
                    <input type="radio" class="btn-check" name="hbtn-radio" value="1" id="hbtn-radio1" autocomplete="off">
                    <label class="btn btn-outline-danger p-3 fs-3" for="hbtn-radio1">1</label>

                    <input type="radio" class="btn-check" name="hbtn-radio" value="2" id="hbtn-radio2" autocomplete="off">
                    <label class="btn p-3 fs-3" for="hbtn-radio2">2</label>

                    <input type="radio" class="btn-check" name="hbtn-radio" value="3" id="hbtn-radio3" autocomplete="off">
                    <label class="btn btn-outline-warning p-3 fs-3" for="hbtn-radio3">3</label>

                    <input type="radio" class="btn-check" name="hbtn-radio" value="4" id="hbtn-radio4" autocomplete="off">
                    <label class="btn p-3 fs-3" for="hbtn-radio4">4</label>

                    <input type="radio" class="btn-check" name="hbtn-radio" value="5" id="hbtn-radio5" autocomplete="off">
                    <label class="btn btn-outline-success p-3 fs-3" for="hbtn-radio5">5</label>
                </div>
                <div class="text-success fs-3 col-md-2">Excellent</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="okButton">OK</button>
            </div>
        </div>
    </div>
</div>

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
                                $('#resultModal').modal('hide');
                                rateQuiz(user_id, quiz_id);
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    });

                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function rateQuiz(user_id, quiz_id) {
            $("#rateModal").modal('show');

            $("#okButton").click(function() {
                // Get the value of the selected radio button
                var ratingValue = $("input[name='hbtn-radio']:checked").val();

                var ratingValue = parseInt(ratingValue);

                console.log(user_id);
                console.log(quiz_id);
                console.log(ratingValue);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('index.php/CheckQuiz/save_quiz_ratings') ?>',
                    data: JSON.stringify({
                        user_id: user_id,
                        quiz_id: quiz_id,
                        ratingValue: ratingValue
                    }),
                    contentType: 'application/json',
                    success: function(data) {
                        console.log(data);
                        window.location.href = "<?php echo base_url('index.php/Admin/index') ?>";
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
                $('#rateModal').modal('hide');
            });
        }

        $('#exit_btn').on('click', function(e) {
            e.preventDefault();

            window.location.href = "<?php echo base_url('index.php/Admin/index') ?>";
        });

        var load = true;

        if (load) {
            $('.loadSpin').show();

            $.ajax({
                url: "<?php echo base_url('index.php/LoadQuiz/load_quizzes'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var num = 1;
                    $.each(data, function(index, quiz) {
                        $('#secondaryQuizList').append(
                            `
                            <div id="quiz_${quiz.quizId}" class="row justify-content-around m-3 p-2 shadow rounded-pill">
                                <div class="col-md-7 row justify-content-around">
                                    <div class="col-md-1"><h5>${num}.</h5></div>
                                    <div class="col-md-11">
                                        <h5>Quiz Title: ${quiz.quiz_title}</h5> 
                                        <h6>Category: ${quiz.categoryText}</h6>
                                    </div>
                                </div>
                                <div class="col-md-5 row justify-content-end my-auto">
                                    <div class="col-md-6">
                                        <a class="text-decoration-none" href="<?php echo base_url('index.php/ViewQuiz/view_quizzes/'); ?>${quiz.quizId}">Take Quiz</a>
                                    </div>
                                </div>
                            </div>
                        `
                        );
                        num++;
                    });

                    $('.loadSpin').hide();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                    $('.loadSpin').hide();
                }
            })
        }
    });
</script>

<?php include 'includes/footer.php'; ?>