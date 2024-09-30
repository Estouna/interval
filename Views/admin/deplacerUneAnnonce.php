<h1 class="text-center text-primary py-2 my-5 border-bottom border-primary">Article actuellement dans la catégorie <?= $categorie->name?></h1>

<!-- 
    -------------------------------------------------------- ARTICLE -------------------------------------------------------- 
-->
<div class="row justify-content-center">
    <article class="col-lg-4 col-md-4 col-sm-5 border border-primary m-1 rounded">
        <p><span class="text-primary"><?= $annonce->titre ?></span></br>Par <?= $annonce->pseudo_author ?></p>
    </article>
</div>

<p class="text-center bg-info text-white border-info py-2 mt-5">Choisissez la catégorie où vous souhaitez déplacer vos articles :</p>

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