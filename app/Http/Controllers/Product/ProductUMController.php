<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlChangeLog;
use App\Models\VlProduct;
use App\Models\VlProductUM;
use Illuminate\Http\Request;

class ProductUMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'pr';
    private $table      = 'um';
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
        $result = VlProductUM::orWhere('umname','LIKE',$q)
                        ->orWhere('shortname','LIKE',$q)
                        ->orderBy('umname','ASC')
                        ->orderBy('isactive','ASC')
                        ->paginate(env('PAGINATE_MODAL',14))
                        ->withQueryString();
        session([
            "session_{$this->table}_q_search" => $request->q,
        ]);
        return view("product.{$this->table}_list",[
            'result' => $result,
            'q' => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isgrant"),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant("{$this->grantname}_iscreated"),403,'Acceso restringido');
        $row = new VlProductUM();
        $log = VlChangeLog::where('record_id',0)->get();
        return view("product.{$this->table}_form",[
            'mode'  => 'new',
            'url'   => route("{$this->table}.store"),
            'row'   => $row,
            'log'   => $log,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'umname'        => ['required'],
            'shortname'     => ['required'],
            'isactive'      => ['required'],
        ]);
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new VlProductUM();
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
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlProductUM::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $log = VlChangeLog::whereTablename(app(VlProductUM::class)->getTable())
                            ->whereRecordId($row->id)
                            ->limit(20)
                            ->orderBy('datelog','DESC')
                            ->get();
        return view("product.{$this->table}_form",[
            'mode'  => 'edit',
            'url'   => route("{$this->table}.update",$id),
            'row'   => $row,
            'log'   => $log,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlProductUM::whereToken($id)->first();
        $request->validate([
            'umname'        => ['required'],
            'shortname'     => ['required'],
            'isactive'      => ['required'],
        ]);
        /* Grabando LOG */
        $l = new VlChangeLog();
        $l->user_id     = auth()->user()->id;
        $l->tablename   = app(VlProductUM::class)->getTable();
        $l->data_before = $row;
        $l->record_id   = $row->id;
        /* Datos */
        $row->fill($request->all());
        $row->save();
        /* Grabando LOG */
        $l->data_after  = $row;
        $l->token       = User::get_token();
        $l->save();
        return redirect()->route("{$this->table}.index",['q' => session("session_{$this->table}_q_search")])->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grant = auth()->user()->isgrant("{$this->grantname}_isdeleted");
        $row = VlProductUM::whereToken($id)->first();
        if($row && $grant){
            if(
                VlProduct::where('um_id',$row->um_id)
                ->get()
                ->count('um_id')
            ){
                $data['status']     = 102;
                $data['message']    = 'El registro ya esta referenciado en el sistema y no se puede eliminar';
            }else{
                $data['status']     = 100;
                $data['message']    = 'Registro eliminado!';
                $row->delete();
            }
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
