<?php

use App\Models\User;
use App\Models\VlProductAcabado;
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
        Schema::create('vl_product_acabados', function (Blueprint $table) {
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
        
        VlProductAcabado::create(['identity' => '--','token' => User::get_token()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_product_acabados');
    }
};
