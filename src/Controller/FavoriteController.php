<?php

namespace App\Controller;

use App\Model\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    /**
     * display the list of favorite
     * @param Request $request the current request object
     * 
     * @Route("/favoris", name="app_favorite_list")
     */
    public function list(Request $request): Response
    {
        $session = $request->getSession();

        $movies = $session->get("favorites");

        return $this->render('favorite/list.html.twig', [
            "movies" => $movies
        ]);
    }

    /**
     * add a movie to the session
     * @param Request $request the current request object
     * @param Movie $movieModel model of movie
     * @param int $id id of the movie to add
     * 
     * @Route("/favoris/ajouter/{id}", name="app_favorite_add", requirements={"id"="\d+"})
     */
    public function add(Request $request, Movie $movieModel, int $id): Response
    {
        // Récupération du film avec son id
        $movie = $movieModel->getMovieById($id);
        
        // Récupération de la session
        $session = $request->getSession();
        
        // Récupération des favoris de la session sous forme de tableau
        $favorites = $session->get("favorites", []);

        // Ajout d'un index au tableau des favoris, avec comme contenu le film
        $favorites[$id] = $movie;

        // Actualisation des favoris de la session
        $session->set("favorites", $favorites);

        return $this->redirectToRoute('app_favorite_list');
    }

    /**
     * empty all favorite in session
     * @param Request $request the current request object
     * 
     * @Route("/favoris/vider", name="app_favorite_empty")
     */
    public function empty(Request $request): Response
    {
        $session = $request->getSession();

        $session->remove("favorites");

        return $this->redirectToRoute('app_favorite_list');
    }

    /**
     * delete a movie of the favorite session list
     * @param Request $request the current request object
     * @param int $id id of the movie to delete
     * 
     * @Route("/favoris/supprimer/{id}", name="app_favorite_delete")
     */
    public function delete(Request $request, int $id): Response
    {
        $session = $request->getSession();

        $favorites = $session->get("favorites");

        unset($favorites[$id]);

        $session->set("favorites", $favorites);

        return $this->redirectToRoute('app_favorite_list');
    }

}
