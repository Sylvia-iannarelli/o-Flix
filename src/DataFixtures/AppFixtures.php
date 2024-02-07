<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\AppProvider;
use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $entityManager): void
    {

        $faker = Factory::create("fr_FR");
        $faker->addProvider(new AppProvider());

        // ! FIXTURE PERSON
        $personList = [];
        
        for ($i=0; $i < 20; $i++) { 
            $person = new Person();
    
            $person->setFirstname($faker->firstName());
            $person->setLastname($faker->lastName());
            $personList[] = $person;
    
            $entityManager->persist($person);
        }

        // ! FIXTURES GENRE
        $genreList = [];

        for ($i=0; $i < 20; $i++) { 
            $genre = new Genre();
            
            $genre->setName($faker->unique()->genre());   
            $genreList[] = $genre;        
            
            $entityManager->persist($genre);
        }

        // ! FIXTURES MOVIE / SEASON / CASTING
        for ($i=0; $i < 20; $i++) { 
            $movie = new Movie();

            $movie->setTitle($faker->unique()->movieTitle());
            $movie->setReleaseDate(new DateTimeImmutable($faker->date()));
            $movie->setSynopsis($faker->paragraph(6));
            $movie->setSummary($faker->paragraph(3));
            $movie->setPoster("https://picsum.photos/id/".mt_rand(1,180)."/300/400");

            $aleatoire = mt_rand(0,1);
            if($aleatoire === 0){
                $movie->setType("Film");
                $movie->setDuration(mt_rand(90,180));
            } else {
                $movie->setType("Série");
                $movie->setDuration(mt_rand(40,70));

                for ($j=1; $j <= mt_rand(1,7); $j++) { 
                    $season = new Season();
                    $season->setNumberEpisode(mt_rand(8,22));
                    $season->setNumberSeason($j);
                    $entityManager->persist($season);
                    $movie->addSeason($season);
                }
            }

            $movie->setRating($faker->randomFloat(1,0,5));

            $faker->unique(true);

            for ($k=0; $k < 3; $k++) { 
                $movie->addGenre($genreList[$faker->unique()->numberBetween(0,count($genreList) -1)]);
            }

            for ($l=1; $l <= 5; $l++) { 
                $casting = new Casting();
                $casting->setRole($faker->firstName());
                $casting->setCreditOrder($l);
                $casting->setPerson($personList[array_rand($personList)]);
    
                $movie->addCasting($casting);
                
                $entityManager->persist($casting);
            }

            $entityManager->persist($movie);
        }

        $entityManager->flush();
    }
}
