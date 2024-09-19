<?php

namespace App\Controllers;

class ErreursController extends Controller
{
   // Page d'accueil avec template home
   public function quatreCentQuatre()
   {
      $this->render('erreurs/quatreCentQuatre');
   }
}