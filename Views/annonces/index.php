<!-- 
    -------------------------------------------------------- LISTE DES ANNONCES ACTIVES -------------------------------------------------------- 
-->
<h1 class="text-primary text-center my-5">Liste des annonces</h1>



<?php foreach ($annonces as $annonce) : ?>
    <?php foreach ($categories as $category) : ?>
        
        <?php if ($annonce->categories_id == $category->id) : ?>
            <article class="border border-primary my-4 p-2 rounded">
                <h3><a href="<?= BASE_PATH ?>annonces/lire/<?= $annonce->id ?>"><?= $annonce->titre . ' dans ' . $category->name ?></a></h3>
                <p>Par <?= $annonce->pseudo_author ?></p>
                <p>Date <?= $annonce->created_at ?></p>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endforeach; ?>