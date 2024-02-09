<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * Display the form for adding a review to a movie
     * @Route("/film-serie/{id}/critique/ajouter", name="app_review_add")
     */
    public function add(Movie $movie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = new Review;
        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $review->setMovie($movie);
            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash("success", "Votre critique a été ajoutée");

            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }

        return $this->renderForm('front/review/form.html.twig', [
            "form" => $form,
            "movie" => $movie
        ]);
    }
}
