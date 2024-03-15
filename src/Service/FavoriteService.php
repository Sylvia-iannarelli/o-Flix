<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Component\HttpFoundation\RequestStack;

class FavoriteService{

    private $request;
    private $maxFav;

    public function __construct(RequestStack $request, int $maxFav){
        $this->request = $request;
        $this->maxFav = $maxFav;
    }

    /**
     * display the list of all favorites
     *
     * @return void
     */
    public function getAll() {
        $session = $this->request->getSession();
        $movies = $session->get("favorites");
        return $movies;
    }
    
    /**
     * Toggle a movie in the favorite session
     *
     * @param Movie $movie an instance of movie
     * @return bool
     */
    public function toggle(Movie $movie) {
        $session = $this->request->getSession();
        $favorites = $session->get("favorites", []);
        $idMovie = $movie->getId();

        if(isset($favorites[$idMovie])){
            unset($favorites[$idMovie]);
        } else {
            if(count($favorites) >= $this->maxFav){
                return false;
            }
            $favorites[$idMovie] = $movie;
        }
        $session->set("favorites", $favorites);
        return true;
    }

    /**
     * Remove all the movies from the favorite session
     *
     * @return bool
     */
    public function empty() {
        $session = $this->request->getSession();
        $session->remove("favorites");
        return true;
    }

}
