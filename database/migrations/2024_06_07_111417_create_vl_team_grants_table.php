<?php

use App\Models\User;
use App\Models\VlTeamGrant;
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
        Schema::create('vl_team_grants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreign('team_id')->references('id')->on('vl_teams');
            $table->string('token',60)->nullable();
            $table->enum('isactive',['Y','N'])->default('N');
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');

            // product
            $cfg = [
                'ra',   // Motivo
                'rs',   // SubMotivo 
            ];
            foreach($cfg as $cf){
                $table->enum("{$cf}_isgrant",['Y','N'])->default('N');
                $table->enum("{$cf}_iscreated",['Y','N'])->default('N');
                $table->enum("{$cf}_isupdated",['Y','N'])->default('N');
                $table->enum("{$cf}_isdeleted",['Y','N'])->default('N');
            }

             

            // cuentas corrientes
            $table->enum('cc_isgrant',['Y','N'])->default('N');
            $table->enum('cc_iscreated',['Y','N'])->default('N');
            $table->enum('cc_isupdated',['Y','N'])->default('N');
            $table->enum('cc_isdeleted',['Y','N'])->default('N');

            // OPERACIONES
            // socio de negocio
            $cfg = [
                'pa',   // Paloteo
                'al',   // Sistema de mensajes
            ];
            foreach($cfg as $cf){
                $table->enum("{$cf}_isgrant",['Y','N'])->default('N');
                $table->enum("{$cf}_iscreated",['Y','N'])->default('N');
                $table->enum("{$cf}_isupdated",['Y','N'])->default('N');
                $table->enum("{$cf}_isdeleted",['Y','N'])->default('N');
            }
            // Otras configuracions
            //r1 - Reportes de EECC
            $table->enum('r1_isgrant',['Y','N'])->default('N');
            #$table->enum('r2_isgrant',['Y','N'])->default('N');
            #$table->enum('r3_isgrant',['Y','N'])->default('N');

            $table->timestamps();
        });

        $row = new VlTeamGrant();
        $cat = [
            'ra',   // socio de negocio
            'rs',   // sn - direcciones 
            'pa',   // sn - cuentas de banco
        ];
        $cru = ['isgrant','iscreated','isupdated','isdeleted'];
        foreach($cat as $prefix){
            foreach($cru as $crud){
                $field = "{$prefix}_{$crud}"; 
                $row->$field = 'Y';
            }
        }
        // Aqui procesamos a los que solo requiere GRANT (Solo Acceso)
        $cat = [
            'r1'
        ];
        foreach($cat as $prefix){
            $field = "{$prefix}_isgrant";
            $row->$field = 'Y';
        }
        $row->isactive  = 'Y';
        $row->team_id   = 1;
        $row->token     = User::get_token();
        $row->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_team_grants');
    }
};
