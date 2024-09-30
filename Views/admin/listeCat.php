<h1 class="text-white bg-primary text-center mt-4 mb-5 p-2">Renommer les catégories</h1>

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
                <th class="p-2">Id_Categorie</th>
                <th class="p-2">Nom</th>
                <th class="p-2">Id_Parent</th>
                <th class="p-2">Level</th>
                <th class="p-2">Renommer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoriesList as $category) : ?>
                <tr>
                    <td class="p-2" colspan="1"><?= $category->id ?></td>
                    <td class="p-2 <?php if ($category->level == 0) : ?>text-primary<?php endif; ?>" colspan="1">
                        <?= $category->name ?>
                    </td>
                    <td class="p-2" colspan="1"><?= $category->parent_id ?></td>
                    <td class="p-2" colspan="1"><?= $category->level ?></td>
                    <td class="p-2" colspan="1"><a href="<?= BASE_PATH ?>admin/renommeCat/<?= $category->id ?>" class="btn btn-warning fT-Resp">Renommer</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>