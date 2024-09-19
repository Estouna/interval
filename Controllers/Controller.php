<?php

namespace App\Controllers;

/**
 * Contrôleur principal
 */
abstract class Controller
{
    /* 
        -------------------------------------------------------- AFFICHAGE --------------------------------------------------------
    */
    /**
     * Renvoi les informations à une vue pour l'affichage
     *
     * @param string $fichier
     * @param array $donnees Tableau associatif
     * @return void
     */
    public function render(string $fichier, array $donnees = [], string $template = 'default')
    {
        // Extrait le contenu du tableau associatif $donnees et transforme la clé de ce tableau en variable puis met sa valeur dedans.
        // ex : ['loginForm' => $form->create()] devient $loginForm = $form->create();
        extract($donnees);

        // Démarre le buffer de sortie, à partir de ce point toute sortie est conservée en mémoire
        ob_start();

        // Chemin vers la vue mis en mémoire
        require_once ROOT . '/Views/' . $fichier . '.php';

        // Transfère le buffer dans $content
        $content = ob_get_clean();

        // Template de la page
        require_once ROOT . '/Views/' . $template . '.php';
    }
}
