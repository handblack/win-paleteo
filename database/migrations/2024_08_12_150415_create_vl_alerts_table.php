<?php

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
        Schema::create('vl_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->nullable();
            $table->foreignId('leader_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('subject',200)->nullable();
            
            $table->text('message')->nullable();
            $table->text('response')->nullable();

            $table->string('msg_cliente')->nullable();
            $table->string('msg_mejora')->nullable();
            $table->string('msg_fortaleza')->nullable();
            $table->string('msg_acciones')->nullable();

            $table->text('result')->nullable();
            $table->string('path_local',200)->nullable();
            $table->string('path_public',200)->nullable();
            $table->string('extension',200)->nullable();
            $table->string('path2_public',200)->nullable();
            $table->enum('status',['P','R','A'])->default('P'); // P=>Pendiente /R->Recibido / A->Anulado
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->timestamp('response_at')->nullable();
            $table->string('program',200)->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_alerts');
    }
};
