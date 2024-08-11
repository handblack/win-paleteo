<?php

use App\Models\User;
use App\Models\VlProductGama;
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
        Schema::create('vl_product_gamas', function (Blueprint $table) {
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
        VlProductGama::create(['identity' => '--','token' => User::get_token()]);
        VlProductGama::create(['identity' => 'CLARO','token' => User::get_token()]);
        VlProductGama::create(['identity' => 'OSCURO','token' => User::get_token()]);
        VlProductGama::create(['identity' => 'OSCURO REACTIVO','token' => User::get_token()]);
        if(env('APP_ENV','local')){
            $t = [
                'CRUDO',
                'ROJO',
                'PATO BB',
                'AZUL MARINO',
                'AZUL 1233',
                'AMARILLO',
                'VERDE LORO',
                'ROSADO BB',
                'BLANCO',
                'ACERO',
                'ARENA',
                'BANANA',
                'BEIGE',
                'CELESTE',
                'CEMENTO',
                'CHICLE',
                'CIELO',
                'FRESA',
                'HUESO',
                'ITALIANO',
                'JADE',
                'KORAL',
                'LILA',
                'LIMON',
                'MAIZ',
                'MANDARINA',
                'MANZANA',
                'MANDARINA',
                'MARRON',
                'MELON',
                'MOSTAZA',
                'NEGRO',
                'PLATA',
                'PLOMO',
                'ROSADO',
                'TURQUEZA',
            ];
            foreach($t as $i){
                VlProductGama::create([
                    'identity'  => $i,
                    'token'     => User::get_token()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_product_gamas');
    }
};
