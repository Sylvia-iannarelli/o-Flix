<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MovieController extends AbstractController
{
    /**
     * Endpoint for all movies with infos of all relations
     * @Route("/api/movies", name="app_api_movie_getMovies", methods={"GET"})
     */
    public function getMovies(MovieRepository $movieRepository): JsonResponse
    {
        $movies = $movieRepository->findAll();

        return $this->json($movies, Response::HTTP_OK, [], ["groups" => "movies"]);
    }

    /**
     * Endpoint for a specific movie
     * 
     * @Route("/api/movies/{id}", name="app_api_movie_getMovieById", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getMovieById(Movie $movie): JsonResponse
    {

        // TODO gérer si le film n'existe pas

        return $this->json($movie,Response::HTTP_OK,[], ["groups" => "movies"]);
    }

    /**
     * Endpoint for a random movie
     * @Route("/api/movies/random", name="app_api_movie_getRandomMovie", methods={"GET"})
     */
    public function getRandomMovie(MovieRepository $movieRepository): JsonResponse
    {
        $movie = $movieRepository->findRandomMovie();

        return $this->json($movie);
    }

    /**
     * Endpoint for adding a movie
     * 
     * @Route("/api/movies", name="app_api_movie_postMovie", methods={"POST"})
     */
    public function postMovie(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // On récupère le contenu de la requête (le json)
        $data = $request->getContent();

        try{
            // On désérialize le json en entité
            $movie = $serializer->deserialize($data,Movie::class, "json");

        }
        catch(NotEncodableValueException $e){
            return $this->json(["error" => "JSON invalide"],Response::HTTP_BAD_REQUEST);
        }

        // On vérifie la validité de l'entité
        $errors = $validator->validate($movie);
        if(count($errors) > 0){
            // On crée un tableau vide, pour y stocker les erreurs
            $dataErrors = [];

            // On boucle sur les erreurs
            foreach($errors as $error){
                // On crée un index par champs et on liste les erreurs de chaque champs dans un sous tableau
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
            // L'entité n'est pas traitable à cause de données erronnées, on renvoit un code 422
            return $this->json($dataErrors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Si pas d'erreur, on ajoute le film en bdd
        $entityManager->persist($movie);
        $entityManager->flush();
        

        //  On fournit le lien de la ressource créée
        return $this->json(["creation successful"], Response::HTTP_CREATED,[
            "Location" => $this->generateUrl("app_api_movie_getMovieById", ["id" => $movie->getId()])
        ]);
    }
}
