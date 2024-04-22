<?php include 'includes/header.php'; ?>

<?php
if ($this->session->flashdata('welcome')) {
    echo "<h3>" . $this->session->flashdata('welcome') . "</h3>";
} ?>

<h1><?php echo "Welcome " . $this->session->userdata('fname'); ?> </h1>

<form action="" method="get">
    <label for="quiz_name">Quiz Name:</label>
    <input type="text" id="quiz_name" name="quiz_name">

    <label for="category">Category:</label>
    <select id="category" name="category">
        <option value="category1">Category 1</option>
        <option value="category2">Category 2</option>
        <option value="category3">Category 3</option>
        <option value="category1">Category 4</option>
        <option value="category2">Category 5</option>
        <option value="category3">Category 6</option>

    </select>

    <input type="submit" value="Search">
</form>

<div id="quizList"></div>

<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo base_url('index.php/LoadQuiz/load_quizzes'); ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Handle the response data here
                console.log(data); // Output the fetched quizzes to the console
                // Example: Loop through the quizzes and display them on the webpage
                $.each(data, function(index, quiz) {
                    $('#quizList').append(
                        `
                        <div>
                        <h3>Quiz Title: ${quiz.quiz_title}</h3> 
                        <h4>Category: ${quiz.categoryText}</h4>
                        <a href="<?php echo base_url('index.php/ViewQuiz/view_quizzes/');?>${quiz.quizId}">Take Quiz</a>
                        </div>
                        `
                    );
                });
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        })
    });
</script>