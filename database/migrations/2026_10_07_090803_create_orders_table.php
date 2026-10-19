<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_number')->unique();

            $table->string('status')->default('pending');

            $table->string('payment_status')->default('pending');

            $table->string('payment_method')->nullable();

            $table->string('currency', 3)->default('USD');

            $table->decimal('subtotal', 15, 2)->default(0);

            $table->decimal('shipping_amount', 15, 2)->default(0);

            $table->decimal('tax_amount', 15, 2)->default(0);

            $table->decimal('discount_amount', 15, 2)->default(0);

            $table->decimal('total_amount', 15, 2)->default(0);

            $table->string('shipping_name')->nullable();

            $table->string('shipping_email')->nullable();

            $table->string('shipping_phone')->nullable();

            $table->text('shipping_address')->nullable();

            $table->string('shipping_city')->nullable();

            $table->string('shipping_state')->nullable();

            $table->string('shipping_country')->nullable();

            $table->string('shipping_postal_code')->nullable();

            $table->text('customer_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};