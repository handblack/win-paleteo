<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\TempLine;
use App\Models\User;
use Illuminate\Http\Request;

class TempLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $row = new TempLine();
        $row->fill($request->all());
        $row->token = User::get_token();
        $row->save();
        //si agregamos la linea, debemo redirigir la pagina al header
        return redirect()->route("{$row->header->module}.edit",$row->header->token);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $grant = true;
        $row = TempLine::whereToken($id)->first();
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
