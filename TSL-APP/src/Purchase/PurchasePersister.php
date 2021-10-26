<?php

namespace App\Purchase;

use DateTimeImmutable;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PurchasePersister
{
    protected $security;  
    protected $cartService;
    protected $em;
    

    public function __construct(EntityManagerInterface $em, Security $security, CartService $cartService )
    {
        $this->em = $em;
        $this->security = $security;
        $this->cartService= $cartService;
    }

    public function storePurchase(Purchase $purchase)
    {
        $purchase->setUser($this->security->getUser())
                ->setPurchaseAt(new DateTimeImmutable())
                ->setTotal($this->cartService->getTotal());
        $this->em->persist($purchase);
        foreach($this->cartService->getDetailedCartItems() as $cartItem)
            {
            $purchaseItem = new PurchaseItem;
            $purchaseItem->setPurchase($purchase)
                ->setProduct($cartItem->product)
                ->setProductName($cartItem->product->getName())
                ->setQuantity($cartItem->qty)
                ->setTotal($cartItem->getTotal())
                ->setProductPrice($cartItem->product->getPrice());
            $this->em->persist($purchaseItem);
            }
       
        $this->em->flush();
    }        
}

 
 