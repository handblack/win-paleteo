<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temp_id');
            $table->foreign('temp_id')->references('id')->on('temp_headers');

            $table->foreignId('product_id');
            $table->foreign('product_id')->references('id')->on('vl_products');
            $table->string('token',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_lines');
    }
};
