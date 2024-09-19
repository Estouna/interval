<?php

namespace App\Models;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;

class CategoriesModel extends Model
{
    protected $id;
    protected $name;
    protected $lft;
    protected $rght;
    protected $parent_id;
    protected $level;


    /* 
        -------------------------------------------------------- CONSTRUCTEUR --------------------------------------------------------
    */


    public function __construct()
    {
        $this->table = 'categories_interval';
    }

    /* 
       ----------  TROUVER LES CATEGORIES AU BOUT DE L'ARBRE (les feuilles) ----------
    */
    public function findLeaf_tree()
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE rght - lft = 1")->fetchAll();
    }

    /* 
       ----------  TROUVER LES SOUS-CATEGORIES D'UNE CATEGORIE ----------
    */
    public function findSubCategoriesByParent_id($parent_id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE parent_id = $parent_id")->fetchAll();
    }

    /* 
        -------------------------------------------------------- AJOUT D'UNE NOUVELLE CATEGORIE RACINE ET DE SA SOUS-CATEGORIE --------------------------------------------------------
    */


    /*
        A FAIRE !!!!!!!!!!!!!!!!!!! Résumer: ajouter un alias à la requête pour récupérer la valeur de la colonne et la renvoyer.
        XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
        return $this->requete("SELECT MAX(rght + 1) AS lft_catRac FROM {$this->table}")->fetch();

        Modifier toutes les requêtes de cette manière et ensuite "$lft_cat->lft_catRac" pour la récupérer.
        Si cela fonctionne mais erreur soulignée (écrase le model) laisser fetchAll et récupérer comme ceci "$lft_cat[]->lft_catRac" il n'y aura plus d'erreur.
        Pour virer
        $rght_desc = $this->requete("SELECT MAX(rght + 1) FROM {$this->table}")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($rght_desc));
        $lft_cat = iterator_to_array($it, false);
        return $lft_cat;
        XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    */
    /* 
        ---------- BORD DROIT DE LA NOUVELLE CATEGORIE RACINE ----------
    */
    public function findLft_newCatRacine()
    {
        $newLft_catRac = $this->requete("SELECT MAX(rght + 1) AS lft_catRac FROM {$this->table}")->fetch();
        $newLft_catRac = $newLft_catRac->lft_catRac;
        return $newLft_catRac;
    }

    /* 
    ---------- BORD GAUCHE DE LA NOUVELLE CATEGORIE RACINE ----------
    */
    public function findRght_newCatRacineForOneSubCat()
    {
        $newRght_catRac = $this->requete("SELECT MAX(rght + 4) AS rght_catRac FROM {$this->table}")->fetch();
        $newRght_catRac = $newRght_catRac->rght_catRac;
        return $newRght_catRac;
    }

    /* 
       ----------  TROUVER L'ID LE PLUS HAUT DE LA TABLE DES CATEGORIES ----------
    */
    public function findCategoryId_Max()
    {

        $cat_idMax = $this->requete("SELECT id AS id_max FROM {$this->table} ORDER BY id DESC")->fetch();
        $cat_idMax = $cat_idMax->id_max;
        return $cat_idMax;
    }

    /* 
       ---------- BORD GAUCHE DE LA SOUS-CATEGORIE DE LA NOUVELLE CATEGORIE RACINE ----------
    */
    public function findLft_newSubCatRac()
    {
        $lft_catRacine = $this->requete("SELECT MAX(lft + 1) AS lft FROM {$this->table}")->fetch();
        $lft_catRacine = $lft_catRacine->lft;
        return $lft_catRacine;
    }

    /* 
       ---------- BORD DROIT DE LA SOUS-CATEGORIE DE LA NOUVELLE CATEGORIE RACINE ----------
    */
    public function findRght_newSubCatRac()
    {
        $rght_catRacine = $this->requete("SELECT MAX(lft + 2) AS rght FROM {$this->table}")->fetch();
        $rght_catRacine = $rght_catRacine->rght;
        return $rght_catRacine;
    }


    /* 
        -------------------------------------------------------- AJOUT D'UNE NOUVELLE SOUS-CATEGORIE --------------------------------------------------------
    */


    /* 
       ----------  MET A JOUR LES BORDS POUR INSERER LA NOUVELLE SOUS CATEGORIE (en sélectionnant le bord droit le plus haut des enfants de la catégorie racine) ----------
    */
    public function update_rghtLft($parent_id)
    {
        $child_rght_max = $this->requete("SELECT MAX(rght) FROM {$this->table} WHERE parent_id = $parent_id")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($child_rght_max));
        $rghtChildMax = iterator_to_array($it, false);

        $this->requete("UPDATE {$this->table} SET rght = rght + 2 WHERE rght > $rghtChildMax[0]");

        $this->requete("UPDATE {$this->table} SET lft = lft + 2 WHERE lft > $rghtChildMax[0]");
    }

    /* 
       ---------- BORD GAUCHE DE LA SOUS-CATEGORIE (en sélectionnant le bord droit le plus haut des enfants de la catégorie racine) ----------
    */
    public function findLft_newSubCat($parent_id)
    {
        $lft_catParent = $this->requete("SELECT MAX(rght + 1) FROM {$this->table} WHERE parent_id = $parent_id")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($lft_catParent));
        $lft_sc = iterator_to_array($it, false);
        return $lft_sc;
    }

    /* 
       ---------- BORD DROIT DE LA SOUS-CATEGORIE (en sélectionnant le bord droit le plus haut des enfants de la catégorie racine) ----------
    */
    public function findRght_newSubCat($parent_id)
    {
        $lft_catParent = $this->requete("SELECT MAX(rght + 2) FROM {$this->table} WHERE parent_id = $parent_id")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($lft_catParent));
        $rght_sc = iterator_to_array($it, false);
        return $rght_sc;
    }

    /* 
       ----------  MET A JOUR LES BORD POUR INSERER LA NOUVELLE SOUS CATEGORIE DANS UNE CATEGORIE AU BOUT DE L'ARBRE QUI N'A AUCUN ENFANT (en sélectionnant le bord droit de la catégorie parente) ----------
    */
    public function updateRghtLft_forLeafTree(int $id)
    {
        $rght_parent = $this->requete("SELECT rght FROM {$this->table} WHERE id = $id")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($rght_parent));
        $rght_parentCat = iterator_to_array($it, false);
        
        $this->requete("UPDATE {$this->table} SET rght = rght + 2 WHERE rght >= $rght_parentCat[0]");

        $this->requete("UPDATE {$this->table} SET lft = lft + 2 WHERE lft > $rght_parentCat[0]");
    }

    /* 
       ---------- BORD GAUCHE DE LA SOUS-CATEGORIE (en sélectionnant le bord gauche de la catégorie parente) ----------
    */
    public function findLft_newSubCat_leafTree($id)
    {
        $lft_catParent = $this->requete("SELECT lft + 1 FROM {$this->table} WHERE id = $id")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($lft_catParent));
        $lft_sc = iterator_to_array($it, false);
        return $lft_sc;
    }

    /* 
       ---------- BORD DROIT DE LA SOUS-CATEGORIE (en sélectionnant le bord gauche de la catégorie parente) ----------
    */
    public function findRght_newSubCat_leafTree($id)
    {
        $lft_catParent = $this->requete("SELECT lft + 2 FROM {$this->table} WHERE id = $id")->fetch();
        $it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($lft_catParent));
        $rght_sc = iterator_to_array($it, false);
        return $rght_sc;
    }


    /* 
        -------------------------------------------------------- GETTERS/SETTERS --------------------------------------------------------
    */


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of lft
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set the value of lft
     *
     * @return  self
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get the value of rght
     */
    public function getRght()
    {
        return $this->rght;
    }

    /**
     * Set the value of rght
     *
     * @return  self
     */
    public function setRght($rght)
    {
        $this->rght = $rght;

        return $this;
    }

    /**
     * Get the value of parent_id
     */
    public function getParent_id()
    {
        return $this->parent_id;
    }
    /**
     * Set the value of parent_id
     *
     * @return  self
     */
    public function setParent_id($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * Get the value of level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set the value of level
     *
     * @return  self
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }
}
