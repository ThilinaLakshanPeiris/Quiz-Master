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
        <option value="Category4">Category 4</option>
        <option value="Category5">Category 5</option>
        <option value="Category6">Category 6</option>
    </select>
    <br><br>
    <hr>
    <div id="question-container"></div>
    <button type="button" id="add_question">Add Question</button>
    <button type="button" id="preview_quiz">Preview</button>
    <input type="submit" id="submit_btn" value="Submit" style="display: none;">
</form>

<?php $user_id =  $this->session->userdata('user_id'); ?>
<?php $user_id = (int)$user_id; ?>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

<div id="quiz_preview_modal"></div>

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
            if (questionNumber > 0) {
                $('#submit_btn').show();
            }
        }

        // Event listener for adding question
        $('#add_question').click(function() {
            addQuestion();
        });

        // Event listener for form submission
        $('#quiz_form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var quizData = createMainQuizObject();

            // Send JSON data to server using AJAX
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('index.php/CreateQuiz/submit_quiz') ?>', // Change to your controller URL
                data: JSON.stringify(quizData),
                contentType: 'application/json',
                success: function(response) {
                    alert("Quiz created successfully");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $("#preview_quiz").click(function(event) {

            var quizData = createMainQuizObject();

            var quiz_name = quizData.quiz_name;
            var quiz_category = quizData.quiz_category;
            var questions = quizData.questions;

            $("#quiz_preview_modal").empty();

            quiz_modal = preview_modal(quiz_name, quiz_category, questions);

            // alert(JSON.stringify(quizData));
            $("#quiz_preview_modal #previewModal").modal('show');

        });

    });

    function createMainQuizObject() {

        // Create main object
        var quizData = {
            user_id: $('#user_id').val(),
            quiz_name: $('#quiz_name').val(),
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

        return quizData;
    }

    function preview_modal(quiz_name, quiz_category, questions) {

        var quiz_modal = `
        <div id="previewModal" id="staticBackdrop" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1 class="modal-title fs-3 text-center" id="staticBackdropLabel"><span class="text-warning">${quiz_name}</span></h1>
                        <h1 class="fs-4 text-center"><span class="text-warning">${quiz_category}</span></h1>
                        <div id="quizQuestions"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-center" data-bs-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
        `;

        $('#quiz_preview_modal').append(quiz_modal);

        var $quizQuestions = $('#quizQuestions');
        questions.forEach(function(question, index) {
            var questionHTML = `
                <div class="mb-1">
                    <h4 class="">${index + 1}: ${question.question_text}</h4>
                    <div class="d-flex">
            `;

            question.answers.forEach(function(answer, index) {
                questionHTML += `
                    <h6 class="text-primary">${index + 1}. ${answer.answer_text}</h6>
                `;
            });

            questionHTML += `
                    </div>
                </div>
            `;

            $quizQuestions.append(questionHTML);

        });

    }
</script>

<?php include 'includes/footer.php'; ?>