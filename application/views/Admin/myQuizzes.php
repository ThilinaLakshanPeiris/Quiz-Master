<?php include 'includes/header.php'; ?>



<?php
if ($this->session->flashdata('welcome')) {
    echo "<h3>" . $this->session->flashdata('welcome') . "</h3>";
} ?>

<div id="quizList"></div>

<?php $user_id =  $this->session->userdata('user_id'); ?>
<?php $user_id = (int)$user_id; ?>

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
                        <div>
                        <h3>Quiz Title: ${quiz.quiz_title}</h3> 
                        <h4>Category: ${quiz.categoryText}</h4>
                        <a href="${quiz.quizId}">Info</a>
                        </div>
                        `
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        })
    })
</script>

<?php include 'includes/footer.php'; ?>