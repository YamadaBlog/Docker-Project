<?php

namespace Tests\Mocks;

use App\Models\Articles;

class ArticlesMock extends Articles
{
    public static function getAll($filter)
    {
        // Implémentation mock de la méthode getAll
        return [
            [
                'id' => 1,
                'name' => 'Mock Article',
                'description' => 'Mock Description',
                'published_date' => '2023-01-01',
                'user_id' => 1,
                'views' => 0,
                'picture' => 'mock.jpg'
            ]
        ];
    }

    public static function getOne($id)
    {
        // Implémentation mock de la méthode getOne
        return [
            'id' => $id,
            'name' => 'Mock Article',
            'description' => 'Mock Description',
            'published_date' => '2023-01-01',
            'user_id' => 1,
            'views' => 0,
            'picture' => 'mock.jpg'
        ];
    }

    public static function addOneView($id)
    {
        // Implémentation mock de la méthode addOneView
        // Ne retourne rien car c'est une action sans retour
    }

    public static function getByUser($userId)
    {
        // Implémentation mock de la méthode getByUser
        return [
            [
                'id' => 1,
                'name' => 'Mock Article',
                'description' => 'Mock Description',
                'published_date' => '2023-01-01',
                'user_id' => $userId,
                'views' => 0,
                'picture' => 'mock.jpg'
            ]
        ];
    }

    public static function getSuggest()
    {
        // Implémentation mock de la méthode getSuggest
        return [
            [
                'id' => 1,
                'name' => 'Suggested Mock Article',
                'description' => 'Suggested Mock Description',
                'published_date' => '2023-01-01',
                'user_id' => 1,
                'views' => 0,
                'picture' => 'suggested_mock.jpg'
            ]
        ];
    }

    public static function save($data)
    {
        // Implémentation mock de la méthode save
        return 1; // Retourne l'ID de l'article nouvellement créé
    }

    public static function attachPicture($articleId, $pictureName)
    {
        // Implémentation mock de la méthode attachPicture
        // Ne retourne rien car c'est une action sans retour
    }

    public static function update($id, $data)
    {
        // Implémentation mock de la méthode update
        return true; // Indique que la mise à jour a réussi
    }

    public static function delete($id)
    {
        // Implémentation mock de la méthode delete
        return true; // Indique que la suppression a réussi
    }

    public static function countAll()
    {
        // Implémentation mock de la méthode countAll
        return 10; // Retourne le nombre total d'articles
    }
}
