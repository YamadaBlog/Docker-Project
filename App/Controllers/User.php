<?php

namespace App\Controllers;

use App\Model\UserRegister;
use App\Models\Articles;
use App\Utility\Hash;
use App\Utility\Session;
use \Core\View;
use Exception;
use http\Env\Request;
use http\Exception\InvalidArgumentException;

/**
 * User controller
 */
class User extends \Core\Controller
{

    /**
     * Affiche la page de login
     */
    public function loginAction()
    {
        if(isset($_POST['submit'])){
            $f = $_POST;

            // TODO: Validation

            // Se connecte
            $this->login($f);

            // Si login OK, redirige vers le compte
            header('Location: /account');
            exit;
        }

        View::renderTemplate('User/login.html');
    }


    /**
     * Page de création de compte
     */
    public function registerAction()
    {
        if(isset($_POST['submit'])){
            $f = $_POST;

            if($f['password'] !== $f['password-check']){
                // TODO: Gestion d'erreur côté utilisateur
            }

            // Connexion après création du user
            // Correctif déjà mis en place sur première feature

            $userId = $this->register($f);
            if ($userId) {
                // Connexion de l'utilisateur nouvellement enregistré
                $this->login($f);
                // Rediriger vers la page du compte
                header('Location: /account');
                exit;
            }
        }

        View::renderTemplate('User/register.html');
    }

    /**
     * Affiche la page du compte
     */
    public function accountAction()
    {
        // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
        if (!Session::userLoggedIn()) {
            header('Location: /login');
            exit;
        }


        $articles = Articles::getByUser($_SESSION['user']['id']);

        View::renderTemplate('User/account.html', [
            'articles' => $articles
        ]);
    }

    /*
     * Fonction privée pour enregister un utilisateur
     */
    private function register($data)
    {
        try {
            // Generate a salt, which will be applied to the during the password
            // hashing process.
            $salt = Hash::generateSalt(32);

            $userID = \App\Models\User::createUser([
                "email" => $data['email'],
                "username" => $data['username'],
                "password" => Hash::generate($data['password'], $salt),
                "salt" => $salt
            ]);

            return $userID;

        } catch (Exception $ex) {
            // TODO : Set flash if error : utiliser la fonction en dessous
            /* Utility\Flash::danger($ex->getMessage());*/
            return false;
        }
    }

    // Fonction principale de connexion au serveur d'un utilisateur
    private function login($data){
        try {
            if(!isset($data['email'])){
                throw new Exception('L\'email est requis');
            }

            // Récupère dans la bdd l'utilisateur correspondant
            $user = \App\Models\User::getByLogin($data['email']);

            if (Hash::generate($data['password'], $user['salt']) !== $user['password']) {
                return false;
            }

            // Crée une session pour l'utilisateur
            $_SESSION['user'] = array(
                'id' => $user['id'],
                'username' => $user['username'],
            );

            // Si l'utilisateur a sélectionné "Se souvenir de moi", crée un cookie
            if (isset($data['remember_me'])) {
                // Définir les cookies avec une durée de vie d'une semaine
                setcookie('user_id', $user['id'], time() + (7 * 24 * 60 * 60), "/");
                setcookie('username', $user['username'], time() + (7 * 24 * 60 * 60), "/");
            }

            return true;

        } catch (Exception $ex) {
            // Gérer les erreurs
            /* Utility\Flash::danger($ex->getMessage());*/
            return false;
        }
    }



    /**
     * Logout: Delete cookie and session. Returns true if everything is okay,
     * otherwise turns false.
     * @access public
     * @return boolean
     * @since 1.0.2
     */
    public function logoutAction() {
        // Supprimer les cookies "Se souvenir de moi"
        if (isset($_COOKIE['user_id'])) {
            setcookie('user_id', '', time() - 3600, "/");
        }
        if (isset($_COOKIE['username'])) {
            setcookie('username', '', time() - 3600, "/");
        }

        // Détruire toutes les données de la session
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: /");
        exit;
    }

}
