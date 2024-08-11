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
        Schema::create('vl_orders', function (Blueprint $table) {
            $table->id();
            $table->date('dateorder');
            $table->enum('docstatus',['O','C','A'])->default('O');
            $table->string('serial',10)->nullable();
            $table->string('documentno',15);
            $table->double('amount',12,2)->default();

            $table->foreignId('doctype_id');
            $table->foreign('doctype_id')->references('id')->on('vl_doc_types');

            $table->foreignId('sequence_id');
            $table->foreign('sequence_id')->references('id')->on('vl_sequences');

            $table->foreignId('bpartner_id');
            $table->foreign('bpartner_id')->references('id')->on('vl_bpartners');

            $table->foreignId('currency_id');
            $table->foreign('currency_id')->references('id')->on('vl_currencies');

            $table->foreignId('created_by');
            $table->foreign('created_by')->references('id')->on('vl_users');

            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');

            $table->string('token',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_orders');
    }
};
