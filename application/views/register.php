<?php include 'templates/header.php' ?>

<div class="containerregister shadow p-3 mb-5 bg-body-tertiary rounded ">
  <h2>Register</h2>
  <?php if ($this->session->flashdata('msg')) {
    echo "<h3>" . $this->session->flashdata('msg') . "</h3>";
  }
  ?>
  <hr>

  <?php echo validation_errors(); ?>
  <?php echo form_open('Register/RegisterUser') ?>
  <!-- <form> -->
  <div class="registerform">
    <div class= "row">
            <div class="mb-3 col ">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname">
            </div>

            <div class="mb-3 col ">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col ">
                <label for="phoneNo" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phoneNo" name="phoneNo">
            </div>

            <div class="mb-3 col ">
                <label class="profilepicture" for="inputGroupFile01">Profile Picture</label>
                <input type="file" class="form-control mt-2" id="inputGroupFile01">
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">

        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="conpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="conpassword" name="conpassword">
        </div>

        <div class=" mb-2 mx-4 text-center fw-light" for="exampleCheck1">Already have an Acoount? <a  class = "fw-semibold "href='<?php echo base_url('index.php/Home/login') ?>'>Log in</a></slabel>
        </div>
        <div class="sbutton ">
        <button type="submit" class="btn btn-primary  d-grid gap-2 col-6 mx-auto">Submit</button>
        </div>
</div>

  
  <!-- </form> -->

</div>
</div>

<?php echo form_close(); ?>

<?php include 'templates/footer.php' ?>