<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Utility\Upload;
use \Core\View;

/**
 * Product controller
 */
class Product extends \Core\Controller
{

    /**
     * Affiche la page d'ajout
     * @return void
     */
    public function indexAction()
{
    if (isset($_POST['submit'])) {
        try {
            $f = $_POST;
            $errors = [];

            // Validation des champs
            if (empty($f['name'])) {
                $errors[] = 'Le titre est obligatoire.';
            }
            if (empty($f['description'])) {
                $errors[] = 'La description est obligatoire.';
            }
            if (empty($f['ville'])) {
                $errors[] = 'La ville est obligatoire.';
            }
            if (empty($_FILES['picture']['name'])) {
                $errors[] = 'L\'image est obligatoire.';
            } elseif (!in_array($_FILES['picture']['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
                $errors[] = 'Seules les images au format JPG, PNG, et GIF sont autorisées.';
            }

            // Si des erreurs sont présentes, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
            } else {
                // Pas d'erreurs, procéder à l'enregistrement de l'article
                $f['user_id'] = $_SESSION['user']['id'];
                $id = Articles::save($f);

                $pictureName = Upload::uploadFile($_FILES['picture'], $id);

                Articles::attachPicture($id, $pictureName);

                header('Location: /product/' . $id);
                exit;
            }
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    View::renderTemplate('Product/Add.html');
    }

    /**
     * Affiche la page d'un produit
     * @return void
     */
    public function showAction()
    {
        $id = $this->route_params['id'];

        try {
            Articles::addOneView($id);
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);
        } catch(\Exception $e){
            var_dump($e);
        }

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions
        ]);
    }
}
