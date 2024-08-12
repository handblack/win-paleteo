<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlChangeLog;
use App\Models\VlPaloteo;
use Illuminate\Http\Request;

class PaloteoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'pa';
    private $table      = 'paloteo';
    private $mes = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SET','OCT','NOV','DIC'];
    public function index(Request $request)
    {
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace("@",' ',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = session("session_{$this->table}_q_search");
        }

        $result = VlPaloteo::where(function($query) use ($q){
                                $query->orWhere('nodo','LIKE',$q);
                                $query->orWhere('documentno','LIKE',$q);
                                $query->orWhere('did','LIKE',$q);
                            })
                            ->where('datetrx',date('Y-m-d'))
                            ->where(function($query){
                                if(auth()->user()->isadmin == 'N'){
                                    $query->where('created_by',auth()->user()->id);
                                }
                            })
                            ->paginate(env('PAGINATE_MODAL',14))
                            ->withQueryString();
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
        $row = new VlPaloteo();
        $row->isactive = 'Y';
        $log = VlChangeLog::where('record_id',0)->get();
        return view("operation.{$this->table}_form",[
            'mode'  => 'new',
            'url'   => route("{$this->table}.store"),
            'row'   => $row,
            'log'   => $log,
            'mes'   => $this->mes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isgrant"),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant("{$this->grantname}_iscreated"),403,'Acceso restringido');
        $request->validate([
            'nodo'          => ['required'],
            'documentno'    => ['required'],
            'did'           => ['required'],
            'subreason_id'  => ['required'],
        ]);
        $row = new VlPaloteo();
        $row->fill($request->all());
        $row->datetrx       = date('Y-m-d');
        $row->token         = User::get_token();
        $row->created_by    = auth()->user()->id;
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
        //
    }
}
