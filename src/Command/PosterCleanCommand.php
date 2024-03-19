<?php

namespace App\Command;

use App\Entity\Movie;
use App\Service\OmdbApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PosterCleanCommand extends Command
{
    // le nom de la commande
    protected static $defaultName = 'app:poster-clean';
    // la description de la commande
    protected static $defaultDescription = 'Replace broken image link from movies';

    private $entityManager;
    private $omdbApiService;

    public function __construct(EntityManagerInterface $entityManager, OmdbApiService $omdbApiService){

        // les dépendances de la commande
        $this->entityManager = $entityManager;
        $this->omdbApiService = $omdbApiService;

        // nécessaire de rappeler le constructeur du parent
        parent::__construct();
    }

    // la configuration de la commande
    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    // input & output servent à générer l'objet SymfonyStyle pour styliser la commande
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Démarrage de la commande');
        $io->progressStart(100);
        
        // les actions à réaliser
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();
        foreach($movies as $movie) {
            $newPoster = $this->omdbApiService->fetchPoster($movie);
            if($newPoster){
                $movie->setPoster($newPoster);
            }
        }

        $io->progressAdvance(100);
        $io->progressFinish();
        
        $this->entityManager->flush();

        $io->success('Les posters ont été mis à jour');

        return Command::SUCCESS;
    }
}
