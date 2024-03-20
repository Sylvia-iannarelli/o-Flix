<?php

namespace App\Listener;

use App\Entity\Movie;
use Symfony\Component\String\Slugger\SluggerInterface;

class MovieListener{
    private $slugger;

    public function __construct(SluggerInterface $slugger) {
        $this->slugger = $slugger;
    }

    public function slugifyTitle(Movie $movie) {
        $movie->setSlug($this->slugger->slug($movie->getTitle()));
    }
}
