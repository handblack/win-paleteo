<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlDocType;
use App\Models\VlDocTypeGroup;
use Illuminate\Http\Request;

class DocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isgrant('td_isgrant'),403,'Acceso restringido');
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = '%';
        }
        $result = VlDocType::where('doctypename','LIKE',$q)
                            ->paginate(env('PAGINATE',18))
                            ->withQueryString();
        return view('master.doctype_list', [
            'result' => $result,
            'q' => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->isgrant('td_isgrant'),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant('td_iscreated'),403,'Acceso restringido');
        $row = new VlDocType();
        return view('master.doctype_form',[
            'mode'  => 'new',
            'url'   => route('doctype.store'),
            'row'   => $row,
            'group'  => VlDocTypeGroup::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->isgrant('td_iscreated'),403,'Acceso restringido');
        $request->validate([
            'doctypecode'   => ['required'],
            'doctypename'   => ['required'],
            'doctype_group_id' => ['required','numeric'],
            'isactive'      => ['required'],
        ]);
        $row = new VlDocType();
        $row->fill($request->all());
        $row->token = User::get_token();
        $row->save();
        return redirect()->route('doctype.index')->with('message','Registro creado');
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
        abort_if(!auth()->user()->isgrant('td_isupdated'),403,'Acceso restringido');
        $row = VlDocType::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        return view('master.doctype_form',[
            'mode'  => 'edit',
            'url'   => route('doctype.update',$id),
            'row'   => $row,
            'group'  => VlDocTypeGroup::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant('td_isupdated'),403,'Acceso restringido');
        $row = VlDocType::whereToken($id)->first();
        $request->validate([
            'doctypecode'   => ['required'],
            'doctypename'   => ['required'],
            'doctype_group_id' => ['required','numeric'],
            'isactive'      => ['required'],
        ]);        
        $row->fill($request->all());
        $row->save();
        return redirect()->route('doctype.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grant = auth()->user()->isgrant('td_isdeleted');
        $row = VlDocType::whereToken($id)
                        ->whereIsreadonly('N')
                        ->first();
        if($row && $grant){
            $data['status'] = 100;
            $data['message'] = 'Registro eliminado!';
            $row->delete();
        }elseif(!$grant){
            $data['status'] = 103;
            $data['message'] = 'No tienes permiso para eliminar!';
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado!';
        }
        return response()->json($data, $data['status'] == 100 ? 200 : 403);
    }
}
