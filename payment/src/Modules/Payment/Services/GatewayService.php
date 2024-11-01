<?php

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Enums\Gateways;
use App\Modules\Payment\Interfaces\PaymentGatewayInterface;

class GatewayService implements PaymentGatewayInterface
{
    private PaymentGatewayInterface $paymentGateway;

    public function __construct(private Gateways $gateway)
    {
        $this->paymentGateway = new $this->gateway->value;
    }

    public function make(string $message): void
    {
        $this->paymentGateway->make($message);
    }
}