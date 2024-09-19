<h1 class="text-primary text-center my-5">Mon profil</h1>

<h2 class="text-center mt-5">Publier un article dans :</h2>

<!-- 
    -------------------------------------------------------- LISTE DES CATEGORIES EN BOUT D'ARBRE -------------------------------------------------------- 
-->
<div class="row justify-content-center">
    <!-- $categorieRacine = catégories avec level 0 -->
    <?php foreach ($categoriesRacine as $c) : ?>
        <div class="col-lg-3 col-md-4 col-sm-5 text-center m-2 py-4">
            <div class="bg-primary text-white p-1">
                <h2><?= $c->name ?></h2>
            </div>
            <!-- $categorie = sous-catégories en bout d'arbre (rght - lft = 1) -->
            <?php foreach ($categories as $sc) : ?>

                <!-- Si la sous-catégorie se trouve entre le bord gauche et le bord droit de la catégorie racine -->
                <?php if (isset($c->id) && $c->lft < $sc->lft && $c->rght > $sc->rght) : ?>

                    <div class="border border-top-none bg-light">
                        <p class="p-1 mt-1"><a href="<?= BASE_PATH ?>annonces/ajouter/<?= $sc->id ?>"><?= $sc->name ?></a></p>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- 
    -------------------------------------------------------- BOUTON VOIR MES ANNONCES -------------------------------------------------------- 
-->
<div class="mt-5">
    <a href="<?= BASE_PATH ?>users/annonces" class="btn btn-primary btn-sm btn-block">Voir mes annonces</a>
</div>