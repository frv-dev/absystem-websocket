<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const string TABLE = 'wallet_registers';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable(self::TABLE)) {
            Schema::create(self::TABLE, function (Blueprint $table) {
                $table->uuid('id')->unique()->primary()->default(DB::raw('uuid_generate_v4()'));
                $table->decimal('price', 10, 2);

                $table->uuid('wallet_id')->index();
                $table->foreign('wallet_id')
                    ->references('id')
                    ->on('wallets')
                    ->onDelete('cascade');

                $table->uuid('payment_id')->nullable()->index();
                $table->foreign('payment_id')
                    ->references('id')
                    ->on('payments')
                    ->onDelete('cascade');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_registers');
    }
};
