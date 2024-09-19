<h1 class="text-white bg-primary text-center mt-4 mb-5 p-2">Gestion des catégories</h1>

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

<div class="text-center mt-5">
    <a href="<?= BASE_PATH ?>admin/listeCat" class="btn btn-primary">Renommer une catégorie</a>
</div>
<div class="text-center mt-5">
    <a href="<?= BASE_PATH ?>admin/ajoutCat" class="btn btn-primary">Ajouter une nouvelle catégorie</a>
</div>

<h2 class="text-primary text-center border-top border-primary py-3 my-5">Ajouter une sous-catégories dans :</h2>

<?php foreach ($categoriesRacines as $category) : ?>
    <div class="row justify-content-center p-1">
        <div class="text-center border border-primary my-2 p-1 rounded col-sm-5 col-md-4 col-lg-3">
            <h3><a href="<?= BASE_PATH ?>admin/ajoutSubCat/<?= $category->id ?>"><?= $category->name ?></a></h3>
        </div>
    </div>
<?php endforeach; ?>