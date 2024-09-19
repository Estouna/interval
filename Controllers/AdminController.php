<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Models\CategoriesModel;
use App\Core\Form;
use App\Models\UsersModel;

class AdminController extends Controller
{
    public function index()
    {
        // Vérifie si l'utilisateur est l'admin
        if ($this->isAdmin()) {
            $this->render('admin/index', [], 'admin');
        }
    }

    /* 
        -------------------------------------------------------- GESTION CATEGORIES --------------------------------------------------------
    */
    public function categories()
    {
        if ($this->isAdmin()) {

            $categoriesModel = new CategoriesModel;

            // Sélection des annonces actives
            $categoriesRacines = $categoriesModel->findBy(['parent_id' => 0]);

            // Sans compact(): $this->render('annonces/index', ['annonces' => $annonces]);
            $this->render('admin/categories', compact('categoriesRacines'), 'admin');
        }
    }

    /* 
        ------------- RENOMMER UNE CATEGORIE -------------
    */
    public function listeCat()
    {
        if ($this->isAdmin()) {

            $categoriesModel = new CategoriesModel;
            $categoriesList = $categoriesModel->findAll();

        }
        $this->render('admin/listeCat', compact('categoriesList'), 'admin');
    }

    public function renommeCat(int $id)
    {
        if ($this->isAdmin()) {

            $categoriesModel = new CategoriesModel;
            $category = $categoriesModel->find($id);

            if (Form::validate($_POST, ['name'])) {

                $name = Form::valid_donnees($_POST['name']);

                $renameCategory = new CategoriesModel;
                $renameCategory->setName($name);
                $renameCategory->update($id);


                $_SESSION['success'] = "La catégorie a bien été renommée";
                header('Location:' . BASE_PATH . 'admin/listeCat');
                exit;
            } else {
                $_SESSION['erreur'] = !empty($_POST) ? 'Vous devez choisir un nouveau nom avant de valider' : '';
            }

            $form = new Form;

            // Formulaire
            $form->debutForm()
                ->ajoutLabelFor('name', 'Nouveau nom pour ' . $category->name . ' :')
                ->ajoutInput('text', 'name', ['class' => 'form-control', 'required' => 'true'])
                ->ajoutBouton('Renommer', ['type' => 'submit', 'name' => 'validateName', 'class' => 'btn btn-primary mt-2'])
                ->finForm();
        }
        $this->render('admin/renommeCat', ['renameForm' => $form->create()], 'admin');
    }

    /* 
        ------------- AJOUT D'UNE NOUVELLE CATEGORIE RACINE ET SA SOUS-CATEGORIE -------------
    */
    public function ajoutCat()
    {
        if ($this->isAdmin()) {

            $sous_categories = new CategoriesModel;

            $parent_id_sc = $sous_categories->findCategoryId_Max();
            $lft_sc = $sous_categories->findLft_newSubCatRac();
            $rght_sc = $sous_categories->findRght_newSubCatRac();
            var_dump($parent_id_sc);
            var_dump($lft_sc);
            var_dump($rght_sc);

            // Vérifie que les champs existent et ne sont pas vides (à compléter)
            if (Form::validate($_POST, ['titre', 'titre-scRac'])) {

                $titre_cat = htmlspecialchars($_POST['titre']);
                $titre_sc_rac = htmlspecialchars($_POST['titre-scRac']);

                $categories = new CategoriesModel;
                // Récupère le bord droit le plus haut de la table des catégories
                $lft_cat = $categories->findLft_newCatRacine();
                $rght_cat = $categories->findRght_newCatRacineForOneSubCat();
                $parent_id_cat = 0;
                $level_cat = 0;

                // Hydrate la nouvelle catégorie
                $categories->setName($titre_cat)
                    ->setLft($lft_cat)
                    ->setRght($rght_cat)
                    ->setParent_id($parent_id_cat)
                    ->setLevel($level_cat);

                // Enregistre la catégorie dans la bdd
                $categories->create();


                $sous_categories = new CategoriesModel;

                $parent_id_sc = $sous_categories->findCategoryId_Max();
                $lft_sc = $sous_categories->findLft_newSubCatRac();
                $rght_sc = $sous_categories->findRght_newSubCatRac();
                $level_sc = 1;

                // Hydrate la nouvelle catégorie
                $sous_categories->setName($titre_sc_rac)
                    ->setLft($lft_sc)
                    ->setrght($rght_sc)
                    ->setParent_id($parent_id_sc)
                    ->setLevel($level_sc);

                // // Enregistre la catégorie dans la bdd
                $sous_categories->create();

                // On redirige avec un message
                $_SESSION['success'] = "Votre catégorie a bien été créée";
                header('Location:' . BASE_PATH . 'admin/categories');
                exit;
            } else {
                // Message de session
                $_SESSION['erreur'] = !empty($_POST) ? 'Vous devez donner un titre à la catégorie' : '';
            }
        }
        $this->render('admin/ajoutCat', [], 'admin');
    }

    /* 
        ------------- AJOUT D'UNE NOUVELLE SOUS-CATEGORIE -------------
    */
    public function ajoutSubCat(int $id)
    {
        if ($this->isAdmin()) {

            $categoriesModel = new CategoriesModel;
            $sub_categories = $categoriesModel->findSubCategoriesByParent_id($id);
            $categories = $categoriesModel->find($id);

            $annonces = new AnnoncesModel;
            $all_annonces = $annonces->findAll();
            $annoncesExist = $annonces->findAllByCategoryId($id);

            // Tableau avec les id des catégories existant dans la table annonces
            $idCat_annonces = [];
            foreach ($all_annonces as $ann) {
                array_push($idCat_annonces, $ann->categories_id);
            }
            $idCat_ann = array_unique($idCat_annonces);

            if (empty($annoncesExist)) {

                if (Form::validate($_POST, ['titre-sc'])) {


                    $titre_sc = htmlspecialchars($_POST['titre-sc']);

                    $sous_categories = new CategoriesModel;
                    
                    if ($categories->rght - $categories->lft >= 3) {
                        // Augmente les bords droit et gauche de + 2 à partir du bord droit le plus haut des enfants de la catégorie racine (insertion de la sous-catégorie sur la droite)
                        $update_rghtLft = $categoriesModel->update_rghtLft($id);
                        $lft = $sous_categories->findLft_newSubCat($id);
                        $rght = $sous_categories->findRght_newSubCat($id);
                    }
                    
                    if ($categories->rght - $categories->lft < 3) {
                        // Augmente les bords droit et gauche de + 2 à partir du bord droit de la catégorie parente
                        $update_forLeafTree = $categoriesModel->updateRghtLft_forLeafTree($id);
                        $lft = $sous_categories->findLft_newSubCat_leafTree($id);
                        $rght = $sous_categories->findRght_newSubCat_leafTree($id);
                    }
                    
                    $sc = $sous_categories->find($id);
                    $level = $sc->level + 1;
                    // Hydrate la nouvelle sous-catégorie
                    $sous_categories->setName($titre_sc)
                        ->setLft($lft[0])
                        ->setrght($rght[0])
                        ->setParent_id($categories->id)
                        ->setLevel($level);

                    // Enregistre la catégorie dans la bdd
                    $sous_categories->create();

                    $_SESSION['success'] = "Votre sous-catégorie a bien été créée";
                    header('Location:' . BASE_PATH . 'admin/categories');
                    exit;
                } else {
                    // Message de session
                    $_SESSION['erreur'] = !empty($_POST) ? 'Vous devez donner un titre à la sous-catégorie' : '';
                }
            } else {
                $_SESSION['erreur'] = 'Vous devez déplacer les articles de cette catégorie avant de pouvoir ajouter une sous-catégorie';
                header('Location:' . BASE_PATH . 'admin/categories');
                exit;
            }
        }

        $this->render('admin/ajoutSubCat', compact('sub_categories', 'categories', 'idCat_ann'), 'admin');
    }


    /* 
        -------------------------------------------------------- GESTION ANNONCES --------------------------------------------------------
    */
    /**
     * Affiche la liste des annonces
     * @return void
     */
    public function annonces()
    {
        if ($this->isAdmin()) {

            // Catégorie contenant des annonces à déplacer
            $categoriesModel = new CategoriesModel;
            $categories_origin = $categoriesModel->findLeaf_tree();

            // Liste des annonces à modifier
            $annoncesModel = new AnnoncesModel;
            $annonces = $annoncesModel->findAll();

            $this->render('admin/annonces', compact('annonces', 'categories_origin'), 'admin');
        }
    }

    /**
     * Supprime une annonce
     * @param integer $id
     * @return void
     */
    public function supprimeAnnonce(int $id)
    {
        if ($this->isAdmin()) {
            $annonce = new AnnoncesModel;

            $annonce->delete($id);

            header('Location:' . BASE_PATH . 'admin/annonces');
        }
    }

    /**
     * Active ou désactive une annonce
     *
     * @param integer $id
     * @return void
     */
    public function activeAnnonce(int $id)
    {
        if ($this->isAdmin()) {
            $annoncesModel = new AnnoncesModel;

            $annonceArray = $annoncesModel->find($id);

            if ($annonceArray) {
                $annonce = $annoncesModel->hydrate($annonceArray);

                $annonce->setActif($annonce->getActif() ? 0 : 1);

                $annonce->update($id);
            }
        }
    }

    /* 
        -------------------------------------------------------- DEPLACER LES ANNONCES D'UNE CATEGORIE --------------------------------------------------------
    */
    public function deplacerDesAnnonces(int $id)
    {
        if ($this->isAdmin()) {

            // Récupère les annonces de la catégorie
            $annoncesModel = new AnnoncesModel;
            // Annonces à déplacer
            $annonces_categorie = $annoncesModel->findby(['categories_id' => $id]);

            // Catégories cible pour les annonces à déplacer
            $categoriesModel = new CategoriesModel;
            // Pour afficher toutes les catégories cibles (au bout de l'arbre)
            $categories_cible = $categoriesModel->findLeaf_tree();
            // La catégorie où se trouve les annonces à déplacer
            $categorie =  $categoriesModel->find($id);


            if (!empty($annonces_categorie)) {

                if (Form::validate($_POST, ['categories'])) {
                    // Récupère l'id de la catégorie choisie
                    $id_cat_cible = intval($_POST['categories']);

                    $annoncesModif = new AnnoncesModel;
                    foreach ($annonces_categorie as $ac) {
                        $annoncesModif->setCategories_id($id_cat_cible);
                    }
                    $annoncesModif->updateAnnoncesCategoryId($id);

                    $_SESSION['success'] = "Les articles ont bien été déplacés";
                    header('Location:' . BASE_PATH . 'admin/annonces');
                    exit;
                } else {
                    $_SESSION['erreur'] = !empty($_POST) ? 'Vous devez choisir une catégorie avant de valider' : '';
                }
            } else {
                $_SESSION['erreur'] = 'Il n\'y a pas d\'annonces dans cette catégorie';
            }

            // Sans compact(): $this->render('annonces/index', ['annonces' => $annonces]);
            $this->render('admin/deplacerDesAnnonces', compact('categories_cible', 'annonces_categorie', 'categorie'), 'admin');
        }
    }
    /* 
        -------------------------------------------------------- DEPLACER UNE ANNONCE --------------------------------------------------------
    */
    public function deplacerUneAnnonce(int $id)
    {
        if ($this->isAdmin()) {

            // Récupère les annonces de la catégorie
            $annoncesModel = new AnnoncesModel;
            $annonce = $annoncesModel->find($id);

            // Catégories cible pour l'annonce à déplacer
            $categoriesModel = new CategoriesModel;
            // Pour afficher toutes les catégories cibles (au bout de l'arbre)
            $categories_cible = $categoriesModel->findLeaf_tree();
            $categorie = $categoriesModel->find($annonce->categories_id);




            if (Form::validate($_POST, ['categories'])) {

                $id_cat_cible = intval($_POST['categories']);

                $annoncesModif = new AnnoncesModel;

                $annoncesModif->setId($annonce->id)
                    ->setCategories_id($id_cat_cible);
                $annoncesModif->update($id);


                $_SESSION['success'] = "L'article a bien été déplacé";
                header('Location:' . BASE_PATH . 'admin/annonces');
                exit;
            } else {
                $_SESSION['erreur'] = !empty($_POST) ? 'Vous devez choisir une catégorie avant de valider' : '';
            }

            // Sans compact(): $this->render('annonces/index', ['annonces' => $annonces]);
            $this->render('admin/deplacerUneAnnonce', compact('categories_cible', 'annonce', 'categorie'), 'admin');
        }
    }


    /* 
        -------------------------------------------------------- GESTION UTILISATEURS --------------------------------------------------------
    */
    /**
     * Affiche la liste des utilisateurs
     * @return void
     */
    public function users()
    {
        if ($this->isAdmin()) {

            // Liste des utilisateurs
            $usersModel = new UsersModel;
            $users = $usersModel->requete("SELECT * FROM users WHERE id != 1")->fetchAll();

            $this->render('admin/users', compact('users'), 'admin');
        }
    }

    /**
     * Bannir un utilisateur
     * @param integer $id
     * @return void
     */
    public function deleteUser(int $id)
    {
        if ($this->isAdmin()) {
            
            $users = new UsersModel;
            $users->delete($id);

            header('Location:' . BASE_PATH . 'admin/users');
        }
    }

    /**
     * Méthode qui vérifie si on est administrateur
     * @return boolean
     */
    private function isAdmin()
    {
        // Vérifie si l'utilisateur est connecté et que son rôle est "ROLE_ADMIN"
        if (isset($_SESSION['user']['roles']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            // Si admin
            return true;
        } else {
            // Si pas admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location:' . BASE_PATH . 'users/login');
            exit;
        }
    }
}
