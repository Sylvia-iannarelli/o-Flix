<?php

namespace App\Controller;

use App\Entity\Movie;
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
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            "movie" => $movie
        ]);
    }

    /**
     * Display all movies or by search
     * @Route("/film-serie", name="app_movie_list")
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->findAll();

        return $this->render('movie/list.html.twig', [
            "movies" => $movies
        ]);
    }
}
