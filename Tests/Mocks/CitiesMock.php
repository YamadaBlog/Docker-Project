<?php

namespace Tests\Mocks;

use App\Models\Cities;

class CitiesMock extends Cities
{
    public static function search($str)
    {
        // Implémentation mock de la méthode search
        if ($str === 'Paris') {
            return [1, 2, 3]; // Exemple d'IDs de villes fictives
        }

        return [];
    }
}
