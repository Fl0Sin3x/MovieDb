<?php

namespace App\Command;

use App\Repository\MovieRepository;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieSlugifyAllCommand extends Command
{
    protected static $defaultName = 'app:movie:slugify-all';

    private $movieRepository;
    private $slugger;

    public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository, Slugger $slugger)
    {
        // La classe Command a aussi un constructeur
        // En utilisant notre propre constructeur, nous avons écrasé celui de la classe parente, Command
        // Pour l'exécuter aussi :
        parent::__construct();

        $this->em = $em;
        $this->movieRepository = $movieRepository;
        $this->slugger = $slugger;
    }

    protected function configure()
    {
        $this
            ->setDescription('Calcule et met à jour le slug de tous les films en base de données')
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }
        $movies = $this->movieRepository->findAll();

        foreach ($movies as $movie){
            $slug = $this->slugger->slugify($movie->getTitle());
            $movie->setSlug($slug);
        }

        $this->em->flush();
        $io->success('Tout les films on un slug');

        // Dans un terminal, une commande qui fonctionne, retourne toujours 0
        // C'est une convention, ce n'est pas lié à Symfony mais bien au fonctionnement d'un terminal
        // Depuis Symfony 4.4 , il est obligatoire de retourné 0
        // Avant Symfony 4.4 , un mécanisme dans Symfony retournerais 0 si rien n'étais retourné par la commande
        return 0;
    }
}
