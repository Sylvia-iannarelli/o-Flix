<?php

namespace App\Controller\Front;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    // /**
    //  * @Route("/genre", name="app_front_genre")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('front/genre/index.html.twig', [
    //         'controller_name' => 'GenreController',
    //     ]);
    // }

    /**
     * Endpoint for all movies of a specific genre
     * @Route("/genre/{id}/movies", name="app_genre_getMoviesByGenre")
     */
    public function getMoviesByGenre(Genre $genre, GenreRepository $genreRepository): Response
    {
        if(!$genre){
            return $this->redirectToRoute('app_main_home');
        }

        $movies = $genre->getMovies();
        $genres = $genreRepository->findAllOrderByName();

        return $this->render('front/movie/list.html.twig', [
            "movies" => $movies,
            "genres" => $genres
        ]);
    }

}
