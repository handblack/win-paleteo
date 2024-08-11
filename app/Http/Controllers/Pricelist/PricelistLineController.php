<?php

namespace App\Http\Controllers\Pricelist;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlPriceListLine;
use Illuminate\Http\Request;

class PricelistLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'pl';
    private $table      = 'pricelist';
    public function index(Request $request)
    {
        $id = session('session_pricelist_id');
        $result = VlPriceListLine::wherePricelistId($id)
                                    ->paginate(env('PAGINATE',18));
        return view('pricelist.pricelistline_list',[
            'result' => $result,
            'q'         => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = session('session_pricelist_id');
        VlPriceListLine::create([
            'pricelist_id'  => $id,
            'product_id'    => $request->product_id,
            'token'         => User::get_token(),
        ]);
        return redirect()->route('pricelistline.index')->with('message','Producto agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if($id != 'download',403,'No se puede descargar');
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grant = auth()->user()->isgrant("{$this->grantname}_isdeleted");
        $row = VlPriceListLine::whereToken($id)->first();
        if($row && $grant){
            $data['status']     = 100;
            $data['message']    = 'Registro eliminado!';
            $row->delete();
        }elseif(!$grant){
            $data['status']         = 103;
            $data['message']        = 'No tienes permiso para eliminar!';
        }else{
            $data['status']         = 101;
            $data['message']        = 'El registro no existe o fue eliminado!';
        }
        return response()->json($data, $data['status'] == 100 ? 200 : 403);
    }
}
