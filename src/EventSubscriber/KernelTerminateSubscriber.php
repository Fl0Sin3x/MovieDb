<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class KernelTerminateSubscriber implements EventSubscriberInterface
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelTerminate(TerminateEvent $event)
    {
        // Récupérons la route demandé lors dûne requête
        $route = $event->getRequest()->getRequestUri();

        // On récupère le code de status de réponse
        $statusCode = $event->getResponse()->getStatusCode();

        //On prend ces deux informations et on les ajoute dans un fichier de log
        // Pour ça on utilise le loggeur de symfony
        // Il va enregistrer ce qu'on sohaite dans /var/log/dev.log

        $this->logger->info('Coucou, quelqu\'un a visité '.$route.' et a obtenu un code '. $statusCode);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.terminate' => 'onKernelTerminate',
        ];
    }
}
