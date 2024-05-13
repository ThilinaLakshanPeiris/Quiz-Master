<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta tags for character set and viewport -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Page title -->
  <title>Quiz Master</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">

  <!-- Bootstrap JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>

  <!-- Navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <div class="container-fluid">
      <!-- Brand logo or name with link -->
      <a class="navbar-brand" href="<?php echo base_url('index.php/Home/index'); ?>">
        <img src="<?php echo base_url('assets/images/logo.jpg') ?>" alt="" height="45px" width="100%">
      </a>
      <!-- Navbar toggler for mobile devices -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navbar items -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- Navbar items on the left side -->
          <!-- Add items here if needed -->
        </ul>
        <!-- Navbar items on the right side -->
        <ul class="navbar-nav justify-content-end">
          <!-- Register button -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('index.php/Home/register'); ?>"><button class="btn btn-success shadow-sm">Register</button></a>
          </li>
          <!-- Login button -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('index.php/Home/login'); ?>"><button class="btn btn-primary text-light shadow-sm">Login</button></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!-- Body content goes here -->

</body>

</html>
