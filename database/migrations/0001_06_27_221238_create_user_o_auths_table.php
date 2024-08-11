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
        Schema::create('vl_user_oauths', function (Blueprint $table) {
            $table->id();
            $table->string('provider',40)->nullable();
            $table->string('oauth_id');
            $table->string('oauth_name');
            $table->string('oauth_email');
            $table->string('oauth_token');

            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('vl_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_user_oauths');
    }
};
