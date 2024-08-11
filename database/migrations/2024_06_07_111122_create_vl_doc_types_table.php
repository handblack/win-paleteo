<?php

use App\Models\User;
use App\Models\VlDocType;
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
        Schema::create('vl_doc_types', function (Blueprint $table) {
            $table->id();
            $table->string('doctypename',50);
            $table->string('doctypecode',10);
            $table->string('shortname',30)->nullable();       
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->enum('isreadonly',['Y','N'])->default('N');
            $table->enum('istypevalue',['A','N'])->default('N');         //A => Alfanumerico  /  N => Numerico
            $table->integer('length')->default(0);                  // longitud de digitos
            $table->enum('islengthtype',['F','V','N'])->default('N');   //F => Fijo  /  V => Variable  /  N => NULL
            $table->string('token',60);
            
            $table->foreignId('doctype_group_id');
            $table->foreign('doctype_group_id')->references('id')->on('vl_doc_type_groups');
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });
        $u = new VlDocType();
        // Documento de Identidad
        $t = [
            ['dt' => '6', 'it' => 'N', 'le' => 11 ,'il' => 'F', 'sn' => 'RUC', 'dn' => 'REGISTRO UNICO DEL CONTRIBUYENTE'],
            ['dt' => '1', 'it' => 'N', 'le' => 8  ,'il' => 'F', 'sn' => 'DNI', 'dn' => 'DOCUMENTO NACIONAL DE IDENTIDAD'],
            ['dt' => '4', 'it' => 'A', 'le' => 12 ,'il' => 'V', 'sn' => 'CE', 'dn' => 'CARNET DE EXTRANJERIA'],
            ['dt' => '0', 'it' => 'A', 'le' => 15 ,'il' => 'V', 'sn' => 'S/N', 'dn' => 'SIN DOCUMENTO'],
        ];
        foreach($t as $r){
            VlDocType::create([
                'doctypecode'       => $r['dt'],
                'doctypename'       => $r['dn'],
                'shortname'         => $r['sn'],
                'istypevalue'       => $r['it'],
                'islengthtype'      => $r['il'],
                'doctype_group_id'  => 1,
                'token'             => User::get_token(),
            ]);
        }

        
        /*
        // Documento de Identidad
        */
        $u->create([
            'doctypename'   => 'FACTURA',
            'doctypecode'   => '01',
            'shortname'     => 'FAC',
            'doctype_group_id' => 2,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'BOLETA DE VENTA',
            'doctypecode'   => '03',
            'shortname'     => 'BVE',
            'doctype_group_id' => 2,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'NOTA DE CREDITO',
            'doctypecode'   => '07',
            'shortname'     => 'NCR',
            'doctype_group_id' => 2,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'NOTA DE DEBITO',
            'doctypecode'   => '08',
            'shortname'     => 'NDB',
            'doctype_group_id' => 2,
            'token'         => User::get_token(),
        ]);
        /*
        // COBRANZAS
        */
        $u->create([
            'doctypename'   => 'EFECTIVO',
            'doctypecode'   => '01',
            'shortname'     => 'EFE',
            'doctype_group_id' => 3,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'TRANSFERENCIA',
            'doctypecode'   => '02',
            'shortname'     => 'TRA',
            'doctype_group_id' => 3,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'DEPOSITO EN CUENTA',
            'doctypecode'   => '03',
            'shortname'     => 'DEP',
            'doctype_group_id' => 3,
            'token'         => User::get_token(),
        ]);
        /*
        // PAGO
        */
        $u->create([
            'doctypename'   => 'EFECTIVO',
            'doctypecode'   => '04',
            'shortname'     => 'EFE',
            'doctype_group_id' => 4,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'TRANSFERENCIA',
            'doctypecode'   => '05',
            'shortname'     => 'TRA',
            'doctype_group_id' => 4,
            'token'         => User::get_token(),
        ]);
        $u->create([
            'doctypename'   => 'DEPOSITO EN CUENTA',
            'doctypecode'   => '06',
            'shortname'     => 'DEP',
            'doctype_group_id' => 4,
            'token'         => User::get_token(),
        ]);
        /*
        // Tipo de Documento de Secuenciador
        */
        $t = [
            'PE' => 'PEDIDOS',
            'NV' => 'NOTA DE VENTAS',
            'CO' => 'COBRANZAS',
            'PG' => 'PAGOS',
            'AS' => 'ASIGNACION'
        ];
        foreach($t as $k => $v){
            $u->create([
                'doctype_group_id'  => 5,
                'token'             => User::get_token(),
                'doctypecode'       => $k,
                'doctypename'       => $v
            ]);
        }
        VlDocType::whereIsactive('Y')->update(['isreadonly' => 'Y']);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_doc_types');
    }
};
