<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * Endpoint for all genres
     * @Route("/api/genres", name="app_api_genre_getGenres", methods={"GET"})
     */
    public function getGenres(GenreRepository $genreRepository): JsonResponse
    {
        $genres = $genreRepository->findAllOrderByName();

        return $this->json($genres, Response::HTTP_OK, [], ["groups" => "genres"]);
    }

    /**
     * Endpoint for all movies of a specific genre
     * @Route("/api/genres/{id}/movies", name="app_api_genre_getMoviesByGenre", methods={"GET"})
     */
    public function getMoviesByGenre(Genre $genre = null): JsonResponse
    {
        if(!$genre){
            return $this->json(["error" => "Genre inexistant"], Response::HTTP_NOT_FOUND);
        }

        $movies = $genre->getMovies();

        return $this->json($movies, Response::HTTP_OK, [], ["groups" => "movies"]);
    }

}
