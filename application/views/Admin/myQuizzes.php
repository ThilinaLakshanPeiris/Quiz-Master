<?php include 'includes/header.php';?>



<?php 
if ($this->session->flashdata('welcome')) {
    echo "<h3>" . $this->session->flashdata('welcome') . "</h3>";
}?>

 <h1><?php echo "My Quiz page " . $this->session->userdata('fname');?> </h1>


<?php include 'includes/footer.php'; ?>