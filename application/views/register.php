<?php include('templates/header.php') ?> <!-- Including the header template -->

<div class="container shadow p-3 mb-5 bg-body-tertiary rounded mt-5" style="width: 500px;">
    <!-- Container with shadow, padding, margin, background color, and rounded corners -->
    <h2 class="mb-3 text-center text-primary">Register</h2> <!-- Heading for the registration section -->

    <!-- Display success message if any -->
    <?php if ($this->session->flashdata('msg')) {
        echo "<h5 class='text-success text-center mt-1'>" . $this->session->flashdata('msg') . "</h5>";
    }
    ?>

    <?php echo validation_errors(); ?> <!-- Display validation errors if any -->
    <?php echo form_open('Register/registerUser'); ?> <!-- Opening form with action 'Register/registerUser' -->
    <div class="row">
        <div class="col-md-6">
            <label for="fname" class="form-label">First Name</label> <!-- Label for first name input -->
            <input type="text" class="form-control" id="fname" name="fname"> <!-- First name input field -->
        </div>
        <div class="col-md-6">
            <label for="lname" class="form-label ">Last Name</label> <!-- Label for last name input -->
            <input type="text" class="form-control" id="lname" name="lname"> <!-- Last name input field -->
        </div>
        <div class="col-md-12 mt-3 mb-3">
            <label for="email" class="form-label ">Email</label> <!-- Label for email input -->
            <input type="email" class="form-control" id="email" name="email"> <!-- Email input field -->
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password</label> <!-- Label for password input -->
            <input type="password" class="form-control" id="password" name="password"> <!-- Password input field -->
        </div>
        <div class="col-md-6">
            <label for="conpassword" class="form-label ">Confirm Password</label> <!-- Label for confirm password input -->
            <input type="password" class="form-control" id="conpassword" name="conpassword"> <!-- Confirm password input field -->
        </div>
    </div>

    <div class="row justify-content-center"> <!-- Centering the button horizontally -->
        <button type="submit" class="btn btn-primary mb-3 mt-4 col-md-4 fs-5">Register</button>
        <!-- Submit button with increased width -->
    </div>

    <p class="text-center">Already have an account? <!-- Text for logging in if user already has an account -->
        <span><a href="<?php echo base_url('index.php/home/login'); ?>" class="text-decoration-none fs-5 ms-2">Login</a></span></p>

    <!-- </form> -->
    <?php echo form_close(); ?> <!-- Closing the form -->
</div>

<?php include('templates/footer.php') ?> <!-- Including the footer template -->
