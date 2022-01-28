<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class UserEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MailerInterface;
     */
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
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

                $email = (new Email())
                    ->from('yanncochard@hotmail.fr')
                    ->to($entity->getEmail())
                    ->subject('customerValidate title')
                    ->text($content)
                    ->html(nl2br($content));

                $this->mailer->send($email);
        }
        
    }

}