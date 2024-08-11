<?php

use App\Models\User;
use App\Models\VlSalesPerson;
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
        Schema::create('vl_sales_people', function (Blueprint $table) {
            $table->id();
            $table->string('identity',150);
            $table->string('shortname',30)->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone',10)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });

        VlSalesPerson::create([
            'identity'      => 'EJECUTIVO_1',
            'shortname'     => 'E1',
            'email'         => 'vendedor1@dominio.com',
            'phone'         => '987654321',
            'token'         => User::get_token(),
            'created_by'    => 1,
        ]);
        
        VlSalesPerson::create([
            'identity'      => 'EJECUTIVO_2',
            'shortname'     => 'E2',
            'email'         => 'vendedor2@dominio.com',
            'phone'         => '987654321',
            'token'         => User::get_token(),
            'created_by'    => 1,
        ]);

        VlSalesPerson::create([
            'identity'      => 'EJECUTIVO_3',
            'shortname'     => 'E3',
            'email'         => 'vendedor3@dominio.com',
            'phone'         => '987654321',
            'token'         => User::get_token(),
            'created_by'    => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_sales_people');
    }
};
