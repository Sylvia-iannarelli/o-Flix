<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Endpoint for all movies with infos of all relations
     * @Route("/api/movies", name="app_api_movie_getMovies", methods={"GET"})
     */
    public function getMovies(MovieRepository $movieRepository): JsonResponse
    {
        $movies = $movieRepository->findAll();

        return $this->json($movies, Response::HTTP_OK, [], ["groups" => "movies"]);
    }

    /**
     * Endpoint for a random movie
     * @Route("/api/movies/random", name="app_api_movie_getRandomMovie", methods={"GET"})
     */
    public function getRandomMovie(MovieRepository $movieRepository): JsonResponse
    {
        $movie = $movieRepository->findRandomMovie();

        return $this->json($movie);
    }
}
