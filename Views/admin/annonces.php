<h1 class="text-white bg-primary text-center mt-4 mb-5 p-2">Gestion des annonces</h1>

<!-- 
    -------------------------------------------------------- MESSAGES -------------------------------------------------------- 
-->
<?php if (!empty($_SESSION['erreur'])) : ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php
        echo $_SESSION['erreur'];
        unset($_SESSION['erreur']);
        ?>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])) : ?>
    <div class="alert alert-success text-center" role="alert">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
    </div>
<?php endif; ?>

<h2 class="text-primary text-center py-3 my-5">Déplacer tous les articles d'une catégorie :</h2>
<p class="text-center bg-info text-white border-info py-2 px-1 mt-5">Choisissez la catégorie qui contient les articles que vous souhaitez déplacer :</p>

<div class="row justify-content-center p-1">
    <?php foreach ($categories_origin as $category) : ?>
        <div class="text-center border border-primary m-1 rounded col-lg-3 col-md-4 col-sm-5 rounded">
            <h3><a href="<?= BASE_PATH ?>admin/deplacerDesAnnonces/<?= $category->id ?>" class="fT-Resp"><?= $category->name ?></a></h3>
        </div>
    <?php endforeach; ?>
</div>

<h2 class="text-primary text-center border-top border-primary py-3 my-5">Gérer les articles individuellement :</h2>

<div class="table-responsive table-sm mt-5">
    <table class="table table-dark table-striped">
        <thead>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>ID_cat</th>
            <th>Actif</th>
        </thead>
        <tbody>
            <?php foreach ($annonces as $annonce) : ?>
                <tr>
                    <td><?= $annonce->id ?></td>
                    <td><?= $annonce->titre ?></td>
                    <td><?= $annonce->pseudo_author ?></td>
                    <td><?= $annonce->categories_id ?></td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch<?= $annonce->id ?>" <?= $annonce->actif ? 'checked' : '' ?> data-id="<?= $annonce->id ?>">
                            <label class="custom-control-label" for="customSwitch<?= $annonce->id ?>"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="py-2" colspan="5">
                        <div class="text-center">
                            <a href="<?= BASE_PATH ?>annonces/modifier/<?= $annonce->id ?>" class="btn btn-warning fT-Resp m-1 col-lg-2 col-md-3 col-sm-3">Modifier</a>
                            <a href="<?= BASE_PATH ?>admin/deplacerUneAnnonce/<?= $annonce->id ?>" class="btn btn-warning fT-Resp m-1 col-lg-2 col-md-3 col-sm-3">Déplacer dans</a>
                            <a href="<?= BASE_PATH ?>admin/supprimeAnnonce/<?= $annonce->id ?>" class="btn btn-danger fT-Resp m-1 col-lg-2 col-md-3 col-sm-3" onclick='return confirm(" Cette action est irréversible, êtes-vous sûr ? ")'>Supprimer</a>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>