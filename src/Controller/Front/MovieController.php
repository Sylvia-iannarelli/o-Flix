<?php

namespace App\Controller\Front;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\CastingRepository;
use App\Repository\ReviewRepository;
use App\Repository\SeasonRepository;
use App\Service\OmdbApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Display a single movie
     * @param int $id id of the movie
     * @Route("/film-serie/{id}/{slug}", name="app_movie_show", requirements={"id"="\d+"})
     */
    public function show(Movie $movie, CastingRepository $castingRepository, SeasonRepository $seasonRepository, ReviewRepository $reviewRepository, OmdbApiService $omdb): Response
    {
        $castings = $castingRepository->findAllJoinedToPersonByMovie($movie);
        $seasons = $seasonRepository->findAllByMovie($movie);
        $reviews = $reviewRepository->findAllByMovie($movie);
        return $this->render('front/movie/show.html.twig', [
            "movie" => $movie,
            "castings" => $castings,
            "seasons" => $seasons,
            "reviews" => $reviews
        ]);
    }

    /**
     * Display all movies or by search
     * @Route("/film-serie", name="app_movie_list")
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $genres = $entityManager->getRepository(Genre::class)->findAllOrderByName();
        // TODO lier le form de recherche à ma requête
        $movies = $entityManager->getRepository(Movie::class)->findAllSearchByTitle();

        return $this->render('front/movie/list.html.twig', [
            "movies" => $movies,
            "genres" => $genres
        ]);
    }

}
