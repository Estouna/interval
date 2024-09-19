<?php

use App\Autoloader;
use App\Core\Main;

// Temps chargement en ms
define('DEBUG_TIME', microtime(true));

// Défini la constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));


const BASE_PATH = '/';
// BASE_PATH pour mettre en ligne sur alwaysdata
// const BASE_PATH = '/interval/';

// Import de l'autoloader
require_once ROOT . '/Autoloader.php';
Autoloader::register();


// On instancie Main
$app = new Main();

// On démarre l'application
$app->start();

// var_dump($_SERVER['HTTP_HOST']);
// var_dump(ROOT);
// var_dump($_SERVER['REQUEST_URI']);
// var_dump($_SERVER['DOCUMENT_ROOT']);
