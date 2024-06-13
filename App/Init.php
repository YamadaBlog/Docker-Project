<?php
// init.php

// Vérifiez les cookies pour connecter automatiquement
if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
    // Créez une session pour l'utilisateur à partir des cookies
    $_SESSION['user'] = array(
        'id' => $_COOKIE['user_id'],
        'username' => $_COOKIE['username'],
    );
}
?>
