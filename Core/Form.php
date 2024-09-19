<?php

namespace App\Core;

class Form
{
    private $formCode = "";

    /**
     * Génère le formulaire HTML
     * @return string
     */
    public function create()
    {
        return $this->formCode;
    }

    /* 
        -------------------------------------------------------- VALIDATION --------------------------------------------------------
    */
    // XXXX Validation simple à améliorer XXXX

    /**
     * Vérifie et valide si tous les champs sont remplis
     * @param array $form Tableau contenant les champs à vérifier
     * @param array $fields Tableau listant les champs à vérifier
     * @return bool
     */
    public static function validate(array $form, array $fields)
    {
        // Parcourt les champs
        foreach ($fields as $field) {
            // Vérifie si le champ est absent ou vide dans le formulaire
            if (!isset($form[$field]) || empty($form[$field])) {
                // Sort dès le premier champ non validé
                return false;
            }
            
        }
        // Sinon valide en retournant true
        return true;
    }

    public static function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

    /* 
        -------------------------------------------------------- AJOUT DES ATTRIBUTS --------------------------------------------------------
    */
    /**
     * Ajoute les attributs envoyés à la balise
     * @param array $attributs Tableau associatif ['class' => 'form-control', 'required' => true]
     * @return string Chaine de caractères générée
     */
    private function ajoutAttributs(array $attributs): string
    {
        // Initialise une chaîne de caractères
        $str = '';

        // Liste les attributs "courts" (qui n'ont pas de valeurs)
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        // Parcourt le tableau d'attributs
        foreach ($attributs as $attribut => $valeur) {
            // Si l'attribut est dans le tableau $courts (in_array())
            if (in_array($attribut, $courts) && $valeur == true) {
                $str .= " $attribut";
            } else {
                // Ajoute attribut='valeur'
                $str .= " $attribut=\"$valeur\"";
            }
        }

        return $str;
    }

    /* 
        -------------------------------------------------------- BALISE FORM --------------------------------------------------------
    */
    /**
     * Ajoute une balise d'ouverture form
     * @param string $methode method de la balise form (post ou get)
     * @param string $action action de la balise form
     * @param array $attributs Les attributs
     * @return Form Retourne le formulaire
     */
    public function debutForm(string $methode = 'post', string $action = '#', array $attributs = []): self
    {
        // Ouvre la balise form
        $this->formCode .= "<form method='$methode' action='$action'";

        // Ajout des attributs et ferme la balise d'ouverture si pas d'attributs ferme seulement la balise
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Ajoute une balise de fermeture form
     * @return Form 
     */
    public function finForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /* 
        -------------------------------------------------------- BALISE LABEL --------------------------------------------------------
    */
    /**
     * Ajoute une balise label
     * @param string $for for de la balise label
     * @param string $texte Intitulé de la balise label
     * @param array $attributs Les attributs
     * @return Form 
     */
    public function ajoutLabelFor(string $for, string $texte, array $attributs = []): self
    {
        // Ouvre la balise label
        $this->formCode .= "<label for='$for'";

        // Ajout des attributs si pas d'attributs rien
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // Ferme la balise ouvrante, ajoute l'intitulé du label et la balise fermante
        $this->formCode .= ">$texte</label>";

        return $this;
    }

    /* 
        -------------------------------------------------------- BALISE INPUT --------------------------------------------------------
    */
    /**
     * Ajoute une balise input
     * @param string $type type de la balise input
     * @param string $nom name de la balise input
     * @param array $attributs 
     * @return Form
     */
    public function ajoutInput(string $type, string $nom, array $attributs = []): self
    {
        // On ouvre la balise
        $this->formCode .= "<input type='$type' name='$nom'";

        // Ajout des attributs et ferme la balise sinon ferme juste la balise
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';

        return $this;
    }

    /* 
        -------------------------------------------------------- BALISE TEXTAREA --------------------------------------------------------
    */
    /**
     * Ajoute un champ textarea
     * @param string $nom name du champ
     * @param string $valeur Valeur du champ
     * @param array $attributs
     * @return Form Retourne l'objet
     */
    public function ajoutTextarea(string $nom, string $valeur = '', array $attributs = []): self
    {
        // Ouvre la balise
        $this->formCode .= "<textarea name='$nom'";

        // Ajoute les attributs sinon s'il n'y en a pas rien
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // Ferme la balise ouvrante, ajoute le texte et la balise fermante 
        $this->formCode .= ">$valeur</textarea>";

        return $this;
    }

    /* 
        -------------------------------------------------------- BALISE SELECT --------------------------------------------------------
    */
    /**
     * Ajout d'un select avec ses options
     * @param string $nom name de select
     * @param array $options Liste des options (tableau associatif)
     * @param array $attributs 
     * @return Form
     */
    public function ajoutSelect(string $nom, array $options, array $attributs = []): self
    {
        // Ouvre la balise
        $this->formCode .= "<select name='$nom'";

        // Ajout des attributs et ferme la balise sinon ferme juste la balise
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';

        // Ajoute les options
        foreach ($options as $valeur => $texte) {
            $this->formCode .= "<option value=\"$valeur\">$texte</option>";
        }

        // Ajoute la balise fermante
        $this->formCode .= '</select>';

        return $this;
    }

    /* 
        -------------------------------------------------------- BALISE BUTTON --------------------------------------------------------
    */
    /**
     * Ajout d'un bouton
     * @param string $texte 
     * @param array $attributs 
     * @return Form
     */
    public function ajoutBouton(string $texte, array $attributs = []): self
    {
        // Ouvre la balise
        $this->formCode .= '<button ';

        // Ajoute les attributs sinon s'il n'y en a pas rien
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // Ferme la balise ouvrante et ajoute le texte et la balise fermante
        $this->formCode .= ">$texte</button>";

        return $this;
    }


    /* 
        -------------------------------------------------------- TEST BALISE DE DIV --------------------------------------------------------
    */
    public function debutDiv(array $attributs = []): self
    {
        // Ouvre la balise form
        $this->formCode .= "<div ";

        // Ajout des attributs et ferme la balise d'ouverture si pas d'attributs ferme seulement la balise
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';

        return $this;
    }

    public function finDiv(): self
    {
        $this->formCode .= '</div>';
        return $this;
    }
}
