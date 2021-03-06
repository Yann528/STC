<?php

namespace App\Controller;

use DateTime;
use App\Classe\Mail;
use App\Entity\User;
use DateTimeImmutable;
use App\Classe\MailContact;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()){
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')){
            $user = $this->entityManager->getRepository( User::class)->findOneByEmail($request->get('email'));
            if ($user) {
                    // 1 : Enregistrer en base la demande de reset_password avec user / token / CreatedAt. 
                    $reset_password = new ResetPassword();
                    $reset_password->setUser($user);
                    $reset_password->setToken(uniqid());
                    $reset_password->setCreatedAt(new DateTimeImmutable());
                    $this->entityManager->persist($reset_password);
                    $this->entityManager->flush();

                    // 2 : Envoyer un mail a l'utilisateur avec un lien pour mettre a jour son mot de passe.

                    $url = $this->generateUrl('update_password',[
                        'token'=> $reset_password->getToken()
                    ]);

                    $content = "Bonjour ".$user->getFirstname()." Vous avez demandé à réinitialiser votre mot de passe sur STC ";
                    $content .= "Merci de bien vouloir cliquer sur <a href='".$url."'> mettre à jour votre mot de passe.</a><br/>";
                    $content.= "<p>Veuillez cliquer sur le lien suivant: $url</p>";
                    $mailContact = new Mail();
                    $mailContact->send($user->getEmail(), $user->getFirstname().''. $user->getlastname(), 'Réinitialiser votre mot de passe sur STC.',$content);

                    $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail avec la procédure pour réinitialiser votre mot de passe.');

            } else {
                $this->addFlash('notice', 'Cette adresse email est inconnue');
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

     /**
     * @Route("/modifier-mon-mot-de-passe/{token}", name="update_password")
     */
    public function update(Request $request, $token,UserPasswordEncoderInterface $encoder ): Response
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        if (!$reset_password){

            return $this->redirectToRoute('reset_password');
        }
        // Vérifier si le creatdAt =new - 3h
        $now = new \DateTime();
        if ($now > $reset_password->getCreateAt()->modify('+ 3 hour')) {

            $this->addFlash('notice', 'Votre demande de mot de passe a expiré. Merci de la renouveller.');
            return $this->redirectToRoute('reset_password');

        }

        //rendre une vue avec mot de passe et confirmez votre mot de passe.
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $new_pwd = $form->get('new_password')->getData();
             
            //encodage des mots de passe.
            $password = $encoder->encodePassword($reset_password->getUser(), $new_pwd);
            $reset_password->getUser()->setPassword($password);

            //flush en base de donnée.
            $this->entityManager->flush();


            
            //redirection de l'utilisateur vers la page de connexion.
            $this->addFlash('notice', 'Votre mot de passe a bien été mis a jour.');
            return $this->redirectToRoute('app_login');

        }


        return $this->render('reset_password/update.html.twig',[
            'from'=> $form
        ]);

    }
}
