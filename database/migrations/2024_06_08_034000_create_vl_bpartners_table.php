<?php

use App\Models\User;
use App\Models\VlBpartner;
use App\Models\VlSalesPerson;
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
        Schema::create('vl_bpartners', function (Blueprint $table) {
            $table->id();
            $table->string('bpartnercode',12)->default('C');
            $table->string('bpartnername',200);
            $table->string('shortname',30)->nullable();
            $table->string('address',200)->nullable();
            
            $table->foreignId('doctype_id');
            $table->foreign('doctype_id')->references('id')->on('vl_doc_types');
            $table->string('documentno',15);

            $table->foreignId('pricelist_id');
            $table->foreign('pricelist_id')->references('id')->on('vl_pricelists');

            $table->foreignId('salesperson_id');
            $table->foreign('salesperson_id')->references('id')->on('vl_sales_people');

            $table->foreignId('clasifica_id');
            $table->foreign('clasifica_id')->references('id')->on('vl_parameters');
            
            $table->foreignId('ubigeo_id')->nullable();

            $table->enum('bpartnertype',['C','P'])->default('C');
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('vl_users');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('vl_users');
            $table->timestamps();
        });
        $u = new VlBpartner();
        $u->bpartnercode    = 'C20611185279';
        $u->documentno      = '20611185279';
        $u->bpartnername    = 'MIASOFTWARE NETWORK SAC';
        $u->doctype_id      = 1;
        $u->salesperson_id  = 1;
        $u->pricelist_id    = 1;
        $u->clasifica_id    = 1;
        $u->token           = User::get_token();
        $u->created_by      = 1;
        $u->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vl_bpartners');
    }
};
