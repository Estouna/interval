<h1 class="text-white bg-primary text-center mt-4 mb-5 p-2">Gestion des utilisateurs :</h1>

<div class="table-responsive table-sm mt-4">
    <table class="table table-dark table-striped">
        <thead>
            <th colspan="1">ID</th>
            <th colspan="1">Pseudo</th>
            <th colspan="1">Email</th>
            <th colspan="1">Rôle</th>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->pseudo ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->roles ?></td>
                </tr>
                <tr>
                    <td class="py-2" colspan="4">
                        <div class="text-center">
                            <a href="<?= BASE_PATH ?>admin/users/" class="btn btn-warning fT-Resp m-1 col-lg-2 col-md-3 col-sm-3">Rôle</a>
                            <a href="<?= BASE_PATH ?>admin/users/" class="btn btn-warning fT-Resp m-1 col-lg-2 col-md-3 col-sm-3">Email</a>
                            <a href="<?= BASE_PATH ?>admin/deleteUser/<?= $user->id ?>" class="btn btn-danger fT-Resp m-1 col-lg-2 col-md-3 col-sm-3" onclick='return confirm(" Cette action est irréversible, êtes-vous sûr ? ")'>Bannir</a>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>