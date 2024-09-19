<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use App\Models\AnnoncesModel;

class CategoriesController extends Controller
{
    /* 
        -------------------------------------------------------- LISTE DES CATEGORIES --------------------------------------------------------
    */
    public function index()
    {
        $categoriesModel = new CategoriesModel;

        // Sélection des annonces actives
        $categories = $categoriesModel->findBy(['parent_id' => 0]);


        $subCat = $categoriesModel->findAll();



        // Sans compact(): $this->render('annonces/index', ['annonces' => $annonces]);
        $this->render('categories/index', compact('categories', 'subCat'));
    }

    /* 
        -------------------------------------------------------- LISTE DES SOUS-CATEGORIES --------------------------------------------------------
    */
    /**
     * Affiche les sous-catégories
     *
     * @param integer $parent_id
     * @return void
     */
    public function sous_categories(int $parent_id)
    {
        $categoriesModel = new CategoriesModel;

        $sub_categories = $categoriesModel->findBy(['parent_id' => $parent_id]);

        $this->render('categories/sous_categories', compact('sub_categories'));
    }

    /* 
        -------------------------------------------------------- ANNONCES DE L'UTILSATEUR --------------------------------------------------------
    */

    public function annonces(int $id_category)
    {
        $annoncesModel = new AnnoncesModel;

        $annonces = $annoncesModel->findBy(['actif' => 1, 'categories_id' => $id_category]);

        $this->render('categories/annonces', compact('annonces'));
    }

    /* 
        -------------------------------------------------------- ANNONCES DE L'UTILSATEUR --------------------------------------------------------
    */

    public function planCategories()
    {
        $categoriesModel = new CategoriesModel;

        $categories_racine = $categoriesModel->findBy(['level' => 0]);
        $sub_categoriesLv1 = $categoriesModel->findBy(['level' => 1]);
        $sub_categoriesLv2 = $categoriesModel->findBy(['level' => 2]);
        $sub_categoriesLv3 = $categoriesModel->findBy(['level' => 3]);
        $sub_categoriesLv4 = $categoriesModel->findBy(['level' => 4]);
        $sub_categoriesLv5 = $categoriesModel->findBy(['level' => 5]);

        $this->render('categories/planCategories', compact('categories_racine', 'sub_categoriesLv1', 'sub_categoriesLv2', 'sub_categoriesLv3', 'sub_categoriesLv4', 'sub_categoriesLv5'), 'plan');
    }
}
