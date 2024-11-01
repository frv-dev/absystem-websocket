<?php

namespace App\Modules\Payment\Enums;

enum PaymentGateways: string
{
    case IUGU = 'iugu';
    case VINDI = 'vindi';
}
