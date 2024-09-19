<!-- 
    -------------------------------------------------------- CATEGORIES -------------------------------------------------------- 
-->
<h1 class="text-primary text-center my-5">Catégories</h1>

<div class="text-center mt-5">
    <a href="<?= BASE_PATH ?>categories/planCategories" class="btn btn-success">Plan de l'arbre des catégories</a>
</div>
<div class="row justify-content-center">
    <?php foreach ($categories as $category) : ?>

        <div class="col-lg-3 col-md-4 col-sm-5 text-center m-2 py-4">
            <div class="bg-primary text-white p-1">
                <h2><a class="text-white" href="<?= BASE_PATH ?>categories/sous_categories/<?= $category->id ?>"><?= $category->name ?></a></h2>
            </div>
            <?php foreach ($subCat as $sc) : ?>
                <?php if (isset($category->id) && $sc->parent_id === $category->id) : ?>

                    <?php if ($sc->rght - $sc->lft !== 1) { ?>
                        <div class="border border-top-none bg-light">
                            <p class="p-1 mt-1"><a href="<?= BASE_PATH ?>categories/sous_categories/<?= $sc->id ?>"><?= $sc->name ?></a></p>
                        </div>
                    <?php } else { ?>
                        <div class="border border-top-none bg-light">
                            <p class="p-1 mt-1"><a class="text-dark" href="<?= BASE_PATH ?>categories/annonces/<?= $sc->id ?>"><?= $sc->name ?></a></p>
                        </div>
                    <?php } ?>

                <?php endif; ?>

            <?php endforeach; ?>
        </div>

    <?php endforeach; ?>
</div>
