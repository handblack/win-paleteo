<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BPartner\BPAddressController;
use App\Http\Controllers\BPartner\BPartnerController;
use App\Http\Controllers\BPartner\BPBankAccountController;
use App\Http\Controllers\BPartner\BPContactController;
use App\Http\Controllers\BPartner\SalesPersonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\DocTypeController;
use App\Http\Controllers\Master\ReasonController;
use App\Http\Controllers\Master\SequenceController;
use App\Http\Controllers\Master\SubReasonController;
use App\Http\Controllers\Operation\AlertController;
use App\Http\Controllers\Operation\AlertLineController;
use App\Http\Controllers\Operation\DownloadController;
use App\Http\Controllers\Operation\InvoiceController;
use App\Http\Controllers\Operation\InvoiceLineController;
use App\Http\Controllers\Operation\OrderController;
use App\Http\Controllers\Operation\OrderLineController;
use App\Http\Controllers\Operation\PaloteoController;
use App\Http\Controllers\Operation\TempHeaderController;
use App\Http\Controllers\Operation\TempLineController;
use App\Http\Controllers\Pricelist\PricelistController;
use App\Http\Controllers\Pricelist\PricelistLineController;
use App\Http\Controllers\Product\ProductAcabadoController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductFamilyController;
use App\Http\Controllers\Product\ProductGamaController;
use App\Http\Controllers\Product\ProductGroupController;
use App\Http\Controllers\Product\ProductHilaturaController;
use App\Http\Controllers\Product\ProductPresentacionController;
use App\Http\Controllers\Product\ProductSubFamiliaController;
use App\Http\Controllers\Product\ProductTejidoController;
use App\Http\Controllers\Product\ProductTenidoController;
use App\Http\Controllers\Product\ProductTituloController;
use App\Http\Controllers\Product\ProductUMController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\System\ParameterController;
use App\Http\Controllers\System\TeamController;
use App\Http\Controllers\System\TeamGrantController;
use App\Http\Controllers\System\UserController;
use App\Models\User;
use App\Models\VlBpartner;
use App\Models\VlPriceList;
use App\Models\VlProduct;
use App\Models\VlProductAcabado;
use App\Models\VlProductFamilia;
use App\Models\VlProductGama;
use App\Models\VlProductGroup;
use App\Models\VlProductHilatura;
use App\Models\VlProductPresentacion;
use App\Models\VlProductSubFamilia;
use App\Models\VlProductTejido;
use App\Models\VlProductTenido;
use App\Models\VlProductTitulo;
use App\Models\VlProductUM;
use App\Models\VlReason;
use App\Models\VlSalesPerson;
use App\Models\VlUbigeo;
use App\Models\VlvReason;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
})->name('home');


Route::get('login', [AuthController::class,'login2'])->name('login');
Route::post('login', [AuthController::class,'login2_submit'])->name('login_submit');


Route::post('logout', [AuthController::class,'logout'])->name('logout');

Route::get('login/google',              [SocialAuthController::class, 'redirectToProvider'])->name('login_google');
Route::get('login/google/callback',     [SocialAuthController::class, 'handleProviderCallback'])->name('login_callback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::group(['prefix' => 'system'], function (){
        Route::resource('user',                 UserController::class,['names' => 'user']);
        Route::resource('team',                 TeamController::class,['names' => 'team']);
        Route::resource('teamgrant',            TeamGrantController::class,['names' => 'teamgrant']);
        Route::resource('sequence',             SequenceController::class,['names' => 'sequence']);
        Route::resource('parameter',            ParameterController::class,['names' => 'parameter']);
        Route::post('parameter',                [ParameterController::class,'api_datatable'])->name('parameter.ajax');
        Route::post('ajax/user',                [User::class,           'api_user'])->name('api_user');
        Route::post('ajax/asesor',                [User::class,           'api_asesor'])->name('api_asesor');
    });
    Route::group(['prefix' => 'master'], function (){
        Route::resource('doctype/manager',      DocTypeController::class,  ['names' => 'doctype']);
        Route::resource('reason/manager',       ReasonController::class,   ['names' => 'reason']);
        Route::resource('subreason/manager',    SubReasonController::class,['names' => 'subreason']);
        Route::post('ajax/motivos',              [VlvReason::class,           'api_reason'])->name('api_reason');
    });
    Route::group(['prefix' => 'product'], function (){
        Route::resource('manager',              ProductController::class,['names' => 'product']);
        Route::resource('group',                ProductGroupController::class,['names' => 'group']);
        Route::resource('familia',              ProductFamilyController::class,['names' => 'familia']);
        Route::resource('subfamilia',           ProductSubFamiliaController::class,['names' => 'subfamilia']);
        Route::resource('tejido',               ProductTejidoController::class,['names' => 'tejido']);
        Route::resource('hilatura',             ProductHilaturaController::class,['names' => 'hilatura']);
        Route::resource('titulo',               ProductTituloController::class,['names' => 'titulo']);
        Route::resource('gama',                 ProductGamaController::class,['names' => 'gama']);
        Route::resource('tenido',               ProductTenidoController::class,['names' => 'tenido']);
        Route::resource('acabado',              ProductAcabadoController::class,['names' => 'acabado']);
        Route::resource('presentacion',         ProductPresentacionController::class,['names' => 'presentacion']);
        Route::resource('um',                   ProductUMController::class,['names' => 'um']);

        //Servicios AJAX
        Route::post('ajax/products',            [VlProduct::class,          'api_product'])->name('api_product');
        Route::post('ajax/product/group',       [VlProductGroup::class,     'api_product_group'])->name('api_product_group');
        Route::post('ajax/product/familia',     [VlProductFamilia::class,   'api_product_family'])->name('api_product_family');
        Route::post('ajax/product/tejido',      [VlProductTejido::class,    'api_product_tejido'])->name('api_product_tejido');
        Route::post('ajax/product/subfamilia',  [VlProductSubFamilia::class,'api_product_subfamilia'])->name('api_product_subfamilia');
        Route::post('ajax/product/hilatura',    [VlProductHilatura::class,  'api_product_hilatura'])->name('api_product_hilatura');
        Route::post('ajax/product/titulo',      [VlProductTitulo::class,    'api_product_titulo'])->name('api_product_titulo');
        Route::post('ajax/product/gama',        [VlProductGama::class,      'api_product_gama'])->name('api_product_gama');
        Route::post('ajax/product/tenido',      [VlProductTenido::class,    'api_product_tenido'])->name('api_product_tenido');
        Route::post('ajax/product/subline',     [VlProductAcabado::class,   'api_product_acabado'])->name('api_product_acabado');
        Route::post('ajax/product/um',          [VlProductUM::class,        'api_product_um'])->name('api_product_um');
        Route::post('ajax/product/presen',      [VlProductPresentacion::class,'api_product_presentacion'])->name('api_product_presentacion');
    });
    Route::group(['prefix' => 'bpartner'], function (){
        Route::resource('manager',              BPartnerController::class,['names' => 'bpartner']);
        Route::resource('address',              BPAddressController::class,['names' => 'address']);
        Route::resource('account',              BPBankAccountController::class,['names' => 'bankaccount']);
        Route::resource('contact',              BPContactController::class,['names' => 'contact']);
        Route::resource('salesperson',          SalesPersonController::class,['names' => 'salesperson']);
        Route::post('consulta/ruc',             [BPartnerController::class,'get_ruc'])->name('api_get_ruc');
        //Servicio AJAX
        Route::post('ajax/bpartner',            [VlBpartner::class,         'api_bpartner'])->name('api_bpartner');
        Route::post('ajax/salesperson',         [VlSalesPerson::class,      'api_salesperson'])->name('api_salesperson');
        Route::post('ajax/pricelist',           [VlPriceList::class,        'api_pricelist'])->name('api_pricelist');
        Route::post('ajax/ubigeo',              [VlUbigeo::class,           'api_ubigeo'])->name('api_ubigeo');
    });
    
    Route::group(['prefix' => 'pricelist'], function (){
        Route::resource('manager',              PricelistController::class,['names' => 'pricelist']);
        Route::resource('lines',                PricelistLineController::class,['names' => 'pricelistline']);
        Route::get('download/{id}/{hash}',      [PricelistController::class,'download_pricelist'])->name('download_pricelist');
        Route::post('upload',                   [PricelistController::class,'pricelist_upload_excel'])->name('pricelist_upload_excel');                   
    });

    Route::group(['prefix' => 'operation'], function (){
        Route::resource('alert/manager',        AlertController::class,['names' => 'alert']);
        Route::resource('alert/line',           AlertLineController::class,['names' => 'alertline']);
        Route::resource('paloteo/manager',      PaloteoController::class,['names' => 'paloteo']);
        Route::resource('order/manager',        OrderController::class,['names' => 'order']);
        Route::resource('order/lines',          OrderLineController::class,['names' => 'orderline']);
        Route::resource('invoice/manager',      InvoiceController::class,['names' => 'invoice']);
        Route::resource('invoice/line',         InvoiceLineController::class,['names' => 'invoiceline']);
        Route::resource('th',                   TempHeaderController::class,['names' => 'tempheader']);
        Route::resource('tl',                   TempLineController::class,['names' => 'templine']);
        Route::post('alert/upload',             [AlertController::class,'user_upload_excel'])->name('user_upload_excel');
        
    });
    
    Route::group(['prefix' => 'report'], function (){
        Route::get('paloteo',       [DownloadController::class,'rpt_paloteo'])->name('rpt_paloteo');
        Route::post('paloteo',      [DownloadController::class,'rpt_paloteo_post'])->name('rpt_paloteo_post');
    });
});
