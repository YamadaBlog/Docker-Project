<?php
use PHPUnit\Framework\TestCase;
use App\Models\Articles;
use DateTime;

/**
 * ArticlesTest Model
 */
final class ArticlesTest extends TestCase {

    // Teste la récupération de tous les articles
    public function getAllTest(): void {
        // Utilisation du filtre "data" pour trier les articles par date
        $filter = "data"; 
        // Appel de la méthode getAll avec le filtre "data"
        $result = Articles::getAll($filter); 
        // Vérifie que le nombre de résultats est supérieur à 1
        $this->assertGreaterThan(1, count($result)); 
        // Récupère les clés du premier article pour les tester
        $keys = array_keys($result[0]); 
        // Vérifie que les clés de l'article correspondent aux clés attendues
        $this->assertSame(["id", "name", "description", "published_date", "user_id", "views", "picture"], $keys); 
    }

    // Teste la récupération d'un article spécifique
    public function getOneTest() {
        // Appel de la méthode getOne avec l'ID de l'article 1
        $result = Articles::getOne(1); 
        // Vérifie que le nombre de résultats est égal à 1
        $this->assertSame(1, count([$result])); 
        // Récupère les clés du premier résultat pour les tester
        $keys = array_keys($result[0]); 
        // Vérifie que les clés de l'article correspondent aux clés attendues
        $this->assertSame(["id", "name", "description", "published_date", "user_id", "views", "picture","username", "email", "password", "salt", "is_admin"], $keys);
    }

    // Teste l'ajout d'une vue à un article
    public function addOneViewTest() {
        // Création d'un nouvel article mock
        $newarticle = [
            'name' => 'Mock',
            'description' => 'Mock',
            'user_id' => 1, 
        ];
        // Sauvegarde du nouvel article et obtention de son ID
        $articleId = Articles::save($newarticle);
        // Ajoute une vue à l'article
        Articles::addOneView($articleId);
        // Récupère l'article mis à jour
        $updatedArticle = Articles::getOne($articleId);
        // Obtient le nombre de vues de l'article
        $views = $updatedArticle[0]['views'];
        // Vérifie que le nombre de vues est égal à 1
        $this->assertEquals(1, $views);
    }

    // Teste la récupération des articles d'un utilisateur spécifique
    public function getByUserTest() {
        // Récupère les articles de l'utilisateur avec l'ID 1
        $articles = Articles::getByUser(1);
        // Récupère les clés du premier article pour les tester
        $keys = array_keys($articles[0]);
        // Vérifie que les clés de l'article correspondent aux clés attendues
        $this->assertSame(["id", "name", "description", "published_date", "user_id", "views", "picture", "username", "email", "password", "salt", "is_admin"], $keys);
    }

    // Teste la récupération des articles suggérés
    public function getSuggestTest() {
        // Récupère les articles suggérés
        $result = Articles::getSuggest();
        // Vérifie que le nombre de résultats est supérieur à 0
        $this->assertGreaterThan(0, count($result));
        // Récupère le premier article des résultats
        $result = $result[0];
        // Récupère les clés de l'article pour les tester
        $keys = array_keys($result);
        // Vérifie que les clés de l'article correspondent aux clés attendues
        $this->assertSame(["id", "name", "description", "published_date", "user_id", "views", "picture", "username", "email", "password", "salt", "is_admin"], $keys);
    }
    
    // Teste la sauvegarde d'un nouvel article
    public function saveTest() {
        // Création des données pour un nouvel article
        $data = [
            'name' => 'test', 
            'description' => 'test',
            'user_id' => 1, 
            'published_date' => (new DateTime())->format('Y-m-d')
        ];
        // Sauvegarde du nouvel article et obtention de son ID
        $articleId = Articles::save($data);
        // Vérifie que l'ID de l'article est numérique
        $this->assertIsNumeric($articleId, "L'ID de l'article doit être numérique.");
        // Connexion à la base de données de test
        $db = Articles::fetchTestDatabaseConnection();
        // Prépare une requête pour récupérer l'article sauvegardé
        $stmt = $db->prepare("SELECT * FROM articles WHERE id = :id");
        // Lie l'ID de l'article à la requête préparée
        $stmt->bindParam(':id', $articleId);
        // Exécute la requête
        $stmt->execute();
        // Récupère le résultat de la requête
        $result = $stmt->fetch();
        // Vérifie que le résultat n'est pas vide
        $this->assertNotEmpty($result);
        // Vérifie que le nom de l'article correspond aux données d'origine
        $this->assertEquals($data['name'], $result['name']);
    }

    // Teste l'attachement d'une image à un article
    public function testAttachPicture() {
        // Création des données pour un nouvel article
        $article = [
            'name' => 'test',
            'description' => 'test',
            'user_id' => 1, 
            'published_date' => (new DateTime())->format('Y-m-d')
        ];
        // Sauvegarde du nouvel article et obtention de son ID
        $articleId = Articles::save($article); 
        // Création d'un nom de fichier unique pour l'image
        $pictureName = 'test_picture_2' . time() . '.jpg'; 
        
        try {
            // Attache l'image à l'article
            Articles::attachPicture($articleId, $pictureName); 
            // Récupère l'article mis à jour
            $updatedArticle = Articles::getOne($articleId); 
            // Vérifie que le nom de l'image correspond à celui qui a été attaché
            $this->assertEquals($pictureName, $updatedArticle[0]['picture'], "The picture name should match the one that was attached."); 
        } catch (Exception $e) {
            // Affiche un message d'erreur si l'attachement de l'image échoue
            $this->fail("Failed to attach picture: " . $e->getMessage()); 
        }
        // TODO: Ajouter un nettoyage de la base de données pour supprimer l'article créé lors des tests
    }
}
