<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offer_products', function (Blueprint $table) {
            $table->uuid('offer_id');
            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');
            $table->primary(['offer_id', 'product_id']);
            $table->unique(['offer_id', 'product_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_products');
    }
};