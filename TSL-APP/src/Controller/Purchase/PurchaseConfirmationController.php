<?php
namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Purchase\PurchasePersister;
use App\Form\PurchaseConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseConfirmationController extends AbstractController
{
    protected $em;
    protected $cartService;
    protected $persister;

    public function __construct(EntityManagerInterface $em, CartService $cartService,PurchasePersister $persister )
        {
            $this->em = $em;   
            $this->cartService = $cartService;
            $this->persister = $persister;
        
        }

   /**
     *@Route("/purchase/confirmation", name="purchase_confirm", priority=-1)  
     *@IsGranted("ROLE_USER", message="vous devez être connecté pour acceder à vos commandes")
     */
    public function confirm(Request $request ) {
        $form = $this->createForm(PurchaseConfirmationType::class);
        $form ->handleRequest($request);

            if(!$form->isSubmitted())
            {
                $this->addFlash('warning' , 'vous devez remplir le formulaire de confirmation');      
                return $this->redirectToRoute('cart_show');
            }

        $cartItems = $this->cartService->getDetailedCartItems();        
        if(!$cartItems === 0){
            $this->addFlash('warning', 'Vous ne pouvez pas confirmer un panier vide');       
            return $this->redirectToRoute('cart_show');
        }

        /** @var Purchase */
        $purchase = $form->getData();
        $this->persister->storePurchase($purchase);

       
        return $this->redirectToRoute('purchase_payment_form', [
            'id' => $purchase->getId()
        ]);
    }
}
