<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiService {

    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * Fetch a movie from the api OmdbApi
     *
     * @param Movie $movie an instance of a movie
     */
    public function fetch(Movie $movie){
        $response = $this->client->request(
            'GET',
            'http://www.omdbapi.com/',
            [
                "query" => [
                    "apikey" => $this->apiKey,
                    "t" => $movie->getTitle()
                ]
            ]
        );
        $content = $response->toArray();
        return($content);
    }

    /**
     * Get a poster for a movie from omdbApi
     *
     * @param Movie $movie an instance of a movie
     * @return string|null url of a poster or null if not found
     */
    public function fetchPoster(Movie $movie){
        $movieFromApi = $this->fetch($movie);
        if(!array_key_exists("Poster", $movieFromApi)){
            return null;
        }
        return $movieFromApi["Poster"];
    }
}
