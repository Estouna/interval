<?php

namespace App;

class Autoloader
{
    static function register()
    {
        // Fonction qui met en place une détection automatique des instanciations (new), si la classe n'est pas connue, elle exécute autoload().
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    // $class = __CLASS__ (la classe actuelle)
    static function autoload($class)
    {
        // Récupère le namespace complet (ex: App\Client\Compte) et retire App\
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);

        // Remplace le \ par / (ex: Client/Compte)
        $class = str_replace('\\', '/', $class);

        // Chemin du dossier où se trouve Autoloader.php auquel on concatène /$class.php
        $fichier = __DIR__ . '/' . $class . '.php';

        // Vérifie si le fichier existe pour éviter une erreur de chargement
        if (file_exists($fichier)) {
            require_once $fichier;
        }
    }
}
