<?php

namespace App\Controller;
use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
   

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
    {
        $notification = null;

        $user =  new User();
        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
            
            if(!$search_email){

                $password = $encoder->encodePassword($user,$user->getPassword());

                $user->setPassword($password);
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $content = "Bonjour ".$user->getFirstname()." " .$user->getLastname()."
                Merci de bien vouloir patienter que STC valide votre inscription";

                /*$email = (new Email())
                    ->from('contact@stc-immobilier.fr')
                    ->to($user->getEmail())
                    ->subject('Bienvenue sur STC')
                    ->text($content)
                    ->html(nl2br($content));

                $mailer->send($email);*/


                $mail = new Mail();
                $content = "Bonjour".$user->getFirstname()."
                <br/>
                Bienvenue sur STC Conseil en immobilier d'entreprise<br><br/>
                merci de bien vouloir patienter que nous valider votre inscription<br><br/>
                Constituendi autem sunt qui sint in amicitia fines et quasi termini diligendi.
                De quibus tres video sententias ferri, quarum nullam probo, unam, 
                ut eodem modo erga amicum adfecti simus, quo erga nosmet ipsos, alteram,
                ut nostra in amicos benevolentia illorum erga nos benevolentiae pariter
                aequaliterque respondeat, tertiam, ut, quanti quisque se ipse facit, tanti fiat ab amicis.";
                $mail->send($user->getEmail(),$user->getFirstname(),'Bienvenue sur STC', $content );
                
                $notification = "Votre inscription s'est correctement déroulée. 
                Vous pouvez dés a present vous connecter à votre compte.";

            }else{

                $notification = "L'email que vous avez renseigné existe déjà.";


            }


        }

        return $this->render('register/index.html.twig',[
            'form'=> $form->createView(),
            'notification'=>$notification
        ]);
    }
}
