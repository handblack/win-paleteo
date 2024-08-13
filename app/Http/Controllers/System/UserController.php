<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
            $q = str_replace("@",' ',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = '%';
        }
        $result = User::orWhere('email','LIKE',$q)
                        ->orWhere('name','LIKE',$q)
                        ->orderBy('isactive','ASC')
                        ->orderBy('email','ASC')
                        ->paginate(env('PAGINATE',18));
        return view('system.user_list',[
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
        $row = new User();
        return view('system.user_form',[
            'mode'  => 'new',
            'url'   => route('user.store'),
            'row'   => $row,
            'teams'  => VlTeam::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:vl_users',
            'password'  => 'required|min:4', 
            'isactive'  => 'required',
            'team_id'   => 'required',
        ]);
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new User();
        $row->fill($request->all());
        $row->password  = Hash::make($request->password);
        $row->token     = User::get_token();
        $row->save();
        return redirect()->route('user.index')->with('message','Registro creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!in_array(auth()->user()->email,['llombardi@contact.com','soporte@miasoftware.net']),403,'Token no valido');
        $user = User::whereToken($id)->first();
        Auth::login($user);
        return redirect()->intended('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = User::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        return view('system.user_form',[
            'mode'  => 'edit',
            'url'   => route('user.update',$id),
            'row'   => $row,
            'teams'  => VlTeam::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = User::whereToken($id)->first();
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:vl_users,email,' . $row->id,
            'isactive'  => 'required',
            'team_id'   => 'required',
        ]);
        
        $row->fill($request->all());
        if($request->password){
            $row->password = Hash::make($request->password);
        }
        $row->save();
        return redirect()->route('user.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = User::whereToken($id)->first();
        if($row){
            $data['status'] = 102;
            $data['message'] = 'No se puede eliminar registro por proteccion de registros!';
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado!';
        }
        return response()->json($data, $data['status'] == 100 ? 200 : 403);
    }
}
