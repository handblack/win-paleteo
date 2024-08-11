<?php

use App\Models\User;
use App\Models\VlProductFamilia;
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
        Schema::create('vl_product_familias', function (Blueprint $table) {
            $table->id();
            $table->string('identity',150);
            $table->string('shortname',30)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });
        VlProductFamilia::create(['identity' => '-- SIN FAMILIA --','token' => User::get_token(),'created_by' => 1]);
        VlProductFamilia::create(['identity' => 'TELA ACABADA','token' => User::get_token(),'created_by' => 1]);
        VlProductFamilia::create(['identity' => 'TELA TEÑIDA','token' => User::get_token(),'created_by' => 1]);
        VlProductFamilia::create(['identity' => 'HILADO','token' => User::get_token(),'created_by' => 1]);
        VlProductFamilia::create(['identity' => 'SS TEJIDO','token' => User::get_token(),'created_by' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_product_familias');
    }
};
