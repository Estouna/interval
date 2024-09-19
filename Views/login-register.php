<?php
include_once 'includes/head.php';
include_once 'includes/navbar.php';
?>


<div class="container d-flex flex-column justify-content-center align-items-center w-100 h-100">

    <!-- 
            -------------------------------------------------------- MESSAGES -------------------------------------------------------- 
        -->
    <?php if (!empty($_SESSION['erreur'])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php
            echo $_SESSION['erreur'];
            unset($_SESSION['erreur']);
            ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['success'])) : ?>
        <div class="alert alert-success text-center" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?= $content ?>

</div>

<?php include_once 'includes/footer.php'; ?>