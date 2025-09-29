<?php

namespace App\Charity\PaymentGateways;


class PaymentService 
{
    protected $paymentGateway;

    public function __construct(PaymentInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function process($format){
        $payment = $this->paymentGateway;
        $handler = config('payment.payments')[$format] ?? null;

    }
}