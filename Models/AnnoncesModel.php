<?php

namespace App\Models;

class AnnoncesModel extends Model
{
    protected $id;
    protected $titre;
    protected $description;
    protected $created_at;
    protected $actif;
    protected $users_id;
    protected $pseudo_author;
    protected $categories_id;

    /* 
        -------------------------------------------------------- CONSTRUCTEUR --------------------------------------------------------
    */
    public function __construct()
    {
        $this->table = 'annonces';
    }

    /* 
        -------------------------------------------------------- METHODES --------------------------------------------------------
    */

    /* 
       ----------  TROUVER LES ANNONCES D'UN UTILISATEUR PAR SON USER_ID ----------
    */
    public function findAllByUserId(int $user_id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE users_id = $user_id")->fetchAll();
    }

    /* 
       ----------  TROUVER LES ANNONCES D'UNE CATEGORIE ----------
    */
    public function findAllByCategoryId(int $category_id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE categories_id = $category_id")->fetchAll();
    }

    /* 
       ----------  TROUVER LES ANNONCES D'UNE CATEGORIE ----------
    */
    public function findAllByCategoryIdFetch(int $category_id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE categories_id = $category_id")->fetchAll();
    }

    public function updateAnnoncesCategoryId(int $cat_id)
    {
        $champs = [];
        $valeurs = [];

        // Boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $cat_id;

        // Transforme le tableau champs en une chaîne de caractères
        $liste_champs = implode(', ', $champs);

        return $this->requete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE categories_id = ?', $valeurs);
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
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     * @return  self
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of actif
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set the value of actif
     * @return  self
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get the value of users_id
     */
    public function getUsers_id(): int
    {
        return $this->users_id;
    }

    /**
     * Set the value of users_id
     * @return  self
     */
    public function setUsers_id(int $users_id)
    {
        $this->users_id = $users_id;

        return $this;
    }

    /**
     * Get the value of pseudo_author
     */
    public function getPseudo_author()
    {
        return $this->pseudo_author;
    }

    /**
     * Set the value of pseudo_author
     *
     * @return  self
     */
    public function setPseudo_author($pseudo_author)
    {
        $this->pseudo_author = $pseudo_author;

        return $this;
    }

    /**
     * Get the value of categories_id
     */
    public function getCategories_id(): int
    {
        return $this->categories_id;
    }

    /**
     * Set the value of categories_id
     *
     * @return  self
     */
    public function setCategories_id(int $categories_id)
    {
        $this->categories_id = $categories_id;

        return $this;
    }
}
