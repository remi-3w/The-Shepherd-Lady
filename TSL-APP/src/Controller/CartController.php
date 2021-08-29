<?php

namespace App\Controller;


use App\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{    
    protected $productRepository;
    protected $cartService;

    public function __construct(ProductRepository $productRepository, CartService $cartService)
    {
    $this->productRepository = $productRepository;
    $this->cartService = $cartService;
    }


    /**
     * @Route("/cart/add/{id}", name="cart_add", requirements ={"id" : "\d+"})
     */
    public function Add($id, Request $request): Response
    {        
        $product= $this->productRepository->find($id);

            if (!$product){
                throw $this->createNotFoundException("Le produit n'existe pas");
            }

            $this->cartService->add($id);       
      
            $this->addFlash('success' , "Le produit a bien été ajouté au panier");

                return $this->redirectToRoute('cart_show', [
                    'slug' => $product->getslug()
                ]);
        }

    /**
     * @Route("/cart/delete/{id}", name="cart_delete" , requirements={"id":"\d+"} )
     */
    public function delete($id, Request $request)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException("ce produit n'existe pas et ne peux pas être supprimé !");
        }

        $this->cartService->remove($id);

        $this->addFlash('success', "Le produit à bien été retiré du panier");

        return $this->redirectToRoute('cart_show');
    }


    /**
     * @Route("/cart/decrement/{id}", name ="cart_decrement",requirements={"id":"\d+"})
     */
    public function decrement($id, Request $request ){
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException("ce produit n'existe pas et ne peux pas être réduit !");
        }
        $this->cartService->decrement($id);
        $this->addFlash('success', "la quantité de ce produit à été modifiée.");   
        return $this->redirectToRoute('cart_show');
    }
    
    /**
     * @Route("/cart/", name="cart_show")
     */
    public function show(): Response
    {
       $detailsCart = $this->cartService->getDetailCartItem();

       $total = $this->cartService->getTotal();

       $quantities =$this->cartService->getQuantities();
     
       

        return $this->render('cart/index.html.twig',[
            'items' => $detailsCart,
            'total' => $total,
            'quantities' => $quantities
           
        ]);
    }
    
       
    }

