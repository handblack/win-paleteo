<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\VlTeam;
use App\Models\VlTeamGrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeamGrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        if(!Session::has('session_team_id')){
            return redirect()->route('team.index');
        }
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace(' ','%',$q).'%';
        }else{
            $q = '%';
        }
        $result = VlTeamGrant::whereTeamId(session('session_team_id'))
                                ->paginate();
        return view('system.teamgrant_list',[
            'result'    => $result,
            'url'       => route('teamgrant.store'),
            'mode'      => 'new',
            'header'    => VlTeam::find(session('session_team_id')),
            'q'         => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = VlTeamGrant::whereToken($id)->first();
        return view('system.teamgrant_form',[
            'mode'  => 'edit',
            'url'   => route('teamgrant.update',$row->token),
            'row'   => $row,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = VlTeamGrant::whereToken($id)->first();
        $cat = ['o1','o2','o3','o4','o5',
            'bp',   // socio de negocio
            'bd',   // sn - direcciones 
            'bb',   // sn - cuentas de banco
            'bc',   // sn - contactos    

            'pr', // Producto
            'pl', // producto linea 
            'ps', // producto sublinea
            'pc', // producto categoria
            'pf', // producto familia

            'ex',   // Tipo de Cambio
            'td',   // Tipo de Documento
            
        ];
        $cru = ['isgrant','iscreated','isupdated','isdeleted'];
        foreach($cat as $prefix){
            foreach($cru as $crud){
                $field = "{$prefix}_{$crud}"; 
                $row->$field = $request->has($field) ? 'Y' : 'N';
            }
        }
        // Aqui procesamos a los que solo requiere GRANT (Solo Acceso)
        $row->r1_isgrant            = $request->has('r1_isgrant') ? 'Y' : 'N';
        $row->r2_isgrant            = $request->has('r2_isgrant') ? 'Y' : 'N';
        $row->r3_isgrant            = $request->has('r3_isgrant') ? 'Y' : 'N';
        $row->r4_isgrant            = $request->has('r4_isgrant') ? 'Y' : 'N';
        $row->r5_isgrant            = $request->has('r5_isgrant') ? 'Y' : 'N';
        //$row->isactive   = $request->has('isactive') ? 'Y' : 'N';
        $row->isactive   = 'Y';

        $row->save();
        return redirect()->route('teamgrant.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = VlTeamGrant::whereToken($id)->first();
        if($row){
            $data['id'] = 100;
            $data['message'] = 'Registro elminado!';
            $row->delete();
        }else{
            $data['id'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado!';
        }
        return response()->json($data, $data['id'] == 100 ? 200 : 403);
    }
}
