<?php include 'includes/header.php'; ?>

<?php if (!empty($profileData)) : ?>
    <!-- Container for displaying profile information -->
    <div class="profileContainer shadow p-3 mb-5 rounded">
        <div class="grid text-center">
            <!-- Profile image section -->
            <div class="g-col-md-10 text-center">
                <div class="col">
                    <!-- Profile image -->
                    <img src="<?php echo base_url('assets/images/profile.png'); ?>" alt="profile" class="profile-img rounded-circle">
                </div>
            </div>
            <!-- Profile name section -->
            <div class="g-col-md-10 text-center">
                <!-- Displaying profile full name -->
                <h1><?php echo $profileData['fname'] . " " .  $profileData['lname']; ?></h1>
            </div>
            <!-- Profile stats section -->
            <div class="g-col-md-10 row mt-5 mb-3">
                <!-- Created quizzes -->
                <div class="col-md-3 grid">
                    <div class="g-col-md-12 text-center"><span class="fs-2 text-primary"><?php echo $profileData['createdQuizzes']?></span></div>
                    <div class="g-col-md-12 text-center"><h3>Created</h3></div>
                </div>
                <!-- Participated quizzes -->
                <div class="col-md-3 grid">
                    <div class="g-col-md-12 text-center"><span class="fs-2 text-warning"><?php echo $profileData['participatedQuizzes']?></span></div>
                    <div class="g-col-md-12 text-center"><h3>Participated</h3></div>
                </div>
                <!-- Best marks -->
                <div class="col-md-3 grid">
                    <div class="g-col-md-12 text-center"><span class="fs-2 text-success"><?php echo $profileData['totalQuestions'] ? ((($profileData['max_mark']/$profileData['totalQuestions']) * 100) . "%") : "0.00%"?></span></div>
                    <div class="g-col-md-12 text-center"><h3>Best Marks</h3></div>
                </div>
                <!-- Average -->
                <div class="col-md-3 grid">
                    <div class="g-col-md-12 text-center"><span class="fs-2 text-info"><?php echo $profileData['participatedQuizzes']?></span></div>
                    <div class="g-col-md-12 text-center"><h3>Average</h3></div>
                </div>
            </div>
        </div>
    </div>

<?php else : ?>
    <!-- Message if no profile data found -->
    <p>No Quiz Data Found!</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
