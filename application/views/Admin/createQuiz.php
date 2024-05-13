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

<div id="quiz_preview_modal"></div>

<script>
    $(document).ready(function() {
        var questionNumber = 0; // Variable to keep track of the number of questions

        // Function to add a new question field dynamically
        function addQuestion() {
            questionNumber++; // Increment the question number
            var questionHtml = ` <!-- HTML template for a new question field -->
            <div class="question-field question_${questionNumber}">
                <label for="question" class="mb-2">Question ${questionNumber}:</label>
                <input type="text" id="question_${questionNumber}" class="form-control" name="question_${questionNumber}">
                <br>
                <label class="mb-2">Answers:</label>
                <div class="row">
                    <div class="col-md-3">
                        <label for="answer1_${questionNumber}" class="mb-2">Answer 1:</label>
                        <input type="text" id="answer1_text_${questionNumber}" class ="form-control"  name="answer1_text_${questionNumber}">
                        <input type="checkbox" id="answer1_${questionNumber}" name="answer1_${questionNumber}">
                    </div>
                    <div class="col-md-3">
                        <label for="answer2_${questionNumber}" class="mb-2">Answer 2:</label>
                        <input type="text" id="answer2_text_${questionNumber}" class ="form-control" name="answer2_text_${questionNumber}">
                        <input type="checkbox" id="answer2_${questionNumber}"  name="answer2_${questionNumber}">
                    </div>
                    <div class="col-md-3">
                        <label for="answer3_${questionNumber}" class="mb-2">Answer 3:</label>
                        <input type="text" id="answer3_text_${questionNumber}"  class ="form-control" name="answer3_text_${questionNumber}">
                        <input type="checkbox" id="answer3_${questionNumber}" name="answer3_${questionNumber}">
                    </div>
                    <div class="col-md-3">
                        <label for="answer4_${questionNumber}" class="mb-2">Answer 4:</label>
                        <input type="text" id="answer4_text_${questionNumber}" class ="form-control"  name="answer4_text_${questionNumber}">
                        <input type="checkbox" id="answer4_${questionNumber}"  name="answer4_${questionNumber}">
                    </div>
                </div>
                <br>
            </div>
        `;
            $('#question-container').append(questionHtml); // Append the new question field to the container
            if (questionNumber > 0) {
                $('#submit_btn').show(); // Show the submit button if at least one question is added
                $('#preview_quiz').show(); // Show the preview button if at least one question is added
            }
        }

        // Event listener for adding a new question
        $('#add_question').click(function() {
            addQuestion(); // Call the addQuestion function when the button is clicked
        });

        // Event listener for form submission
        $('#quiz_form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission behavior

            // Collect quiz data and prepare it for submission
            var quizData = createMainQuizObject();

            // Confirm submission
            if (confirm('Are you sure you want to create the quiz?')) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('index.php/CreateQuiz/submit_quiz') ?>', // URL to submit the quiz data
                    data: JSON.stringify(quizData), // Convert data to JSON format
                    contentType: 'application/json', // Set content type
                    success: function(response) {
                        alert("Quiz created successfully"); // Show success message
                        window.location.href = "<?php echo base_url('index.php/Admin/index') ?>"; // Redirect to the admin dashboard
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Log error message to the console
                    }
                });
            }
        });

        // Event listener for previewing the quiz
        $("#preview_quiz").click(function(event) {
            var quizData = createMainQuizObject(); // Collect quiz data
            var quiz_name = quizData.quiz_name;
            var quiz_category = quizData.quiz_category;
            var questions = quizData.questions;

            $("#quiz_preview_modal").empty(); // Clear previous content from the preview modal
            quiz_modal = preview_modal(quiz_name, quiz_category, questions); // Generate and display quiz preview modal
            $("#quiz_preview_modal #previewModal").modal('show'); // Show the preview modal
        });
    });

    // Function to create the main quiz object
    function createMainQuizObject() {
        // Initialize the quiz data object
        var quizData = {
            user_id: $('#user_id').val(), // Get the user ID
            quiz_name: $('#quiz_name').val(), // Get the quiz name
            quiz_category: $('#quiz_category option:selected').text(), // Get the selected quiz category
            questions: [] // Array to store questions
        };

        // Loop through each question field
        $('.question-field').each(function() {
            var questionText = $(this).find('input[type="text"]').first().val(); // Get the question text
            var questionObj = {
                question_text: questionText, // Add question text to the question object
                answers: [] // Array to store answers
            };

            // Loop through each answer field within the question
            $(this).find('input[type="text"]').not(':first').each(function(index) {
                var answerText = $(this).val(); // Get the answer text
                var answerCheckbox = $(this).siblings('input[type="checkbox"]').prop('checked'); // Check if the answer is correct
                var answerObj = {
                    answer_text: answerText, // Add answer text to the answer object
                    is_correct: answerCheckbox // Add answer correctness status to the answer object
                };
                questionObj.answers.push(answerObj); // Push answer object to the answers array
            });

            quizData.questions.push(questionObj); // Push question object to the questions array
        });

        return quizData; // Return the main quiz object
    }

    // Function to generate and display the quiz preview modal
    function preview_modal(quiz_name, quiz_category, questions) {
        var quiz_modal = ` <!-- HTML template for the preview modal -->
        <div id="previewModal" id="staticBackdrop" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <!-- Modal dialog -->
            <div class="modal-dialog modal-dialog-scrollable">
                <!-- Modal content -->
                <div class="modal-content">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- Quiz name -->
                        <h1 class="modal-title fs-3 text-center" id="staticBackdropLabel"><span class="text-warning">${quiz_name}</span></h1>
                        <!-- Quiz category -->
                        <h1 class="fs-4 text-center"><span class="text-warning">${quiz_category}</span></h1>
                        <!-- Container for quiz questions -->
                        <div id="quizQuestions"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <!-- Close button -->
                        <button type="button" class="btn btn-secondary text-center" data-bs-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
        `;

        $('#quiz_preview_modal').append(quiz_modal); // Append the preview modal to the container

        var $quizQuestions = $('#quizQuestions'); // Get the container for quiz questions
        // Loop through each question and generate HTML for preview
        questions.forEach(function(question, index) {
            var questionHTML = `
                <div class="mb-1">
                    <h4 class="">${index + 1}: ${question.question_text}</h4>
                    <div class="d-flex">
            `;
            // Loop through each answer and generate HTML for preview
            question.answers.forEach(function(answer, index) {
                questionHTML += `
                    <h6 class="text-primary">${index + 1}. ${answer.answer_text}</h6>
                `;
            });

            questionHTML += `
                    </div>
                </div>
            `;

            $quizQuestions.append(questionHTML); // Append question HTML to the container
        });
    }
</script>


<?php include 'includes/footer.php'; ?>