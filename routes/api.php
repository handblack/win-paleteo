<?php

use App\Http\Controllers\BPartner\BPartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 

#Route::group(['middleware' => ['auth:sanctum']], function () {
#    //Version 1 de API
#    Route::group(['prefix' => 'v1'], function (){
#        #Route::post('user')->name('api_bpartner');
#        #Route::post('consulta/ruc',  [BPartnerController::class,'get_ruc'])->name('api_get_ruc');
#    });
#});

Route::middleware("auth:sanctum")->group(function(){
    //Aqui oponemos las lineas
});
