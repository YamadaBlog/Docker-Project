<?php

namespace App\Utility;

/**
 * Hash:
 */
class Session {

    /**
     * Vérifie si l'utilisateur est connecté 
     */
    public static function userLoggedIn() {
      return isset($_SESSION['user']);
  }
  
}
