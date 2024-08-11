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
        Schema::create('vl_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('vl_invoices');
            $table->string('token',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_invoice_lines');
    }
};
