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
        Schema::create('vl_pricelist_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricelist_id');
            #$table->foreign('pricelist_id')->references('id')->on('vl_pricelists');
            #$table->string('identity',150);
            #$table->string('shortname',30)->nullable();

            $table->foreignId('product_id');
            #$table->foreign('product_id')->references('id')->on('vl_products');

            $table->decimal('priceunit',10,6)->default(0);
            $table->decimal('priceunit_wtax',10,6)->default(0);

            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->unique(['pricelist_id','product_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_pricelist_lines');
    }
};
