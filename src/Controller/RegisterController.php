<?php

namespace App\Controller;
use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $notification = null;

        $user =  new User();
        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            /** @var UserRepository $userRepo */
            $userRepo = $this->entityManager->getRepository(User::class);
            $search_email = $userRepo->findOneByEmail($user->getEmail());
            
            if(!$search_email){

                $password = $encoder->encodePassword($user,$user->getPassword());

                $user->setPassword($password);
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $content = "Bonjour ".$user->getFirstname()." " .$user->getLastname()."
                Merci de bien vouloir patienter que STC-Immobilier valide votre inscription";

                $mail = new Mail();
                $content = "Bonjour ".$user->getFirstname()."
                <br/>
                Bienvenue sur STC Conseil en immobilier d'entreprise.<br>
                Merci de bien vouloir patienter que nous valider votre inscription.<br>
                Vous recevrez prochainement un nouvel email de validation de votre compte.<br>
                Ainsi vous pourrez profiter de nos offres privilèges dans le menu -> Nos offres.<br>
                Nous restons à votre disposition pour tout complément d'information.<br><br/>
                STC Immobilier<br>
                Vous souhaitant une excellente journée.";
                $mail->send($user->getEmail(),$user->getFirstname(),'Bienvenue sur STC', $content );
    
                $notification = "Votre inscription s'est correctement déroulée. 
                Merci de bien vouloir patienter que STC-Immobilier valide votre inscription,
                vous recevrez un email de confirmation.";

                usleep(500);

                $messagemail="Nouveau client.<br><br/>
                Vous avez une nouvelle création de compte a validé.<br>
                Merci de le faire dans les plus brefs délais.<br><br>
                -> Mon compte  -> Back-office  ->User  ->Customer validate.<br><br>
                Bonne journée ;-) ";

                $mailAdmin = new Mail();
                $mailAdmin->send($_ENV['EMAIL_ADMIN'],'STC-Immobilier','Nouveau client',$messagemail);

                return $this->redirectToRoute('account');

            }else{

                $notification = "L'email que vous avez renseigné existe déjà.";


            }


        }

        return $this->render('register/index.html.twig',[
            'form'=> $form->createView(),
            'notification'=>$notification
        ]);
    }

    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmation(Request $request)
    {
        return $this->render('register/confirmation.html.twig',[
        ]);

    }
}
