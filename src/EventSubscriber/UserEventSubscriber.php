<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Classe\Mail;


class UserEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     *
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getEntity();
        if (!($entity instanceof User)) {
            return;
        }

        if ($args->hasChangedField('customerValidate') && $args->getNewValue('customerValidate') == 'true') {
            
            // send customerValidate contact mail
            $content = "Bonjour ".$entity->getFirstname()." " .$entity->getLastname()."
                Message customerValidate";

            $mail = new Mail();
            $mail->send($entity->getEmail(),$entity->getFirstname(),'Bienvenue sur STC', $content );
        }
        
    }

}