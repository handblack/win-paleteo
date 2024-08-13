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
        Schema::create('vl_paloteos', function (Blueprint $table) {
            $table->id();            
            $table->date('datetrx');
            $table->string('nodo',30)->nullable();
            $table->string('documentno',15)->nullable();
            $table->string('did',15)->nullable();
            $table->string('comment',200)->nullable();
            $table->string('program',100)->nullable();
            $table->string('month',2)->nullable();
            $table->enum('isincidencia',['Y','N']);
            $table->foreignId('incidencia_id')->nullable();  // solo maneja dentro del select valores fijos

            $table->foreignId('subreason_id');
            $table->foreign('subreason_id')->references('id')->on('vl_sub_reasons');


            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
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
        Schema::dropIfExists('vl_paloteos');
    }
};
