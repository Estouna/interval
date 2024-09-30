<!-- 
    -------------------------------------------------------- PLAN DE L'ARBRE DES CATEGORIES JUSQU'AU LV 5 -------------------------------------------------------- 
-->
<h1 class="text-primary text-center mt-5">Plan de l'arbre des catégories jusqu'au niveau 5</h1>
<p class="text-primary text-center mb-5">(Représentation dynamique de la table des catégories)</p>

<div class="d-flex justify-content-center">
    <div class="row col-lg-12 p-0 justify-content-center">
        <!-- $categorieRacine = catégories avec level 0, $sub_categoriesLv1 = level 1, etc -->
        <?php foreach ($categories_racine as $c) : ?>
            <div class="text-center my-3 p-0 border border-white fT-Resp col-lg-4 rounded" style="background-color: black;">
                <div class="text-primary p-2 border border-dark bg-white">
                    <h2><?= $c->name ?></h2>
                    <p class="text-dark">Bg = <?= $c->lft ?> et Bd = <?= $c->rght ?> </br>Niveau = <?= $c->level ?></p>
                </div>
                <div class="d-flex flex-row justify-content-center p-2 my-1 col-lg-12 flex-wrap">
                    <?php foreach ($sub_categoriesLv1 as $sc1) : ?>
                        <?php if ($c->id === $sc1->parent_id) : ?>
                            <div class="d-flex flex-column p-2 mb-5 col-lg-6 col-md-6 col-sm-6">
                                <div class="text-white p-1 border-bottom border-white mt-2 rounded" style="background-color: MediumSeaGreen;">
                                    <h3><?= $sc1->name ?></h3>
                                    <p class="text-white m-1">Bg = <?= $sc1->lft ?> et Bd = <?= $sc1->rght ?> </br>Niveau = <?= $sc1->level ?></p>
                                </div>
                                <?php foreach ($sub_categoriesLv2 as $sc2) : ?>
                                    <?php if ($sc1->id === $sc2->parent_id) : ?>
                                        <div class="d-flex flex-column">
                                            <div class="text-white p-1 border-bottom border-white mx-1 mt-3" style="background-color: RebeccaPurple;">
                                                <h4><?= $sc2->name ?></h4>
                                                <p class="text-white m-1">Bg = <?= $sc2->lft ?> et Bd = <?= $sc2->rght ?> </br>Niveau = <?= $sc2->level ?></p>
                                            </div>
                                            <?php foreach ($sub_categoriesLv3 as $sc3) : ?>
                                                <?php if ($sc2->id === $sc3->parent_id) : ?>
                                                    <div class="text-white p-1 border-bottom border-white mx-1" style="background-color: SlateBlue;">
                                                        <h4><?= $sc3->name ?></h4>
                                                        <p class="text-white m-1">Bg = <?= $sc3->lft ?> et Bd = <?= $sc3->rght ?> </br>Niveau = <?= $sc3->level ?></p>
                                                    </div>
                                                    <?php foreach ($sub_categoriesLv4 as $sc4) : ?>
                                                        <?php if ($sc3->id === $sc4->parent_id) : ?>
                                                            <div class="text-white p-1 border-bottom border-white mx-1" style="background-color: MediumPurple;">
                                                                <h4><?= $sc4->name ?></h4>
                                                                <p class="text-white m-1">Bg = <?= $sc4->lft ?> et Bd = <?= $sc4->rght ?> </br>Niveau = <?= $sc4->level ?></p>
                                                            </div>
                                                            <?php foreach ($sub_categoriesLv5 as $sc5) : ?>
                                                                <?php if ($sc4->id === $sc5->parent_id) : ?>
                                                                    <div class="text-white p-1 border-bottom border-white mx-1" style="background-color: Plum;">
                                                                        <h4><?= $sc5->name ?></h4>
                                                                        <p class="text-white m-1">Bg = <?= $sc5->lft ?> et Bd = <?= $sc5->rght ?> </br>Niveau = <?= $sc5->level ?></p>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>

                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>