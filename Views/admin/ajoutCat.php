<h1 class="text-white bg-primary text-center mt-4 mb-5 p-2">Nouvelle catégorie</h1>

<!-- 
    -------------------------------------------------------- MESSAGES-------------------------------------------------------- 
-->
<?php if (!empty($_SESSION['erreur'])) : ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo $_SESSION['erreur'];
        unset($_SESSION['erreur']); ?>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-success text-center" role="alert">
        <?php echo $_SESSION['message'];
        unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>
<!-- 
    -------------------------------------------------------- FORMULAIRE AJOUT D'UNE CATEGORIE RACINE ET DE SA SOUS-CATEGORIE-------------------------------------------------------- 
-->
<form method="post" action="#" class="my-5">
    <label for="titre">Titre de la nouvelle catégorie</label>
    <input class="form-control" type="text" name="titre" required>

    <p class="text-center bg-info text-white border-info py-2 mt-5">Une nouvelle catégorie contient au minimum une sous-catégorie, vous pourrez en ajouter d'autres par la suite.</p>

    <label for="titre-sc">Titre de la sous-catégorie</label>
    <input class="form-control" type="text" name="titre-scRac" required>


    <button class="btn btn-primary my-4" type="submit" name="validateCateg">Ajouter</button>
</form>