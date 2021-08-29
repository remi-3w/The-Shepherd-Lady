<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\String\Slugger\SluggerInterface;

class ShopController extends AbstractController
{
        protected $slugger; 

        public function __construct(SluggerInterface $slugger)
        {
            $this->slugger = $slugger;

        }


    /**
     * @Route("/boutique", name="shop")
     */
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products= $productRepository->findAll();
        $categories = $categoryRepository->findAll();
        // dd($categories);
     

        return $this->render('shop/index.html.twig', [
                        'products' => $products,
                        'categories' => $categories
        ]);
    }
    
    /**
     * @Route("admin/product/new", name="shop_product/new")
     */
    public function new(EntityManagerInterface $em , Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form -> handleRequest($request);
        if ($form->isSubmitted()){
                $product = $form->getData();
                $product->setSlug(strtolower($this->slugger->slug($product->getName())));                 
                $em->persist($product);
                $em->flush();
                
                return $this->redirectToRoute('shop');
       }


        return $this->render('shop/shopform.html.twig', [            
            'form' => $form->createView(),            
        ]);
    }

    /**
     * @Route("/product/{id}", name="shop_product")
     */
    public function product($id): Response

    {           
        return $this->render('shop/index.html.twig');
    }

    /**
     * @Route("/admin/product/{id}/edit/", name="shop_editproduct")
     */
    public function EditProduct($id, ProductRepository $productRepository, EntityManagerInterface $em, Request $request)
    {
        $product = $productRepository->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form ->handleRequest($request);
        if($form->isSubmitted()){            
            $em->flush();
            return $this->redirectToRoute('shop');
        } 
        $formView = $form->createView();

        return $this->render('shop/shopform.html.twig', [
            'product' => $product,
            'form' => $formView,     
        ]);
    }

    /**
     * @Route("/admin/product/{id}/delete", name="shop_deleteproduct")
     */
    public function DeleteProduct($id,ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
            $product = $productRepository->find($id);           
            $em->remove($product);
            $em->flush();
        return $this->redirectToRoute('shop');



        return $this->render('shop/index.html.twig', [
           
        ]);
    }


}
