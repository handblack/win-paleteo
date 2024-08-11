<?php

use App\Models\User;
use App\Models\VlParameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vl_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('identity',150);
            $table->string('value',150)->nullable();
            $table->bigInteger('id2')->nullable();
            $table->string('shortname',30)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->enum('isreadonly',['Y','N'])->default('N');
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->string('token',60);
            $table->timestamps();
        });
        /*
        // Creando GRUPOS
        */
        $t = [
            'SYSTEM NAME',
            'TDI - TIPO DE VALOR',
            'TDI - TIPO DE LONGITUD',
            'ESTADO DEL REGISTRO',
            'CLASIFICACION CLIENTES',
        ];
        foreach($t as $k => $v){
            VlParameter::create([
                'id'            => $k, 
                'identity'      => $v,
                'group_id'      => 0,
                'isreadonly'    => 'Y',
                'token'         => User::get_token(),
            ]);
        }
        //DB::statement("ALTER TABLE vl_parameters AUTO_INCREMENT = 1001;");
        VlParameter::create(['id'=>1001,'group_id' => 2, 'identity'=>'ALFANUMERICO',   'value'=>'A','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 2, 'identity'=>'NUMERICO',       'value'=>'N','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 3, 'identity'=>'FIJO',           'value'=>'F','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 3, 'identity'=>'VARIABLE',       'value'=>'V','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 4, 'identity'=>'ACTIVO',         'value'=>'Y','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 4, 'identity'=>'DESACTIVADO',    'value'=>'N','token'=>User::get_token()]);
        //5 - clasificacion clientes
        VlParameter::create(['group_id' => 5, 'identity'=>'CLASIFICACION A',    'value'=>'A','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 5, 'identity'=>'CLASIFICACION B',    'value'=>'B','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 5, 'identity'=>'CLASIFICACION C',    'value'=>'C','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 5, 'identity'=>'CLASIFICACION D',    'value'=>'D','token'=>User::get_token()]);
        VlParameter::create(['group_id' => 5, 'identity'=>'CLASIFICACION E',    'value'=>'E','token'=>User::get_token()]);

        //User::set_param('SEQUENCE.BPARTNER.CODE','10123456780');
        User::set_param('SEQUENCE.BPARTNER.CODE','10000000000');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_parameters');
    }
};
