<?php include 'includes/header.php'; ?>


<div class="container-fluid row justify-content-around">
    <div class="col-md-6">
        
    </div>
    <div id="quizList" class="col-md-6"></div>
</div>

<?php $user_id = $this->session->userdata('user_id'); ?>
<?php $user_id = (int) $user_id; ?>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

<script>
    var user_id = $('#user_id').val();

    $(document).ready(function() {
        $.ajax({
            url: "<?php echo base_url('index.php/LoadQuiz/load_user_quizzes/'); ?>" + user_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, quiz) {
                    $('#quizList').append(
                        `
                            <div id="quiz_${quiz.quizId}" class="row justify-content-around shadow rounded-3">
                                <div class="col-md-6">
                                    <h5>Quiz Title: ${quiz.quiz_title}</h5> 
                                    <h6>Category: ${quiz.categoryText}</h6>
                                </div>
                                <div class="col-md-6 row justify-content-end my-auto">
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
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        })

        // Listening to delete action
        $('#quizList').on('click', 'a.delete-quiz', function(e) {
            e.preventDefault();

            var quizId = $(this).data('quiz-id');

            if (confirm("Are you sure you want to delete quiz")) {

                $('#quiz_' + quizId).remove();

                deleteQuiz(quizId);
            }
        })

    })

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
</script>

<?php include 'includes/footer.php'; ?>