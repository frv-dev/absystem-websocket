<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Modules\Payment\Enums\PaymentGateways;
use App\Modules\Payment\Enums\PaymentStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use MessagePack\MessagePack;

class ProcessPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REQ);
        $queue->connect("tcp://php-payment:5555");

        while (true) {
            $payments = Payment::query()->where('status', PaymentStatus::Pending->value)->get();

            if ($payments->isEmpty()) {
                $this->print('None payment found.');
                sleep(1);
                continue;
            }

            $this->print("{$payments->count()} payments found.");

            foreach ($payments as $payment) {
                $payment->update(['status' => PaymentStatus::Processing->value]);

                $data = MessagePack::pack([
                    'id' => $payment->id,
                    'customer_name' => $payment->order?->customer?->name,
                    'gateway' => PaymentGateways::IUGU->value,
                ]);
                $queue->send($data);

                $message = MessagePack::unpack($queue->recv())['message'];
                $this->print($message);

                $payment->update(['status' => PaymentStatus::Paid->value]);
            }

            $this->print('Payments updated');

            sleep(1);
        }
    }

    private function print(string $message): void
    {
        echo '[' . Carbon::now()->format('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
