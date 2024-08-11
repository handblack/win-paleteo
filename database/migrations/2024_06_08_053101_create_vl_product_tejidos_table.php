<?php

use App\Models\User;
use App\Models\VlProductTejido;
use App\Models\VlProductTenido;
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
        Schema::create('vl_product_tejidos', function (Blueprint $table) {
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
        
        VlProductTejido::create(['identity' => '--','token' => User::get_token(),'created_by' => 1]);
        VlProductTejido::create(['identity' => 'JERSEY','token' => User::get_token(),'created_by' => 1]);
        VlProductTejido::create(['identity' => 'GAMUZA','token' => User::get_token(),'created_by' => 1]);
        VlProductTejido::create(['identity' => 'FRANELA','token' => User::get_token(),'created_by' => 1]);
        VlProductTejido::create(['identity' => 'PIQUE','token' => User::get_token(),'created_by' => 1]);
        VlProductTejido::create(['identity' => 'RIB','token' => User::get_token(),'created_by' => 1]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_product_tejidos');
    }
};
