<!-- createQuiz.php -->
<?php include 'includes/header.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="addquecontent shadow p-3 mb-5 rounded">

    <form action="#" method="post" id="quiz_form">
        <div class="row">
            <div class="col-md-6">
                <label for="quiz_name" class="mb-2">Quiz Name:</label>
                <input type="text" class="form-control" id="quiz_name" name="quiz_name" required>
            </div>
            <div class="col-md-6">
                <label for="quiz_category" class="mb-2">Quiz Category:</label>
                <select id="quiz_category" class="form-control" name="quiz_category">
                </select>
            </div>
            <br><br>
            <div id="question-container" class="mt-3"></div>
            <div class="row">
                <div class="col-md-8 mt-1"><button type="button" class="btn btn-outline-dark" id="add_question">Add
                        Question</button></div>
                <div class="col-md-2 mt-2"><button type="button" class="btn btn-outline-dark" id="preview_quiz" style="display: none;">Preview</button></div>
                <div class="col-md-2 mt-2"><input type="submit" class="btn btn-outline-dark" id="submit_btn" value="Publish" style="display: none;"></div>
            </div>

        </div>
    </form>
</div>

<?php $user_id = $this->session->userdata('user_id'); ?>
<?php $user_id = (int) $user_id; ?>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

<div id="quiz_preview_modal"></div>

<script>
    $(document).ready(function() {
        var questionNumber = 0;

        // Function to add a new question field
        function addQuestion() {
            questionNumber++;
            var questionHtml = `
            <div class="question-field question_${questionNumber}">
            <hr>
                <label for="question" class="mb-2">Question ${questionNumber}:</label>
                <input type="text" id="question_${questionNumber}" class="form-control" name="question_${questionNumber}">
                <br>
                <label class="mb-2">Answers:</label>
                <div class="row">
                    <div class="col-md-3">
                        <label for="answer1_${questionNumber}" class="mb-2">Answer 1:</label>
                        <input type="text" id="answer1_text_${questionNumber}" class ="form-control"  name="answer1_text_${questionNumber}">
                        <input type="checkbox" id="answer1_${questionNumber}" name="answer1_${questionNumber}">
                        <label class="form-check-label fs-6 fw-light" for="flexCheckDefault">
                            Correct Answer
                        </label><br>
                    </div>
                    <div class="col-md-3">
                        <label for="answer2_${questionNumber}" class="mb-2">Answer 2:</label>
                        <input type="text" id="answer2_text_${questionNumber}" class ="form-control" name="answer2_text_${questionNumber}">
                        <input type="checkbox" id="answer2_${questionNumber}"  name="answer2_${questionNumber}">
                        <label class="form-check-label fs-6 fw-light" for="flexCheckDefault">
                            Correct Answer
                        </label><br>
                    </div>
                    <div class="col-md-3">
                        <label for="answer3_${questionNumber}" class="mb-2">Answer 3:</label>
                        <input type="text" id="answer3_text_${questionNumber}"  class ="form-control" name="answer3_text_${questionNumber}">
                        <input type="checkbox" id="answer3_${questionNumber}" name="answer3_${questionNumber}">
                        <label class="form-check-label fs-6 fw-light" for="flexCheckDefault">
                            Correct Answer
                        </label><br>
                    </div>
                    <div class="col-md-3">
                        <label for="answer4_${questionNumber}" class="mb-2">Answer 4:</label>
                        <input type="text" id="answer4_text_${questionNumber}" class ="form-control"  name="answer4_text_${questionNumber}">
                        <input type="checkbox" id="answer4_${questionNumber}"  name="answer4_${questionNumber}">
                        <label class="form-check-label fs-6 fw-light" for="flexCheckDefault">
                            Correct Answer
                        </label><br>
                    </div>
                </div>
                <br>
                <hr>
            </div>
        `;
            $('#question-container').append(questionHtml);
            if (questionNumber > 0) {
                $('#submit_btn').show();
                $('#preview_quiz').show();
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

            if (confirm('Are you sure you want to create the quiz?')) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('index.php/CreateQuiz/submit_quiz') ?>',
                    data: JSON.stringify(quizData),
                    contentType: 'application/json',
                    success: function(response) {
                        alert("Quiz created successfully");
                        window.location.href = "<?php echo base_url('index.php/Admin/index') ?>";
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });

        $("#preview_quiz").click(function(event) {

            var quizData = createMainQuizObject();

            var quiz_name = quizData.quiz_name;
            var quiz_category = quizData.quiz_category;
            var questions = quizData.questions;

            console.log(quiz_category);

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
            quiz_category: $('#quiz_category option:selected').text(),
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