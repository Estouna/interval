<!-- 
    -------------------------------------------------------- AFFICHAGE D'UNE ANNONCE -------------------------------------------------------- 
-->
<article class="text-center mt-5">
    <h2 class="border border-primary text-primary py-3"><?= $annonce->titre ?></h2>
    <p>Par <?= $annonce->pseudo_author ?></p>
    <p>Le <?= $annonce->created_at ?></p>
    <p class="text-center mt-5"><?= $annonce->description ?></p>
</article>
