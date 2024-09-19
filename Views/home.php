<?php
include_once 'includes/head.php';
include_once 'includes/navbar.php';
?>

<div class="container">

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
    <!-- 
                -------------------------------------------------------- CONTENU -------------------------------------------------------- 
        -->
    <?= $content ?>

    <!-- BOUTON LISTE ANNONCES-->
    <div class="text-center mt-5">
        <a href="<?= BASE_PATH ?>annonces" class="btn btn-primary">Voir la liste des annonces</a>
    </div>

</div>

<?php include_once 'includes/footer.php'; ?>