<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\Api;
use Tests\TestController; // Assurez-vous que le chemin vers TestController est correct

class ApiTest extends TestCase
{
    public function testProductsAction()
    {
        // Créer une requête fictive
        $_GET['sort'] = 'popularite'; // Exemple de paramètre sort

        // Capturer la sortie JSON de l'action
        ob_start();
        $controller = new TestController([]); // Instancier TestController au lieu de Core\Controller
        $apiController = new Api($controller); // Passer une instance de TestController
        $apiController->ProductsAction();
        $output = ob_get_clean();

        // Vérifier que la sortie est bien du JSON
        $this->assertJson($output);

        // Décoder la réponse JSON
        $products = json_decode($output, true);

        // Vérifier que la réponse contient des données attendues
        $this->assertIsArray($products);
        $this->assertGreaterThan(0, count($products)); // Vérifier qu'il y a au moins un produit retourné
        // Ajoutez d'autres assertions selon les données retournées
    }

    public function testCitiesAction()
    {
        // Simuler une requête GET avec un paramètre query
        $_GET['query'] = 'paris'; // Exemple de recherche de ville

        // Capturer la sortie JSON de l'action
        ob_start();
        $controller = new TestController([]); // Instancier TestController au lieu de Core\Controller
        $apiController = new Api($controller); // Passer une instance de TestController
        $apiController->CitiesAction();
        $output = ob_end_clean();

        // Vérifier que la sortie est bien du JSON
        $this->assertJson($output);

        // Décoder la réponse JSON
        $cities = json_decode($output, true);

        // Vérifier que la réponse contient des données attendues
        $this->assertIsArray($cities);
        $this->assertGreaterThan(0, count($cities)); // Vérifier qu'il y a au moins une ville retournée
        // Ajoutez d'autres assertions selon les données retournées
    }

    // Vous pouvez ajouter d'autres tests pour différents scénarios selon votre API
}
?>
