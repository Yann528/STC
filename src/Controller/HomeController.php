<?php

namespace App\Controller;


use App\Entity\Header;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
   
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $headers = $entityManager->getRepository(Header::class)->findAll();

        return $this->render('home/index.html.twig',[

         'headers'=> $headers   
        ]);
    }
}
