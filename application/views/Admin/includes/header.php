<?php
if (!($this->session->userdata('logedIn'))) {
	redirect(Home / Login);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quiz</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dashboard.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/createQuiz.css'); ?>">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


	<script>
		$(document).ready(function() {
			$.ajax({
				url: "<?php echo base_url('index.php/GetCategory/get_categories'); ?>",
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					// Populate select element with categories
					$.each(data, function(index, category) {
						$('#quiz_category').append($('<option>', {
							value: category.categoryId,
							text: category.categoryText
						}));
					});
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		});
	</script>

</head>

<body>

	<nav class="navbar navbar-expand-lg shadow">
		<div class="container-fluid">
			<a class="navbar-brand" href="index">Quiz Master</a>
			<!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
				data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button> -->
			<div class="collapse navbar-collapse ms-5" id="navbarSupportedContent">

				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="<?php echo base_url('index.php/Admin/index'); ?>">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="<?php echo base_url('index.php/Admin/CreateQuiz'); ?>">Create_Quiz</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="<?php echo base_url('index.php/Admin/ParticipateQuiz'); ?>">Participate_Quiz</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="<?php echo base_url('index.php/Admin/MyQuizzes'); ?>">My_Quizzes</a>
					</li>
				</ul>
				<ul class="navbar-nav justify-content-end">
					<div class="me-3">
						<li>
							<h5><?php echo $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?></h5>
						</li>
					</div>

					<li>
						<a class="dropdown-item" href="<?php echo base_url('index.php/Login/LogoutUser') ?>">
							<button type="button" class="btn btn-primary">Logout</button>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>