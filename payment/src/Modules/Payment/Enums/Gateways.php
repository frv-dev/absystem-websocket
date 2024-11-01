<?php

namespace App\Modules\Payment\Enums;

use App\Modules\Payment\Services\IuguGatewayService;
use App\Modules\Payment\Services\VindiGatewayService;

enum Gateways: string
{
    case VINDI = VindiGatewayService::class;
    case IUGU = IuguGatewayService::class;

    public static function get(string $gateway): ?self
    {
        return match ($gateway) {
            'vindi' => self::VINDI,
            'iugu' => self::IUGU,
            default => null,
        };
    }
}
