
<?php include 'includes/header.php';?>

<?php 
if ($this->session->flashdata('welcome')) {
    echo "<h3>" . $this->session->flashdata('welcome') . "</h3>";
}?>

<h1><?php echo "Welcome " . $this->session->userdata('fname');?> </h1>

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

<?php include 'includes/footer.php'; ?>
