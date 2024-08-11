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
        Schema::create('vl_change_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datelog')->useCurrent();
            $table->string('tablename',100);
            $table->foreignId('user_id');
            $table->foreignId('record_id');
            $table->text('data_before');
            $table->text('data_after');
            $table->string('token',60);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_change_logs');
    }
};
