<?php

namespace App\Core;

use App\Controllers\MainController;

/**
 * Routeur principal
 */
class Main
{
    public function start()
    {
        // Démarre la session
        session_start();

        /* 
            Retire le dernier / éventuel de l'URL 
            "/controleur/methode/" donnera 3 paramètres où "/controleur/methode" en donnera 2, 
            permet également d'éviter le "Duplicate Content"
        */
        // Récupère l'URL "/public/annonces/details/a/b/c/"
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri === '/') {
            $uri = '/main';
        }

        // Vérifie que $uri n'est pas vide et se termine par un /
        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {

            // Enlève le dernier /
            $uri = substr($uri, 0, -1);

            // Code de redirection permanente
            http_response_code(301);

            //Redirige vers l'URL sans /
            header('Location: '.$uri);
            exit;
        }

        // Gère les paramètres d'URL "p=controleur/methode/paramètres"
        // Sépare les paramètres dans un tableau
        $params = [];
        if(isset($_GET['p'])) 
        $params = explode('/', $_GET['p']);
        // Vérifie qu'au moins un paramètre ($params[0] = controller) existe
        if ($params[0] != '') {

            // Récupère le 1er paramètre qui est le nom du controller à instancier (namespace complet)
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';
            // Instancie le controller
            if(class_exists($controller)) { 
                $controller = new $controller();
            }

            // Récupère le 2e paramètre (si il existe) qui est le nom de la méthode
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                // S'il reste des paramètres on les passe à la méthode 
                // call_user_func_array() permet d'envoyer une fonction (ici [$controller, $action]) et de passer en plus un tableau
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                header('Location:' . BASE_PATH . 'erreurs/quatreCentQuatre');
                exit;
            } 
        } else {
            header('Location:' . BASE_PATH . 'main');
            // Controller par défaut
            // $controller = new MainController;
            // $controller->index();
        }
    }
}
