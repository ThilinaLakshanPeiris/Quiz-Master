<?php include 'includes/header.php'; ?>

<!-- Container to display participated quizzes and quizzes created by the user -->
<div class="container-fluid row justify-content-around" style="margin-top: 3%;">
    <!-- Container for participated quizzes -->
    <div id="participatedQuizListContainer" class="col-md-6">
        <div class="text-center">
            <h3>Participated Quizzes</h3>
        </div>
        <div id="participatedQuizList" class="">
            <!-- Spinner for loading participated quizzes -->
            <div class="spinner-grow text-secondary loadSpin" role="status" style="display:hidden;">
            </div>
        </div>
    </div>
    <!-- Container for quizzes created by the user -->
    <div id="myQuizListContainer" class="col-md-6">
        <div class="text-center">
            <h3>I Created Quizzes</h3>
        </div>
        <div id="myQuizList" class="">
            <!-- Spinner for loading user's quizzes -->
            <div class="spinner-grow text-secondary loadSpin" role="status" style="display:hidden;">
            </div>
        </div>
    </div>
</div>

<script>
    // Retrieve user ID from hidden input field
    var user_id = $('#user_id').val();

    // Flag to control initial load
    var load = true;

    $(document).ready(function() {

        // Load quizzes created by the user
        if (load) {
            $('.loadSpin').show(); // Show spinner while loading

            // AJAX request to load user's quizzes
            $.ajax({
                url: "<?php echo base_url('index.php/LoadQuiz/load_user_quizzes/'); ?>" + user_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var num = 1;
                    // Iterate through each quiz and display it
                    $.each(data, function(index, quiz) {
                        $('#myQuizList').append(
                            `
                            <!-- Display user's quizzes -->
                            <div id="quiz_${quiz.quizId}" class="row justify-content-around m-3 p-2 shadow rounded-pill">
                                <!-- Quiz information -->
                                <div class="col-md-7 row justify-content-around">
                                    <div class="col-md-1"><h5>${num}.</h5></div>
                                    <div class="col-md-11">
                                        <h5>Quiz Title: ${quiz.quiz_title}</h5> 
                                        <h6>Category: ${quiz.categoryText}</h6>
                                    </div>
                                </div>
                                <!-- Edit and delete options -->
                                <div class="col-md-5 row justify-content-end my-auto">
                                    <div class="col-md-3">
                                        <a class="text-decoration-none" href="<?php echo base_url('index.php/EditQuiz/edit_quiz_view/'); ?>${quiz.quizId}">Edit</a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="text-decoration-none delete-quiz" href="#" data-quiz-id="${quiz.quizId}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        `
                        );
                        num++;
                    });

                    $('.loadSpin').hide(); // Hide spinner after loading
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                    $('.loadSpin').hide(); // Hide spinner if error occurs
                }
            })
        }

        // Listen for delete action on quizzes
        $('#myQuizList').on('click', 'a.delete-quiz', function(e) {
            e.preventDefault();

            var quizId = $(this).data('quiz-id');

            // Confirmation before deleting quiz
            if (confirm("Are you sure you want to delete quiz")) {

                $('#quiz_' + quizId).remove(); // Remove quiz from UI

                deleteQuiz(quizId); // Call function to delete quiz from database
            }
        })

        // Load participated quizzes
        if (load) {
            $('.loadSpin').show(); // Show spinner while loading

            // AJAX request to load participated quizzes
            $.ajax({
                url: "<?php echo base_url('index.php/LoadQuiz/load_participated_quizzes/'); ?>" + user_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var num = 1;

                    // Iterate through each participated quiz and display it
                    $.each(data, function(index, quiz) {
                        $('#participatedQuizList').append(
                            `
                            <!-- Display participated quizzes -->
                            <div id="quiz_${quiz.quizId}" class="row justify-content-around m-3 p-2 shadow rounded-pill">
                                <!-- Quiz information -->
                                <div class="col-md-7 row justify-content-around">
                                    <div class="col-md-1"><h5>${num}.</h5></div>
                                    <div class="col-md-11">
                                        <h5>Quiz Title: ${quiz.quiz_title}</h5> 
                                        <h6>Category: ${quiz.categoryText}</h6>
                                    </div>
                                </div>
                                <!-- Marks and retake option -->
                                <div class="col-md-5 row justify-content-end my-auto">
                                    <div class="col-md-5">
                                        <h6>Marks: ${calculateMark(quiz.max_markValue, quiz.totalQuestions)}</h6>
                                    </div>
                                    <div class="col-md-5">
                                        <a class="text-decoration-none" href="<?php echo base_url('index.php/ViewQuiz/view_quizzes/'); ?>${quiz.quizId}">Retake</a>
                                    </div>
                                </div>
                            </div>
                        `
                        );
                        num++;
                    });

                    $('.loadSpin').hide(); // Hide spinner after loading
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                    $('.loadSpin').hide(); // Hide spinner if error occurs
                }
            })
        }

    })

    // Function to delete a quiz
    function deleteQuiz(quizId) {
        $.ajax({
            url: "<?php echo base_url('index.php/DeleteQuiz/delete_quiz/'); ?>" + quizId,
            type: "DELETE",
            dataType: "json",
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Function to calculate marks for a quiz
    function calculateMark(max, totalQuestions) {
        var resultScore = ((max / totalQuestions) * 100).toFixed(2) + "%";
        return resultScore;
    }
</script>

<?php include 'includes/footer.php'; ?>
