<?php
// Check if the user is logged in, if not, redirect to the login page
if (!($this->session->userdata('logedIn'))) {
	redirect(Home / Login);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quiz Master</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">

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

<!-- Hidden input field to store user ID -->
	<?php $user_id = $this->session->userdata('user_id'); ?>
	<?php $user_id = (int) $user_id; ?>

	<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

</head>

<body>
  <!-- Navigation bar -->
	<nav class="navbar navbar-expand-lg shadow">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo base_url('index.php/Admin/index'); ?>"> <img src="<?php echo base_url('assets/images/logo.jpg') ?>" alt="" height="45px" width="100%">
			</a>
			
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
				<ul class="navbar-nav justify-content-end me-2">
					<div class="d-flex gap-2 align-items-center justify-content-center">
						<div class="profilePic text-center">
							<a href="<?php echo base_url('index.php/LoadProfile/load_profile/') . $user_id ?>"><img class="rounded-circle" height="50px" width="50px" src="<?php echo base_url('assets/images/profile.png') ?>" alt="profile pic"></a>
						</div>
						<div>
							<div class="dropdown-center dropdown-menu-start">
								<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
								</button>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item text-center" href="<?php echo base_url('index.php/LoadProfile/load_profile/') . $user_id ?>">My Profile</a></li>
									<li><a class="dropdown-item text-center bg-danger text-light" href="<?php echo base_url('index.php/Login/LogoutUser') ?>">Logout</a></li>
								</ul>
							</div>
						</div>
					</div>
				</ul>
			</div>
		</div>
	</nav>