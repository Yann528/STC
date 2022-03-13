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
            $content = "Bonjour ".$entity->getFirstname()."
                <br/><br/>
                <strong>🎉🎉 Félicitation !</strong><br/><br/>
                Votre copte STC-Immobilier vient d'être validé.✅<br/>
                Vous pouvez dès à présent profiter de nos offres privilèges.<br/>
                <a href='https://www.stc-immobilier.fr/connexion'> Accéder à mon compte</a><br/><br/>
                STC-Immobilier<br>
                Vous souhaitant une excellente journée.";
            $mail->send($entity->getEmail(),$entity->getFirstname(),'Votre compte STC-immobilier est validé', $content );
        }
    }

}
