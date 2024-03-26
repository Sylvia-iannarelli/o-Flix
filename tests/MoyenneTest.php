<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Exemple de test unitaire
 */
class MoyenneTest extends TestCase
{
    private const TEST_CASES = [
        [
            "data" => [1,3,4,5],
            "result" => 3.3
        ],
        [
            "data" => [5,5,5,5],
            "result" => 5
        ],
        [
            "data" => [1,1,1,1,1,1,5],
            "result" => 1.6
        ]
    ];

    public function testCalculMoyenne(): void
    {
        foreach(self::TEST_CASES as $test) {
        
            $allNotes = null;
            foreach($test["data"] as $note) {
                $allNotes += $note;
            }
            $rating = $allNotes / count($test["data"]);
            $roundRating = round($rating,1);

            $this->assertEquals($test["result"], $roundRating);
        }
    }
}
