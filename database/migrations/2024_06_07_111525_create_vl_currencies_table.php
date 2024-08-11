<?php

use App\Models\User;
use App\Models\VlCurrency;
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
        Schema::create('vl_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currencyname',60);
            $table->string('currencycode',10);
            $table->string('prefix',10)->nullable();
            $table->string('suffix',10)->nullable();
            $table->string('shortname',10)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });
        $u = new VlCurrency();
        $u->currencyname    = 'SOLES';
        $u->currencycode    = 'PEN';
        $u->prefix          = 'S/';
        $u->isactive        = 'Y';
        $u->token           = User::get_token();
        $u->save();

        $u = new VlCurrency();
        $u->currencyname    = 'DOLARES AMERICANOS';
        $u->currencycode    = 'USD';
        $u->prefix          = '$';
        $u->isactive        = 'Y';
        $u->token           = User::get_token();
        $u->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_currencies');
    }
};
