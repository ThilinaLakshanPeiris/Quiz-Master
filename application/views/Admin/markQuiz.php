<?php include 'includes/header.php'; ?>


<?php if (!empty($questions)) : ?>
    <?php echo json_encode($questions); ?>

<?php else : ?>
    <p>No Quiz Data Found!</p>
<?php endif; ?>


<?php include 'includes/footer.php'; ?>