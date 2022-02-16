<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use App\Classe\Mail;


class UserEventSubscriber implements EventSubscriber
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     *
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!($entity instanceof User)) {
            return;
        }

        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        $changeArray = $unitOfWork->getEntityChangeSet($args->getObject());

        if (!isset($changeArray['customerValidate'])) {
            return;
        }

        if ($changeArray['customerValidate'][1] === $changeArray['customerValidate'][0]) {
            return;
        }

        if ($changeArray['customerValidate'][1] === true) {
            // send customerValidate contact mail
            $mail = new Mail();
            $content = "Bonne nouvelle votre compte STC-Immobilier est validé!!";
            $mail->send($entity->getEmail(),$entity->getFirstname(),'Votre compte STC-immobilier', $content );
        }
    }

}
