<?php
namespace App\Controller\Purchase;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Security\Core\Security;

class PurchaseListController extends AbstractController
    {
    protected $security;

    public function __construct(Security $security){
        $this->security =$security;
    }
   
    /**
     * @Route("/purchases", name="purchase_list")
     * @IsGranted("ROLE_USER", message="vous devez être connecté pour acceder à vos commandes")
     */
    public function list()
    {
        /** @var User */
        $user = $this->getUser();        
        return $this->render('purchase_list/index.html.twig',[
            'purchases' => $user->getPurchases(),
        ]);


    }
}
