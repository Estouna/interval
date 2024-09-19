<h2 class="text-center text-primary py-2 my-5 border-bottom border-primary">Articles dans la catégorie <?= $categorie->name?></h2>

<!-- 
    -------------------------------------------------------- ARTICLES DANS LA CATEGORIE -------------------------------------------------------- 
-->
<div class="row justify-content-center">
<?php foreach ($annonces_categorie as $annonce) : ?>
    <article class="col-lg-4 col-md-4 col-sm-5 border border-primary m-1 rounded">
        <p><span class="text-primary"><?= $annonce->titre ?></span></br>Par <?= $annonce->pseudo_author ?></p>
    </article>
<?php endforeach; ?>
</div>

<p class="text-center bg-info text-white border-info py-2 mt-5">Choisissez la catégorie où vous souhaitez déplacer vos annonces (les annonces inactives sont aussi affichées):</p>

<!-- 
    -------------------------------------------------------- CATEGORIES CIBLES -------------------------------------------------------- 
-->
<form method="post" action="#" class="column justify-content-center p-1">
    <?php foreach ($categories_cible as $category) : ?>
        <div class="form-check form-check">
            <input class="form-check-input" type="radio" name="categories" id="inlineRadio" value="<?= $category->id ?>">
            <label class="form-check-label" for="inlineRadio"><?= $category->name ?></label>
        </div>
    <?php endforeach; ?>
    <button class="btn btn-primary my-4" type="submit" name="validateRadioCat">Valider</button>
</form>