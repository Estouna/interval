<!-- 
    -------------------------------------------------------- AFFICHAGE DES SOUS-CATEGORIES -------------------------------------------------------- 
-->
<div class="text-center my-5">
    <h1 class="text-primary">Sous-catégories</h1>
</div>

<div class="row justify-content-center">
    <?php foreach ($sub_categories as $sc) : ?>
        <div class="col-lg-4 col-md-4 col-sm-5 text-center border border-primary m-1 py-3 rounded">
            <?php if ($sc->rght - $sc->lft !== 1) { ?>
                <h2><a href="<?= BASE_PATH ?>categories/sous_categories/<?= $sc->id ?>"><?= $sc->name ?></a></h2>
            <?php } else { ?>
                <h2><a href="<?= BASE_PATH ?>categories/annonces/<?= $sc->id ?>"><?= $sc->name ?></a></h2>
            <?php } ?>
        </div>
    <?php endforeach; ?>
</div>