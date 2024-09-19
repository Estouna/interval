<?php
include_once 'includes/head.php';
include_once 'includes/navbarAdmin.php';
?>

<div class="container">
    <?php if (!empty($_SESSION['erreur'])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo $_SESSION['erreur'];
            unset($_SESSION['erreur']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo $_SESSION['message'];
            unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>
    <?= $content ?>
</div>

<?php include_once 'includes/footer.php'; ?>