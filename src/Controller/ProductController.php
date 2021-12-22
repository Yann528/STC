<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
//use Doctribe\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(ORMEntityManagerInterface $entityManager)
    {
       $this->entityManager = $entityManager; 
    }

    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(Request $request): Response
    {
   
        $user = $this->getUser();
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
             
            /** @var ProductRepository */
            $productRepo = $this->entityManager->getRepository(Product::class);
            $customerValidate = false;
            if ( empty($user) == false && $user->isCustomerValidate() == true){
                $customerValidate = true;
            }
            $products = $productRepo->findWithSearch($search, $customerValidate);
           

        } else { 


            
            if ( empty($user) == false && $user->isCustomerValidate() == true){

                $products = $this->entityManager->getRepository(Product::class)->findAll();
            } else {
                $products = $this->entityManager->getRepository(Product::class)->findBy([
                    'offrepro'=> false

                ]);


            }
        } 


       

        return $this->render('product/index.html.twig',[
            'products'=>$products,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        

        
        if(!$product){
            return $this->redirectToRoute('products');

        }

        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
