<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
use App\Models\User;
use App\Models\VlChangeLog;
use App\Models\VlOrder;
use App\Models\VlvOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'pr';
    private $table      = 'order';
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isgrant"),403,'Acceso restringido');
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace("@",' ',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = session("session_{$this->table}_q_search");
        }
        $result = VlvOrder::orWhere('bpartnername','LIKE',$q)
                        //->orWhere('shortname','LIKE',$q)
                        ->orderBy('dateorder','DESC')
                        ->orderBy('serial','ASC')
                        ->orderBy('id','DESC')
                        ->orderBy('bpartnername','ASC')
                        ->paginate(env('PAGINATE',18));
        session([
            "session_{$this->table}_q_search" => $request->q,
        ]);
        return view("operation.{$this->table}_list",[
            'result'    => $result,
            'q'         => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isgrant"),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant("{$this->grantname}_iscreated"),403,'Acceso restringido');
        $row = TempHeader::create([
            'user_id'   => auth()->user()->id,
            'token'     => User::get_token(),
            'module'    => $this->table,
        ]);
        return redirect()->route('order.edit',$row->token);
        /*
        return view("operation.{$this->table}_form_new",[
            'mode'  => 'new',
            'url'   => route("{$this->table}.store"),
            'row'   => $row,
            'log'   => $log,            
        ]);
        */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identity'      => ['required'],
            'shortname'     => ['required'],
            'isactive'      => ['required'],
        ]);
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new VlOrder();
        $row->fill($request->all());
        $row->token = User::get_token();
        $row->save();
        return redirect()->route("{$this->table}.index")->with('message','Registro creado');
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
        $row = TempHeader::whereToken($id)->first();
        abort_if(!$row,403,'TOKEN no valido'); 
        return view('operation.order_form_edit',[
            'row'    => $row,
            'url'       => route('order.update',$row->token),
            'mode'      => 'edit'
        ]);
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
        //
    }
}
