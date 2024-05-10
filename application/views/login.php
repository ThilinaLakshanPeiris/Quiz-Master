<?php include 'templates/header.php' ?>

<div class="containerlogin shadow p-3 mb-5 bg-body-tertiary rounded ">
  <h2 class="text-center  ">Login</h2>
  <?php if ($this->session->flashdata('errmsg')) {
    echo "<h3>" . $this->session->flashdata('errmsg') . "</h3>";
  }
  ?>
  <hr>

  <?php echo validation_errors(); ?>
  <?php echo form_open('Login/LoginUser') ?>
  <div class="loginform ">
    <div class="mb-3">
      <label for="email" class="form-label mt-3">Email address</label>
      <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-primary d-grid gap-2 col-6 mx-auto">Submit</button>
  </div>
  <?php echo form_close() ?>

</div>

<?php include 'templates/footer.php' ?>