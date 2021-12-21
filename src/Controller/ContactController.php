<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\MailContact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
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
            $messagemail .= "Text: ".nl2br($mailContact->content)."</br>";

            $mail = new Mail();
            $mail->send('yanncochard@hotmail.fr','STC','Nouvelle demande de contact',$messagemail);
        }

        return $this->render('contact/index.html.twig',[
            'form'=> $form->createView()

        ]);
    }
}
