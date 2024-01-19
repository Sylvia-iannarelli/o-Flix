<?php

namespace App\Controller;

use App\Model\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Display a single movie
     * @param int $id id of the movie
     * @Route("/film-serie/{id}", name="app_movie_show", requirements={"id"="\d+"})
     */
    public function show(int $id): Response
    {
        $movieModel = new Movie;

        $movie = $movieModel->getMovieById($id);

        if (!$movie) {
            throw $this->createNotFoundException('Le film n\'existe pas');
        }

        return $this->render('movie/show.html.twig', [
            "movie" => $movie
        ]);
    }

    /**
     * Display all movies or by search
     * @Route("/film-serie", name="app_movie_list")
     */
    public function list(): Response
    {
        $movieModel = new Movie;

        $movies = $movieModel->getMovies();

        return $this->render('movie/list.html.twig', [
            "movies" => $movies
        ]);
    }
}
