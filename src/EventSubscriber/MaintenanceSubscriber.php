<?php

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private $parameterBag;

    // ParameterBagInterface permet de récupérer les paramètres globaux définis dans le service.yaml 
    public function __construct(ParameterBagInterface $parameterBag){
        $this->parameterBag = $parameterBag;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if(!$this->parameterBag->get("app.maintenance")){
            return;
        }

        // Ne se déclenche pas dans le cas d'une sous-requête (ex: lors d'un code d'erreur, il y a une requête puis une sous requête, ce qui créerait un doublon)
        if(!$event->isMainRequest()){
            return;
        }

        $response = $event->getResponse();
        $content = $response->getContent();
        $newBody = str_replace("</nav>","</nav><div class='mt-2 alert alert-danger'>Maintenance prévue le ". $this->parameterBag->get('app.maintenance')." à 17h00</div>",$content);
        $response->setContent($newBody);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
