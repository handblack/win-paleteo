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
        Schema::create('vl_invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('currency_id');
            $table->foreign('currency_id')->references('id')->on('vl_currencies');

            $table->foreignId('doctype_id');
            $table->foreign('doctype_id')->references('id')->on('vl_doc_types');
            
            $table->foreignId('bpartner_id');
            $table->foreign('bpartner_id')->references('id')->on('vl_bpartners');

            $table->string('token',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_invoices');
    }
};
