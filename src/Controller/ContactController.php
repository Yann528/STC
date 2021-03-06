<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use App\Classe\MailContact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */


    public function index(Request $request): Response
    {
        $mailContact = new MailContact();


        $form=$this->createForm(ContactType::class, $mailContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $this->addFlash('notice','Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');
            
            $messagemail = "Nom: ". $mailContact->nom."</br>";
            $messagemail .= "Prénom: ". $mailContact->prenom."</br>";
            $messagemail .= "Email: ". $mailContact->email."</br>";
            $messagemail .= "telephone: ". $mailContact->telephone."</br>";
            $messagemail .= "societe: ". $mailContact->societe."</br>";
            $messagemail .= "Text: ".nl2br($mailContact->content)."</br>";

           /* $email = (new Email())
            ->from('yanncochard@hotmail.fr')
            ->to('yanncochard@hotmail.fr')
            ->subject('Nouvelle demande de contact')
            ->text('Vous avez une nouvelle demande de contact'.$messagemail)

        $mailer->send($email); */

            $mail = new Mail();
            $mail->send($_ENV['EMAIL_ADMIN'],'STC','Nouvelle demande de contact',$messagemail);
        }

        return $this->render('contact/index.html.twig',[
            'form'=> $form->createView()

        ]);
    }
}
