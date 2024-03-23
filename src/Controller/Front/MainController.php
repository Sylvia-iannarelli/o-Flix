<?php

namespace App\Controller\Front;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
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
    public function home(EntityManagerInterface $entityManager): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->find10OrderByDate();
        $genres = $entityManager->getRepository(Genre::class)->findAllOrderByName();

        return $this->render("front/main/home.html.twig",[
            "movies" => $movies,
            "genres" => $genres
        ]);
    }
}