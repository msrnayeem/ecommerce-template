<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id')->nullable();
            $table->uuid('variant_id')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('status', ['in_stock', 'out_of_stock'])->default('in_stock');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
