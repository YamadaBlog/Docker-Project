<?php

namespace App\Models;

use PHPUnit\Framework\TestCase;
use PDO;

class CitiesTest extends TestCase
{
    /**
     * Teste la méthode search pour vérifier la recherche de villes
     *
     * @test
     */
    public function testSearch()
    {
        // Appel de la méthode search pour rechercher des villes commençant par 'bordeaux'
        $result = Cities::search('bordeaux');

        // Affichage des résultats de la recherche
        echo "Résultats de la recherche pour 'bordeaux':\n";
        print_r($result);

        // Vérification que des résultats sont retournés
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * Teste la méthode search lorsque aucune ville ne correspond à la recherche
     *
     * @test
     */
    public function testSearchNoResult()
    {
        // Appel de la méthode search pour rechercher des villes commençant par 'riennnn'
        $result = Cities::search('riennnn');

        echo "Résultats de la recherche pour 'riennnnn':\n";
        print_r($result);

        // Vérification qu'aucun résultat n'est retourné
        $this->assertCount(0, $result);
    }

    /**
     * Teste la méthode search avec une chaîne vide
     *
     * @test
     */
    public function testSearchEmpty()
    {
        // Appel de la méthode search avec une chaîne vide
        $result = Cities::search('');

        // Vérification que ca renvoit toute les données
        $this->assertCount(36700, $result);
    }
}
