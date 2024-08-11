<?php

use App\Models\User;
use App\Models\VlTeam;
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
        Schema::create('vl_teams', function (Blueprint $table) {
            $table->id();
            $table->string('teamname');
            $table->string('shortname')->nullable();
            $table->string('token',60)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });

        $u = new VlTeam();
        $u->teamname = 'Administradores';
        $u->token   = User::get_token();
        $u->save();

        $u = new VlTeam();
        $u->teamname = 'Cotizaciones';
        $u->token   = User::get_token();
        $u->save();

        $u = new VlTeam();
        $u->teamname = 'Vendedores';
        $u->token   = User::get_token();
        $u->save();

        $u = new VlTeam();
        $u->teamname = 'Cobranzas';
        $u->token   = User::get_token();
        $u->save();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_teams');
    }
};
