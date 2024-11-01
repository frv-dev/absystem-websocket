<?php

namespace App;

use App\Modules\Payment\Enums\Gateways;
use App\Modules\Payment\Services\GatewayService;
use MessagePack\MessagePack;

class Server
{
    public function __invoke(): void
    {
        $socket = new \ZMQContext();

        $socket = $socket->getSocket(\ZMQ::SOCKET_REP);
        $socket->bind('tcp://*:5555');

        while (true) {
            $paymentData = MessagePack::unpack($socket->recv());

            $id = $paymentData['id'];
            $customerName = $paymentData['customer_name'];
            $gateway = Gateways::get($paymentData['gateway']);

            if (is_null($gateway)) {
                echo "GATEWAY INVÁLIDO" . PHP_EOL;
            }

            $payment = new GatewayService($gateway);
            $payment->make("PayID: $id, Customer Name: $customerName");

            $socket->send(MessagePack::pack(['message' => 'Ok']));
        }
    }
}
