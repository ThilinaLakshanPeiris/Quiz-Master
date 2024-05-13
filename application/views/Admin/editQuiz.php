<?php include 'includes/header.php'; ?> <!-- Including the header template -->

<?php if (!empty($quiz)) : ?> <!-- Checking if the $quiz variable is not empty -->
    <div class="editQuizContainer shadow p-3 rounded-4"> <!-- Container for editing quiz -->
        <form action="#" method="post" id="quiz_form"> <!-- Form for updating quiz -->
            <div class="container-fluid row"> <!-- Row for quiz name and category -->
                <div class="col-md-6">
                    <label>Quiz Name: </label>
                    <input id="quiz_name" class="form-control mt-2" value="<?php echo $quiz[0]['quiz_title']; ?>">
                </div>
                <div class="col-md-6">
                    <label>Quiz Category: </label>
                    <select id="category" class="form-control mt-2" name="category">
                    </select>
                    <input type="hidden" id="category_text" value="<?php echo $quiz[0]['categoryText'] ?>">
                </div>
            </div>
            <input type="hidden" id="quiz_id" value="<?php echo $quiz[0]['quizId'] ?>"> <!-- Hidden input for quiz ID -->
            <div class="question-field container-fluid"> <!-- Container for questions -->
                <?php foreach ($quiz as $questionIndex => $question) : ?> <!-- Loop through each question -->
                    <div class="question mt-2"> <!-- Div for each question -->
                        <label class="mb-2">Question: <?php echo $questionIndex + 1; ?></label><br> <!-- Label for question number -->
                        <input type="text" class="form-control" value="<?php echo $question['question'] ?>"> <!-- Input for question -->
                        <input type="hidden" id="question_id" value="<?php echo $question['questionId'] ?>"> <!-- Hidden input for question ID -->
                        <div class="answers container-fluid row justify-content-center mt-3"> <!-- Container for answers -->
                            <?php foreach ($question['answers'] as $index => $answer) : ?> <!-- Loop through each answer -->
                                <div class="col-md-2 d-flex align-items-center"> <label>Answer: <?php echo $index + 1; ?></label></div> <!-- Label for answer number -->
                                <div class="col-md-8 d-flex align-items-center mt-1"> <input type="text" class="form-control" value="<?php echo $answer['answerText'] ?>" id="answer<?php echo $index + 1 ?>text<?php echo $questionIndex + 1 ?>" name="answer<?php echo $index + 1 ?>text<?php echo $questionIndex + 1 ?>"></div> <!-- Input for answer text -->
                                <div class="col-md-2 d-flex align-items-center"> <input id="answer<?php echo $index + 1 ?>_<?php echo $questionIndex + 1 ?>" type="checkbox" <?php echo $answer['correctAnswer'] == 1 ? 'checked' : '' ?>></div> <!-- Checkbox for correct answer -->
                                <input type="hidden" class="answer_id" value="<?php echo $answer['answerId'] ?>"> <!-- Hidden input for answer ID -->
                                <br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="d-flex justify-content-end mt-3 me-3"> <!-- Button group for form actions -->
                <button class="btn btn-primary me-3" type="submit" value="Submit">Submit</button> <!-- Submit button -->
                <button class="btn btn-danger me-3 ps-4 pe-4" id="exit_btn" value="Exit">Exit</button> <!-- Exit button -->
            </div>
        </form>
    </div>
<?php else : ?> <!-- If $quiz is empty -->
    <p>No Quiz Data Found!</p> <!-- Display message -->
<?php endif; ?>

<?php include 'includes/footer.php'; ?> <!-- Including the footer template -->


<script>
    $(document).ready(function() { // Wait for the document to be fully loaded
        loadCategories(); // Load categories when the document is ready

        $('#quiz_form').submit(function(event) { // Event listener for form submission
            event.preventDefault(); // Prevent default form submission

            var quizData = createMainQuizObject(); // Create quiz data object

            console.log(quizData); // Log quiz data object

            $.ajax({ // Send AJAX request to update quiz
                url: '<?php echo base_url('index.php/EditQuiz/update_quiz/') ?>' + quiz_id, // URL to update quiz
                type: 'PATCH', // HTTP method
                data: JSON.stringify(quizData), // Data to be sent (quizData)
                contentType: 'application/json', // Content type
                success: function(response) { // Success callback
                    alert(response); // Show success message
                    window.location.href = "<?php echo base_url('index.php/Admin/index') ?>"; // Redirect to admin page
                },
                error: function(xhr, status, error) { // Error callback
                    console.error(xhr.responseText); // Log error message
                }
            });

        });

        function loadCategories() { // Function to load categories via AJAX
            $.ajax({
                url: "<?php echo base_url('index.php/GetCategory/get_categories'); ?>", // URL to fetch categories
                type: 'GET', // HTTP method
                dataType: 'json', // Data type expected from the server
                success: function(data) { // Success callback
                    // Populate select element with categories
                    $.each(data, function(index, category) {
                        $('#category').append($('<option>', {
                            value: category.categoryId,
                            text: category.categoryText
                        }));
                    });

                    var initialCategory = $('#category_text').val();

                    console.log(initialCategory);

                    $('#category').val(function() { // Set selected category
                        return $(this).find('option').filter(function() {
                            return $(this).text() === initialCategory;
                        }).val();
                    })
                },
                error: function(xhr, status, error) { // Error callback
                    console.error(xhr.responseText); // Log error message
                }
            });
        }


        var quiz_id = $('#quiz_id').val(); // Get quiz ID from hidden input
        var user_id = $('#user_id').val(); // Get user ID from hidden input

        function createMainQuizObject() { // Function to create quiz data object
            var quizData = {
                user_id: user_id, // Assuming user_id is defined somewhere in your code
                quiz_name: $('#quiz_name').val(), // Get quiz name
                quiz_category: $('#category option:selected').text(), // Get selected category
                questions: []
            };

            $('.question').each(function() { // Loop through each question
                var questionField = $(this);
                var questionText = questionField.find('input[type="text"]').val(); // Get question text
                var questionId = questionField.find('input[type="hidden"]').val(); // Get question ID
                var questionObj = {
                    question_text: questionText, // Add question text to object
                    question_id: questionId, // Add question ID to object
                    answers: []
                };

                questionField.find('.answers input[type="text"]').each(function(answerIndex) { // Loop through each answer
                    var answerField = $(this);
                    var answerId = questionField.find('.answers .answer_id').eq(answerIndex).val(); // Retrieve answer ID
                    var answerText = answerField.val(); // Get answer text
                    var isCorrect = answerField.closest('.col-md-8').next('.col-md-2').find('input[type="checkbox"]').prop('checked'); // Check if answer is correct
                    var answerObj = {
                        answer_id: answerId, // Add answer ID to object
                        answer_text: answerText, // Add answer text to object
                        is_correct: isCorrect // Add correctness flag to object
                    };
                    questionObj.answers.push(answerObj); // Add answer object to question
                });

                quizData.questions.push(questionObj); // Add question object to quiz
            });

            return quizData; // Return quiz data object
        }

        $('#exit_btn').on('click', function(e) { // Event listener for exit button click
            e.preventDefault(); // Prevent default behavior

            window.location.href = "<?php echo base_url('index.php/Admin/index') ?>"; // Redirect to admin page
        });

    });
</script>
