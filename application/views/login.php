<?php include('templates/header.php') ?> <!-- Including the header template -->

<div class="container shadow p-3 mb-5 bg-body-tertiary rounded mt-5" style="width: 500px;">
  <!-- Container with shadow, padding, margin, background color, and rounded corners -->
  <h2 class="mb-1 text-center text-primary">Login</h2> <!-- Heading for the login section -->

  <!-- Display error message if any -->
  <?php if ($this->session->flashdata('errmsg')) {
    echo "<h6 class='text-danger text-center mt-3'>" . $this->session->flashdata('errmsg') . "</h6>";
  }
  ?>

  <?php echo validation_errors(); ?> <!-- Display validation errors if any -->
  <?php echo form_open('Login/loginUser'); ?> <!-- Opening form with action 'Login/loginUser' -->

  <div class="row justify-content-center"> <!-- Centering form elements horizontally -->
    <div class="col-md-9 mt-2 mb-3">
      <label for="email" class="form-label ">Email</label> <!-- Label for email input -->
      <input type="email" class="form-control" id="email" name="email"> <!-- Email input field -->
    </div>
    <div class="col-md-9">
      <label for="password" class="form-label">Password</label> <!-- Label for password input -->
      <input type="password" class="form-control" id="password" name="password"> <!-- Password input field -->
    </div>
  </div>

  <div class="row justify-content-center"> <!-- Centering the button horizontally -->
    <button type="submit" class="btn btn-primary mb-4 mt-4 col-md-4 fs-5">Login</button>
    <!-- Submit button with increased width -->
  </div>

  <p class="text-center">Do not have an account? <!-- Text for registering if user doesn't have an account -->
    <span><a href="<?php echo base_url('index.php/home/register'); ?>" class="text-decoration-none fs-5 ms-2">Register</a></span></p>

  <?php echo form_close(); ?> <!-- Closing the form -->
</div>

<?php include('templates/footer.php') ?> <!-- Including the footer template -->
