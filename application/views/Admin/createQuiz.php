<!-- createQuiz.php -->
<?php include 'includes/header.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<form action="#" method="post" id="quiz_form">
    <label for="quiz_name">Quiz Name:</label>
    <input type="text" id="quiz_name" name="quiz_name" required>

    <label for="quiz_category">Quiz Category:</label>
    <select id="quiz_category" name="quiz_category">
        <option value="Category1">Category 1</option>
        <option value="Category2">Category 2</option>
        <option value="Category3">Category 3</option>
        <!-- Add more options as needed -->
    </select>
    <br><br>
    <hr>
    <div id="question-container"></div>
    <button type="button" id="add_question">Add Question</button>
    <input type="submit" value="Submit">
</form>

<?php $user_id =  $this->session->userdata('user_id'); ?>
<?php $user_id = (int)$user_id; ?>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

<script>
    $(document).ready(function() {
        var questionNumber = 0;

        // Function to add a new question field
        function addQuestion() {
            questionNumber++;
            var questionHtml = `
            <div class="question-field">
                <label for="question">Question ${questionNumber}:</label>
                <input type="text" id="question_${questionNumber}" name="question_${questionNumber}">
                <br>
                <label>Answers:</label>
                <div>
                    <label for="answer1_${questionNumber}">Answer 1:</label>
                    <input type="text" id="answer1_text_${questionNumber}" name="answer1_text_${questionNumber}">
                    <input type="checkbox" id="answer1_${questionNumber}" name="answer1_${questionNumber}">
                </div>
                <div>
                    <label for="answer2_${questionNumber}">Answer 2:</label>
                    <input type="text" id="answer2_text_${questionNumber}" name="answer2_text_${questionNumber}">
                    <input type="checkbox" id="answer2_${questionNumber}" name="answer2_${questionNumber}">
                </div>
                <div>
                    <label for="answer3_${questionNumber}">Answer 3:</label>
                    <input type="text" id="answer3_text_${questionNumber}" name="answer3_text_${questionNumber}">
                    <input type="checkbox" id="answer3_${questionNumber}" name="answer3_${questionNumber}">
                </div>
                <div>
                    <label for="answer4_${questionNumber}">Answer 4:</label>
                    <input type="text" id="answer4_text_${questionNumber}" name="answer4_text_${questionNumber}">
                    <input type="checkbox" id="answer4_${questionNumber}" name="answer4_${questionNumber}">
                </div>
                <br><hr>
            </div>
        `;
            $('#question-container').append(questionHtml);
        }

        // Event listener for adding question
        $('#add_question').click(function() {
            addQuestion();
        });

        // Event listener for form submission
        $('#quiz_form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Create main object
            var quizData = {
                quiz_name: $('#quiz_name').val(),
                user_id: $('#user_id').val(),
                quiz_category: $('#quiz_category').val(),
                questions: []
            };

            // Loop through each question field
            $('.question-field').each(function() {
                var questionText = $(this).find('input[type="text"]').first().val();
                var questionObj = {
                    question_text: questionText,
                    answers: []
                };

                // Loop through each answer field within the question
                $(this).find('input[type="text"]').not(':first').each(function(index) {
                    var answerText = $(this).val();
                    var answerCheckbox = $(this).siblings('input[type="checkbox"]').prop('checked');
                    var answerObj = {
                        answer_text: answerText,
                        is_correct: answerCheckbox
                    };
                    questionObj.answers.push(answerObj);
                });

                quizData.questions.push(questionObj);
            });

            // Send JSON data to server using AJAX
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('index.php/CreateQuiz/submit_quiz') ?>', // Change to your controller URL
                data: JSON.stringify(quizData),
                contentType: 'application/json',
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        });

    });
</script>

<?php include 'includes/footer.php'; ?>
