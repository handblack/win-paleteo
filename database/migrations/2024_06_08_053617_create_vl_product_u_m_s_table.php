<?php

use App\Models\User;
use App\Models\VlProductUM;
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
        Schema::create('vl_product_ums', function (Blueprint $table) {
            $table->id();
            $table->string('umname',60);
            $table->string('shortname',10)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });

        $u = new VlProductUM();
        $u->umname      = 'KILOS';
        $u->shortname   = 'KG';
        $u->token       = User::get_token();
        $u->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_product_ums');
    }
};
