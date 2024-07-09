<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Models\Cities;
use \Core\View;
use Exception;

/**
 * API controller
 */
class Api extends \Core\Controller
{

    /**
     * Affiche la liste des articles / produits pour la page d'accueil
     *
     * @throws Exception
     */
    public function ProductsAction()
    {
        // Vérifier si $_GET['sort'] est définie
        if(isset($_GET['sort'])) {
        $query = $_GET['sort'];
        } else {
        // Si $_GET['sort'] n'est pas définie, vous pouvez définir une valeur par défaut ou gérer ce cas selon vos besoins
        $query = ''; // Par exemple, vous pouvez définir une requête vide
        }

        $articles = Articles::getAll($query);

        header('Content-Type: application/json');
        echo json_encode($articles);
    }

    /**
     * Recherche dans la liste des villes
     *
     * @throws Exception
     */
    public function CitiesAction(){

        $cities = Cities::search($_GET['query']);

        header('Content-Type: application/json');
        echo json_encode($cities);
    }
}
