<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\CastingRepository;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function show(Movie $movie, CastingRepository $castingRepository, SeasonRepository $seasonRepository): Response
    {
        $castings = $castingRepository->findAllJoinedToPersonByMovie($movie);
        $seasons = $seasonRepository->findAllByMovie($movie);
        return $this->render('movie/show.html.twig', [
            "movie" => $movie,
            "castings" => $castings,
            "seasons" => $seasons
        ]);
    }

    /**
     * Display all movies or by search
     * @Route("/film-serie", name="app_movie_list")
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        // TODO lier le form de recherche à ma requête
        $movies = $entityManager->getRepository(Movie::class)->findAllSearchByTitle();

        return $this->render('movie/list.html.twig', [
            "movies" => $movies
        ]);
    }

}
