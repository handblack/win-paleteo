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
        Schema::create('vl_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('identity',100)->nullable();
            $table->string('shortname',50)->nullable();
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
        Schema::dropIfExists('vl_reasons');
    }
};
