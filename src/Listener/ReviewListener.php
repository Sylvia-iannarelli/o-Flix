<?php

namespace App\Listener;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;

class ReviewListener{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateRatingMovie(Review $review, PostPersistEventArgs $postPersistEventArgs){

        $movie = $review->getMovie();
        $allNotes = null;

        foreach($movie->getReviews() as $review){
            $allNotes += $review->getRating();
        }

        $rating = $allNotes / count($movie->getReviews());
        $movie->setRating(round($rating,1));

        $this->entityManager->flush();
    }

}
