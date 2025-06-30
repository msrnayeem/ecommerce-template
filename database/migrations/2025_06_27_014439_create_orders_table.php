<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_name', 100);
            $table->string('customer_email', 100)->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->string('shipping_address');
            $table->string('shipping_method', 100)->nullable();
            $table->text('order_notes')->nullable();
            $table->string('coupon', 50)->nullable();
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->enum('shipping_status', ['pending', 'shipped', 'delivered', 'returned'])->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_id', 150)->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('payment_status');
            $table->index('shipping_status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};