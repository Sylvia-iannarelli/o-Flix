<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Display a single movie
     * @param int $id id of the movie
     * @Route("/film-serie/{id}", name="app_movie_show")
     */
    public function show(int $id): Response
    {
        return $this->render('movie/show.html.twig');
    }
}
