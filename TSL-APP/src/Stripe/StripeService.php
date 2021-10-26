<?php

namespace App\Stripe;

use Stripe\Stripe;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;

class StripeService {
    protected $secretKey;
    protected $publicKey;

    public function __construct(string $secretKey,string $publicKey)
    {
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }
   
    public function getPaymentIntent(Purchase $purchase){
        \Stripe\Stripe::setApiKey($this->secretKey);
//sk_test_51JfkseDkQ4vmM9lSoFTSzsVfwJAjTtbCoOMHpuStEJqGDzsEfyTCOi9fkxVlJaBsTLNWHujwrXEPKgXzebWkcyYe00JdbwHBcS
        return \Stripe\PaymentIntent::create([
            'amount' => $purchase->getTotal(),
            'currency' => 'eur',
        ]);  

    }
    
  
}