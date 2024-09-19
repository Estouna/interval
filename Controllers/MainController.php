<?php

namespace App\Controllers;

class MainController extends Controller
{
   // Page d'accueil avec template home
   public function index()
   {
      $this->render('main/index', [], 'home');
   }
}
