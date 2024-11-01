<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\WalletRegister;
use App\Modules\Payment\Enums\PaymentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CUSTOMERS
        $customers = collect([
            'john' => new Customer(['name' => 'John']),
            'doe' => new Customer(['name' => 'Doe']),
            'ella' => new Customer(['name' => 'Ella']),
        ]);

        DB::transaction(
            fn() => $customers->each(
                fn(Customer $customer) => $customer->save()
            )
        );

        // PRODUCTS
        $products = collect([
            'computer' => new Product(['name' => 'Computer', 'price' => 3500]),
            'mouse' => new Product(['name' => 'Mouse', 'price' => 100]),
            'keyboard' => new Product(['name' => 'Teclado', 'price' => 200]),
            'monitor' => new Product(['name' => 'Monitor', 'price' => 800]),
        ]);

        DB::transaction(
            fn() => $products->each(
                fn(Product $product) => $product->save()
            )
        );

        // ORDERS
        $orders = collect([
            'john_01' => new Order(['price' => 3500, 'customer_id' => $customers['john']->id]),
            'doe_01' => new Order(['price' => 300, 'customer_id' => $customers['doe']->id]),
            'ella_01' => new Order(['price' => 800, 'customer_id' => $customers['ella']->id]),
            'john_02' => new Order(['price' => 1100, 'customer_id' => $customers['john']->id]),
        ]);

        DB::transaction(
            fn() => $orders->each(
                fn(Order $order) => $order->save()
            )
        );

        // ORDER ITEMS
        DB::beginTransaction();

        $orders['john_01']->products()->attach([
            $products['computer']->id,
        ]);

        $orders['doe_01']->products()->attach([
            $products['mouse']->id,
            $products['keyboard']->id,
        ]);

        $orders['ella_01']->products()->attach([
            $products['monitor']->id,
        ]);

        $orders['john_02']->products()->attach([
            $products['mouse']->id,
            $products['keyboard']->id,
            $products['monitor']->id,
        ]);

        DB::commit();

        // PAYMENTS
        $payments = collect([
            'john_01' => new Payment(['status' => PaymentStatus::Paid->value, 'order_id' => $orders['john_01']->id]),
            'doe_01' => new Payment(['status' => PaymentStatus::Paid->value, 'order_id' => $orders['doe_01']->id]),
            'ella_01' => new Payment(['status' => PaymentStatus::Paid->value, 'order_id' => $orders['ella_01']->id]),
            'john_02' => new Payment(['status' => PaymentStatus::Paid->value, 'order_id' => $orders['john_02']->id]),
        ]);

        DB::transaction(
            fn() => $payments->each(
                fn(Payment $payment) => $payment->save()
            )
        );

        // WALLETS
        $wallet = new Wallet(['name' => 'Principal', 'value' => 5700]);
        $wallet->save();

        // WALLET REGISTERS
        $walletRegisters = collect([
            'john_01' => new WalletRegister(['price' => $orders['john_01']->price, 'wallet_id' => $wallet->id, 'payment_id' => $payments['john_01']->id]),
            'doe_01' => new WalletRegister(['price' => $orders['doe_01']->price, 'wallet_id' => $wallet->id, 'payment_id' => $payments['doe_01']->id]),
            'ella_01' => new WalletRegister(['price' => $orders['ella_01']->price, 'wallet_id' => $wallet->id, 'payment_id' => $payments['ella_01']->id]),
            'john_02' => new WalletRegister(['price' => $orders['john_02']->price, 'wallet_id' => $wallet->id, 'payment_id' => $payments['john_02']->id]),
        ]);

        DB::transaction(
            fn() => $walletRegisters->each(
                fn(WalletRegister $walletRegister) => $walletRegister->save()
            )
        );
    }
}
