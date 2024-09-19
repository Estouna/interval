<h2 class="text-primary text-center border-top border-primary py-3 my-5">Liste des catégories :</h2>

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

<div class="table-responsive table-sm mt-4">
    <table class="table table-dark table-striped">
        <thead>
            <tr class="bg-success">
                <th>Id_Categorie</th>
                <th>Nom</th>
                <th>Id_Parent</th>
                <th>Level</th>
                <th>Renommer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoriesList as $category) : ?>
                <tr>
                    <td class="py-2" colspan="1"><?= $category->id ?></td>
                    <td class="py-2" colspan="1"><?= $category->name ?></td>
                    <td class="py-2" colspan="1"><?= $category->parent_id ?></td>
                    <td class="py-2" colspan="1"><?= $category->level ?></td>
                    <td class="py-2" colspan="1"><a href="<?= BASE_PATH ?>admin/renommeCat/<?= $category->id ?>" class="btn btn-warning fT-Resp">Renommer</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>