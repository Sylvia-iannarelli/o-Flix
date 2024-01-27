<?php

namespace App\Controller;

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
        $movies = $entityManager->getRepository(Movie::class)->findAll();

        return $this->render("main/home.html.twig",[
            "movies" => $movies
        ]);
    }
}