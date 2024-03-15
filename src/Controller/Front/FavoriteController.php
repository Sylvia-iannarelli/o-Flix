<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Service\FavoriteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    private $favoriteService;

    public function __construct(FavoriteService $favoriteService){
        $this->favoriteService = $favoriteService;
    }

    /**
     * display the list of favorite
     * 
     * @Route("/favoris", name="app_favorite_list")
     */
    public function list(): Response
    {
        $movies = $this->favoriteService->getAll();
        return $this->render('front/favorite/list.html.twig', [
            "movies" => $movies
        ]);
    }

    /**
     * add a movie to the session
     * 
     * @param Movie $movie an instance of movie
     * @Route("/favoris/ajouter/{id}", name="app_favorite_add", requirements={"id"="\d+"})
     */
    public function add(Movie $movie): Response
    {
        if($this->favoriteService->toggle($movie)){
            $this->addFlash("success", "Film ajouté aux favoris");
        } else {
            $this->addFlash("danger", "Nombre maximum de favoris déjà atteint");
        };
        return $this->redirectToRoute('app_favorite_list');
    }

    /**
     * empty all favorite in session
     * 
     * @Route("/favoris/vider", name="app_favorite_empty")
     */
    public function empty(): Response
    {
        $this->favoriteService->empty();
        $this->addFlash("warning", "La liste des favoris a été vidée");
        return $this->redirectToRoute('app_favorite_list');
    }

    /**
     * delete a movie of the favorite session list
     * 
     * @param Movie $movie an instance of movie
     * @Route("/favoris/supprimer/{id}", name="app_favorite_delete")
     */
    public function delete(Movie $movie): Response
    {
        $this->favoriteService->toggle($movie);
        $this->addFlash("warning", "Film supprimé des favoris");
        return $this->redirectToRoute('app_favorite_list');
    }

}
