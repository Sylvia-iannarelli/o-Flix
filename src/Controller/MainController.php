<?php

namespace App\Controller;

use App\Model\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Display the homepage
     * @Route("/", name="app_main_home")
     *
     * @return Response object response
     */
    public function home(): Response
    {

        $moviesModel = new Movie();

        $movies = $moviesModel->getMovies();

        return $this->render("main/home.html.twig",[
            "movies" => $movies
        ]);
    }
}