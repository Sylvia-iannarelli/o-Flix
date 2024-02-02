<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $entityManager): void
    {

        // ! FIXTURE PERSON
        $personList = [];
        
        for ($i=1; $i < 21; $i++) { 
            $person = new Person();
    
            $person->setFirstname("Prénom $i");
            $person->setLastname("NOM $i");
            $personList[] = $person;
    
            $entityManager->persist($person);
        }

        // ! FIXTURES GENRE
        $genreList = [];

        for ($i=0; $i < 20; $i++) { 
            $genre = new Genre();
            
            $genre->setName("Genre $i");   
            $genreList[] = $genre;        
            
            $entityManager->persist($genre);
        }

        // ! FIXTURES MOVIE / SEASON / CASTING
        for ($i=1; $i <= 20; $i++) { 
            $movie = new Movie();

            $movie->setTitle("Le seigneur des anneaux $i");
            $movie->setReleaseDate(new DateTimeImmutable());
            $movie->setSynopsis("Synopsis lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur posuere ex et fringilla varius. Nullam blandit convallis elementum. Nulla eu faucibus nulla. Nullam mattis sollicitudin velit a malesuada. Nam eu ipsum non metus iaculis fringilla. Sed auctor lectus nec lectus molestie semper. Vestibulum tincidunt lectus euismod est efficitur, sit amet commodo neque dignissim. Morbi at convallis orci. Donec vel urna ut velit hendrerit commodo. Cras fringilla eleifend imperdiet. Mauris ex lorem, tristique et ipsum quis, accumsan auctor tortor.");
            $movie->setSummary("Summary integer vel justo vitae augue egestas pellentesque. Integer ac lectus et neque rhoncus convallis non eget odio. Nunc ac tincidunt ipsum. Morbi porttitor congue nulla non ullamcorper.");
            $movie->setPoster("https://fantasy.bnf.fr/sites/default/files/styles/pimages2/public/field_media_image/2019-12/fan_554.jpg?itok=x1r8nRdm");

            $aleatoire = mt_rand(0,1);
            if($aleatoire === 0){
                $movie->setType("Film");
                $movie->setDuration(mt_rand(90,180));
            } else {
                $movie->setType("Série");
                $movie->setDuration(mt_rand(40,70));
                $season = new Season();
                $season->setNumberEpisode(mt_rand(8,22));
                $season->setNumberSeason(1);
                $entityManager->persist($season);
                $movie->addSeason($season);
            }

            $movie->setRating(rand(0,5));

            $movie->addGenre($genreList[mt_rand(0,count($genreList)-1)]);

            for ($j=1; $j <= 5; $j++) { 
                $casting = new Casting();
                $casting->setRole("Mr Smith #$j");
                $casting->setCreditOrder($j);
                $casting->setPerson($personList[mt_rand(0,count($personList)-1)]);
    
                $movie->addCasting($casting);
                
                $entityManager->persist($casting);
            }

            $entityManager->persist($movie);
        }

        $entityManager->flush();
    }
}
