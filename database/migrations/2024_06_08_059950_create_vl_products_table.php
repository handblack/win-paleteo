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
        Schema::create('vl_products', function (Blueprint $table) {
            $table->id();
            $table->string('productcode',15);  //SKU
            $table->string('productname',150);
            $table->string('token',60);
            $table->enum('isactive',['Y','N'])->default('Y');
            
            $table->foreignId('group_id');
            $table->foreign('group_id')->references('id')->on('vl_product_groups');

            $table->foreignId('familia_id');
            $table->foreign('familia_id')->references('id')->on('vl_product_familias');

            $table->foreignId('subfamilia_id');
            $table->foreign('subfamilia_id')->references('id')->on('vl_product_sub_familias');

            $table->foreignId('tejido_id');
            $table->foreign('tejido_id')->references('id')->on('vl_product_tejidos');
            
            $table->foreignId('hilatura_id');
            $table->foreign('hilatura_id')->references('id')->on('vl_product_hilaturas');

            $table->foreignId('titulo_id');
            $table->foreign('titulo_id')->references('id')->on('vl_product_titulos');

            $table->foreignId('gama_id');
            $table->foreign('gama_id')->references('id')->on('vl_product_gamas');

            $table->foreignId('tenido_id');
            $table->foreign('tenido_id')->references('id')->on('vl_product_tenidos');

            $table->foreignId('acabado_id');
            $table->foreign('acabado_id')->references('id')->on('vl_product_acabados');

            $table->foreignId('presentacion_id');
            $table->foreign('presentacion_id')->references('id')->on('vl_product_presentacions');

            $table->foreignId('um_id');
            $table->foreign('um_id')->references('id')->on('vl_product_ums');

            $table->foreignId('created_by');
            $table->foreign('created_by')->references('id')->on('vl_users');

            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_products');
    }
};
