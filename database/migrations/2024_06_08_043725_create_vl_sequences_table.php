<?php

use App\Models\User;
use App\Models\VlDocType;
use App\Models\VlSequence;
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
        Schema::create('vl_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('serial',10);
            $table->bigInteger('lastnumber')->default(0);
            $table->foreignId('doctype_id');
            $table->foreign('doctype_id')->references('id')->on('vl_doc_types');
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });

        $t = ['PE','NV','CO','PG','AS'];
        foreach($t as $i){
            VlSequence::create([
                'serial'        => '0001',
                'doctype_id'    => VlDocType::whereDoctypeGroupId(5)->whereDoctypecode($i)->first()->id,
                'isactive'      => 'Y',
                'lastnumber'    => 0,
                'token'         => User::get_token(),
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_sequences');
    }
};
