<?php

namespace App\Models;

use App\Core\Db;

/**
 * Modèle principal
 */
class Model extends Db
{
    // Table de la base de données
    protected $table;
    // Instance de Db
    private $db;

    /* 
        -------------------------------------------------------- READ --------------------------------------------------------
    */

    /**
     * Sélection de tous les enregistrements d'une table
     * @return array Tableau des enregistrements trouvés
     */
    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * Sélection de plusieurs enregistrements suivant un tableau de critères (ex : $annonces = $model->findBy([‘actif’ => 1]) ;)
     * @param array $criteres Tableau de critères
     * @return array Tableau des enregistrements trouvés
     */
    public function findBy(array $criteres)
    {
        // Tableaux vides pour les champs et les valeurs
        $champs = [];
        $valeurs = [];

        // Boucle pour éclater le tableau $criteres en deux tableaux
        foreach ($criteres as $champ => $valeur) {
            // On push dans les tableaux $champs et $valeurs ($valeur pour le ? de "$champ = ?")
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        // Transforme le tableau $champs et ses champs séparées en une chaîne de caractères qui rassemble les champs sur une seule ligne.
        $liste_champs = implode(' AND ', $champs);

        return $this->requete("SELECT * FROM {$this->table} WHERE $liste_champs", $valeurs)->fetchAll();
    }

    /**
     * Sélection d'un enregistrement suivant son id
     * @param integer $id id de l'enregistrement
     * @return array Tableau contenant l'enregistrement trouvé
     */
    public function find(int $id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
    }


    /* 
        -------------------------------------------------------- REQUÊTE --------------------------------------------------------
    */
    /**
     * Méthode qui exécutera ou préparera les requêtes selon les cas
     * @param string $sql Requête SQL à exécuter
     * @param array|null $attributs Attributs à ajouter à la requête
     * @return PDOStatement|false 
     */
    public function requete(string $sql, array $attributs = null)
    {
        // Récupère l'instance de Db
        $this->db = Db::getInstance();

        // Vérifie si on a des attributs
        if ($attributs !== null) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }


    /* 
        -------------------------------------------------------- CREATE --------------------------------------------------------
    */
    /**
     * Insertion d'un enregistrement suivant un tableau de données
     * @return bool
     */
    public function create()
    {
        $champs = [];
        $interro = [];
        $valeurs = [];

        // Boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // ex : INSERT INTO annonces (titre, description, actif) VALUES (?, ?, ?)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $interro[] = "?";
                $valeurs[] = $valeur;
            }
        }

        // Transforme les tableaux en chaîne de caractères
        $liste_champs = implode(', ', $champs);
        $liste_interro = implode(', ', $interro);

        return $this->requete('INSERT INTO ' . $this->table . ' (' . $liste_champs . ')VALUES(' . $liste_interro . ')', $valeurs);
    }


    /* 
        -------------------------------------------------------- UPDATE --------------------------------------------------------
    */
    /**
     * Mise à jour d'un enregistrement suivant un tableau de données
     * @param integer $id id de l'enregistrement à modifier
     * @param Model $model Objet à modifier
     * @return bool
     */
    public function update(int $id)
    {
        $champs = [];
        $valeurs = [];

        // Boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // ex : UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $id;

        // Transforme le tableau champs en une chaîne de caractères
        $liste_champs = implode(', ', $champs);

        return $this->requete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?', $valeurs);
    }


    /* 
        -------------------------------------------------------- DELETE --------------------------------------------------------
    */
    /**
     * Suppression d'un enregistrement
     * @param integer $id id de l'enregistrement à supprimer
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }


    /* 
        -------------------------------------------------------- HYDRATER --------------------------------------------------------
    */
    /**
     * Hydratation des données
     * @param array $donnees Tableau associatif des données
     * @return self Retourne l'objet hydraté
     */
    public function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {
            // Récupère le nom du setter correspondant à l'attribut.
            $method = 'set' . ucfirst($key);

            // Si le setter correspondant existe.
            if (method_exists($this, $method)) {
                // Appelle le setter.
                $this->$method($value);
            }
        }
        return $this;
    }
}
