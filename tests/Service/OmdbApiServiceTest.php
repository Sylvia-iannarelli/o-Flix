<?php

namespace App\Tests\Service;

use App\Entity\Movie;
use App\Service\OmdbApiService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OmdbApiServiceTest extends KernelTestCase
{
    private const TEST_CASES = [
        "dikkenek",
        "kaboom",
        "mais où est donc passée la 7ème compagnie",
        "match point"
    ];

    public function testFetch(): void
    {
        // (1) boot the Symfony kernel
        $kernel = self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $omdbApiService = $container->get(OmdbApiService::class);

        foreach(self::TEST_CASES as $title) {
            $movie = new Movie();
            $movie->setTitle($title);
            $result = $omdbApiService->fetch($movie);

            $this->assertIsArray($result);
            $this->assertArrayNotHasKey("Error", $result, "Un des fetch renvoie un tableau avec une erreur");
            $this->assertArrayHasKey("Title", $result);
            $this->assertEqualsIgnoringCase($title, $result["Title"]);
        }
    }
}
