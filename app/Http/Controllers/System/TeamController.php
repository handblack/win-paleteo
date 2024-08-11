<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\VlTeam;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace(' ','%',$q).'%';
        }else{
            $q = '%';
        }
        $result = VlTeam::orWhere('teamname','LIKE',$q)
                        ->orderBy('teamname','ASC')
                        ->paginate(env('PAGINATE',18));
        return view('system.team_list',[
            'result' => $result,
            'q' => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new VlTeam();
        return view('system.team_form',[
            'mode'  => 'new',
            'url'   => route('team.store'),
            'row'   => $row,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $request->validate([
            'teamname'      => 'required',            
        ]);
        $row = new VlTeam();
        $row->fill($request->all());
        $row->token = md5(date('YmdHis'));
        $row->save();
        return redirect()->route('team.index')->with('message','Registro creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = VlTeam::whereToken($id)->first();
        if($row){
            session([
                'session_team_id'       => $row->id,
                'session_team_token'    => $row->token,
            ]);
            return redirect()->route('teamgrant.index');
        }else{
            session_unset('session_team_id');
            session_unset('session_team_token');
            abort_if(!$row, 403, 'Prohibido');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = VlTeam::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        return view('system.team_form',[
            'mode'  => 'edit',
            'url'   => route('team.update',$id),
            'row'   => $row,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = VlTeam::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $row->fill($request->all());
        $row->save();
        return redirect()->route('team.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = VlTeam::whereToken($id)->first();
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
