<?php include('templates/header.php') ?> <!-- Including the header template -->

<div class="container">
    <div class="row container">
        <div class="col-md-6">
            <!-- Grid layout for displaying text -->
            <div class="grid" style="--bs-gap: .25rem 1rem; margin-top:6.5rem;">
                <!-- Three lines of text with varying styles -->
                <div class="g-col-10 fw-semibold fs-1">Learn</div>
                <div class="g-col-10 fw-semibold fs-1">new concepts</div>
                <div class="g-col-10 fw-semibold fs-1 ">for each question</div>
            </div>
            <!-- Text content with a border and description -->
            <div class="d-flex justify-content-start mt-4">
                <div class="p-1 border-2 border-start border-secondary"></div>
                <div class="p-1 flex-grow-1 ms-2">We help you prepare for exams and quizzes</div>
            </div>
            <!-- Button for starting the process -->
            <div class="d-flex justify-content-start text-center mt-4">
                <div class="p-2">
                    <!-- Button redirects to the registration page -->
                    <button type="button" class="btn btn-outline-secondary fs-4 ps-5 pe-5 fw-semibold" onclick="window.location.href='<?php echo base_url('index.php/home/register') ?>'">Start</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Image displayed in the second column -->
            <img src="<?= base_url('assets/images/heroPic.jpg'); ?>" class="img-fluid p-3">
        </div>
    </div>
</div>
