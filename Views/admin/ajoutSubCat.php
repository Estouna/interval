<h1 class="text-white bg-primary text-center mt-4 mb-5 p-2"><?= $categories->name ?></h1>

<!-- 
    -------------------------------------------------------- MESSAGES-------------------------------------------------------- 
-->
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
<!-- 
    -------------------------------------------------------- FORMULAIRE AJOUT D'UNE SOUS-CATEGORIE -------------------------------------------------------- 
-->
<form method="post" action="#" class="my-5">


    <label for="titre-sc">Titre de la sous-catégorie</label>
    <input class="form-control" type="text" name="titre-sc" required>


    <button class="btn btn-primary my-4" type="submit" name="validateSubCat">Ajouter</button>
</form>

<!-- 
    -------------------------------------------------------- LISTE DES SOUS-CATEGORIE DE LA CATEGORIE SELECTIONNEE-------------------------------------------------------- 
-->
<?php if (!empty($sub_categories)) : ?>
<h2 class="text-primary text-center border-top border-primary py-3 my-5">Sous-catégories de <?= $categories->name ?></h2>
<p class="text-center bg-info text-white border-info py-2 mt-5">Les catégories en rouge contiennent des articles, vous devrez les déplacer ou les supprimer avant de pouvoir ajouter une nouvelle sous-catégorie</p>
<?php endif; ?>

<?php foreach ($sub_categories as $sc) : ?>

    <!-- -->
    <?php if (!in_array($sc->id, $idCat_ann)) : ?>
        <div class="text-center border border-primary my-4 p-2 rounded">
            <h2><a href="<?= BASE_PATH ?>admin/ajoutSubCat/<?= $sc->id ?>"><?= $sc->name ?></a></h2>
        </div>
    <?php else : ?>
        <div class="text-center border border-primary my-4 p-2 rounded">
            <h2><a class="text-danger" href="<?= BASE_PATH ?>admin/ajoutSubCat/<?= $sc->id ?>"><?= $sc->name ?></a></h2>
        </div>
    <?php endif; ?>

<?php endforeach; ?>