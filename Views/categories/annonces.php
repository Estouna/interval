
<!-- 
    -------------------------------------------------------- AFFICHAGE DES ANNONCES DE LA CATEGORIE -------------------------------------------------------- 
-->
<div class="text-center mt-5">
    <h1 class="text-primary">Annonces</h1>
</div>

<?php foreach ($annonces as $annonce) : ?>
    <article class="border border-primary my-4 p-2 rounded">
        <h2><a href="<?= BASE_PATH ?>annonces/lire/<?= $annonce->id ?>"><?= $annonce->titre ?></a></h2>
        <p>Par <?= $annonce->pseudo_author ?></p>
    </article>
<?php endforeach; ?>