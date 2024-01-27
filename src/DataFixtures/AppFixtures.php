<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $entityManager): void
    {

        for ($i=0; $i < 10; $i++) { 
            $movie = new Movie();

            $movie->setTitle("Le seigneur des anneaux $i");
            $movie->setDuration(250);
            $movie->setReleaseDate(new DateTimeImmutable());
            $movie->setSynopsis("Synopsis lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur posuere ex et fringilla varius. Nullam blandit convallis elementum. Nulla eu faucibus nulla. Nullam mattis sollicitudin velit a malesuada. Nam eu ipsum non metus iaculis fringilla. Sed auctor lectus nec lectus molestie semper. Vestibulum tincidunt lectus euismod est efficitur, sit amet commodo neque dignissim. Morbi at convallis orci. Donec vel urna ut velit hendrerit commodo. Cras fringilla eleifend imperdiet. Mauris ex lorem, tristique et ipsum quis, accumsan auctor tortor.");
            $movie->setSummary("Summary integer vel justo vitae augue egestas pellentesque. Integer ac lectus et neque rhoncus convallis non eget odio. Nunc ac tincidunt ipsum. Morbi porttitor congue nulla non ullamcorper.");
            $movie->setPoster("https://fantasy.bnf.fr/sites/default/files/styles/pimages2/public/field_media_image/2019-12/fan_554.jpg?itok=x1r8nRdm");
            $movie->setType("Film");
            
            $entityManager->persist($movie);
        }

        $entityManager->flush();
    }
}
