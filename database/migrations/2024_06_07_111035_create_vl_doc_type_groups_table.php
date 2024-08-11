<?php

use App\Models\VlDocTypeGroup;
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
        Schema::create('vl_doc_type_groups', function (Blueprint $table) {
            $table->id();
            $table->string('doctypegroupname');
            $table->timestamps();
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
        });
        $u = new VlDocTypeGroup();
        $u->create(['doctypegroupname' => 'TIPO DOCUMENTO IDENTIDAD']);
        $u->create(['doctypegroupname' => 'FACTURACION']);
        $u->create(['doctypegroupname' => 'COBRANZAS/DEPOSITOS']);
        $u->create(['doctypegroupname' => 'PAGOS/EXTORNOS']);
        $u->create(['doctypegroupname' => 'DOCUMENTOS DE OPERACION']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_doc_type_groups');
    }
};
