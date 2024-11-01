<?php

namespace App\Modules\Payment\Interfaces;

interface PaymentGatewayInterface
{
    public function make(string $message): void;
}