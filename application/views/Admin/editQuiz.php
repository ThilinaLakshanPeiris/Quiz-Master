<?php include 'includes/header.php'; ?>


<?php if (!empty($quiz)) : ?>
    <form action="#" method="post" id="quiz_form">
        <h3>Quiz Name: </h3>
        <input id="quiz_name" class="fs-3" value="<?php echo $quiz[0]['quiz_title']; ?>">
        <h4>Quiz Category: </h4>
        <input type="hidden" id="category_text" value="<?php echo $quiz[0]['categoryText'] ?>">
        <select id="category" name="category">
        </select>
        <input type="hidden" id="quiz_id" value="<?php echo $quiz[0]['quizId'] ?>">
        <div class="question-field">
            <?php foreach ($quiz as $questionIndex => $question) : ?>
                <div class="question">
                    <h3>Question: <?php echo $questionIndex + 1; ?></h3>
                    <input type="text" value="<?php echo $question['question'] ?>">
                    <input type="hidden" id="question_id" value="<?php echo $question['questionId'] ?>">
                    <div class="answers">
                        <?php foreach ($question['answers'] as $index => $answers) : ?>
                            <label>Answer: <?php echo $index + 1; ?></label>
                            <input type="hidden" class="answer_id" value="<?php echo $answers['answerId'] ?>">
                            <input type="text" value="<?php echo $answers['answerText'] ?>" id="answer<?php echo $index + 1 ?>_text_<?php echo $questionIndex + 1 ?>" name="answer<?php echo $index + 1 ?>_text_<?php echo $questionIndex + 1 ?>">
                            <input id="answer<?php echo $index + 1 ?>_<?php echo $questionIndex + 1 ?>" type="checkbox" <?php echo $answers['correctAnswer'] == 1 ? 'checked' : '' ?>>
                            <br>
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

<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo base_url('index.php/GetCategory/get_categories'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Populate select element with categories
                $.each(data, function(index, category) {
                    $('#category').append($('<option>', {
                        value: category.categoryId,
                        text: category.categoryText
                    }));
                });

                var initialCategory = $('#category_text').val();

                console.log(initialCategory);

                $('#category').val(function() {
                    return $(this).find('option').filter(function() {
                        return $(this).text() === initialCategory;
                    }).val();
                })
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // $('#category').change(function() {
        //     var selectedCategoryId = $(this).val();
        // })

        var quiz_id = $('#quiz_id').val();
        var user_id = $('#user_id').val();

        function createMainQuizObject() {

            // Create main object
            var quizData = {
                user_id: $('#user_id').val(),
                quiz_name: $('#quiz_name').val(),
                quiz_category: $('#category option:selected').text(),
                questions: []
            };

            // Loop through each question field
            $('.question-field').each(function() {
                var questionField = $(this);
                questionField.find('.question').each(function() {
                    var questionText = $(this).find('input[type="text"]').first().val();
                    var questionId = $(this).find('input[type="hidden"]').first().val();
                    var questionObj = {
                        question_text: questionText,
                        question_id: questionId,
                        answers: []
                    };

                    // Loop through each answer field within the question
                    $(this).find('.answers').find('input[type="text"]').each(function(index) {
                        var $answerContainer = $(this).closest('.answers');
                        var answerId = $answerContainer.find('.answer_id').eq(index).val();
                        var answerText = $(this).val();
                        var answerCheckbox = $(this).next('input[type="checkbox"]').prop('checked');
                        var answerObj = {
                            answer_id: answerId,
                            answer_text: answerText,
                            is_correct: answerCheckbox
                        };
                        questionObj.answers.push(answerObj);
                    });

                    quizData.questions.push(questionObj);
                });
            });

            return quizData;
        }

        $('#quiz_form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var quizData = createMainQuizObject();

            // var quiz_name = quizData.quiz_name;
            // var quiz_category = quizData.quiz_category;
            // var questions = quizData.questions;

            // console.log(quiz_name);
            // console.log(quiz_category);
            // console.log(questions);

            $.ajax({
                url: '<?php echo base_url('index.php/EditQuiz/update_quiz/') ?>' + quiz_id,
                type: 'PATCH',
                data: JSON.stringify(quizData),
                contentType: 'application/json',
                success: function(response) {
                    alert(response);
                    window.location.href = "<?php echo base_url('index.php/Admin/index') ?>";
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });
    });
</script>

<?php include 'includes/footer.php'; ?>