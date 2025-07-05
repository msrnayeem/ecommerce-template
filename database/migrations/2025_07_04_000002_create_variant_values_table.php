<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_values', function (Blueprint $table) {
            $table->primar('id');
            $table->uuid('variant_id');
            $table->string('name', 100);
            $table->string('color_code', 7)->nullable(); // For color variants: #FF0000
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_values');
    }
};
