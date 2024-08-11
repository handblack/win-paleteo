<?php

use App\Models\User;
use App\Models\VlPriceList;
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
        Schema::create('vl_pricelists', function (Blueprint $table) {
            $table->id();
            $table->string('identity',150);
            $table->string('shortname',30)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);

            $table->foreignId('currency_id');
            $table->foreign('currency_id')->references('id')->on('vl_currencies');

            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });
        VlPriceList::create([
            'identity'      => 'LISTA GENERAL',
            'shortname'     => 'MAIN',
            'token'         => User::get_token(),
            'created_by'    => 1,
            'currency_id'   => 1, 
        ]);
        VlPriceList::create([
            'identity'      => 'GRUPO 1 DOLARES',
            'shortname'     => 'G1D',
            'token'         => User::get_token(),
            'created_by'    => 1,
            'currency_id'   => 2, 
        ]);
        VlPriceList::create([
            'identity'      => 'GRUPO 2 DOLARES',
            'shortname'     => 'G2D',
            'token'         => User::get_token(),
            'created_by'    => 1,
            'currency_id'   => 2, 
        ]);
        VlPriceList::create(['shortname' => 'G3S','identity' => 'GRUPO 3 SOLES', 'token' => User::get_token(), 'created_by' => 1,'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G4S','identity' => 'GRUPO 4 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G5S','identity' => 'GRUPO 5 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G6S','identity' => 'GRUPO 6 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G7S','identity' => 'GRUPO 7 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G8S','identity' => 'GRUPO 8 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G9S','identity' => 'GRUPO 9 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G10S','identity' => 'GRUPO 10 SOLES', 'token' => User::get_token(), 'created_by' => 1,'currency_id' => '1'  ]);
        VlPriceList::create(['shortname' => 'G11S','identity' => 'GRUPO 11 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
        VlPriceList::create(['shortname' => 'G12S','identity' => 'GRUPO 12 SOLES', 'token' => User::get_token(), 'created_by' => 1, 'currency_id' => '1' ]);
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_pricelists');
    }
};
