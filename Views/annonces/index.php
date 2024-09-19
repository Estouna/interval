<!-- 
    -------------------------------------------------------- LISTE DES ANNONCES ACTIVES -------------------------------------------------------- 
-->
<h1 class="text-primary text-center my-5">Liste des annonces</h1>

<?php foreach ($annonces as $annonce) : ?>
    <article class="border border-primary my-4 p-2 rounded">
        <h2><a href="<?= BASE_PATH ?>annonces/lire/<?= $annonce->id ?>"><?= $annonce->titre ?></a></h2>
        <p>Par <?= $annonce->pseudo_author ?></p>
    </article>
<?php endforeach; ?>