<?php

namespace App\EventSubscriber;

use App\Repository\MovieRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class RandomMovieSubscriber implements EventSubscriberInterface
{
    private $movieRepository;
    private $twig;

    public function __construct(MovieRepository $movieRepository, Environment $twig){

        $this->movieRepository = $movieRepository;
        $this->twig = $twig;
    }
    public function onKernelController(ControllerEvent $event): void
    {
        $randomMovie = $this->movieRepository->findRandomMovie();
        $this->twig->addGlobal("randomMovie", $randomMovie);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
