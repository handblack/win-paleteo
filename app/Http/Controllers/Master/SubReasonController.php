<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlChangeLog;
use App\Models\VlReason;
use App\Models\VlSubReason;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SubReasonController extends Controller
{
    private $grantname  = 'pr';
    private $table      = 'subreason';
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
        $result = VlSubReason::orWhere('identity','LIKE',$q)
                        ->orWhere('shortname','LIKE',$q)
                        ->paginate(env('PAGINATE_MODAL',14))
                        ->withQueryString();
        session([
            "session_{$this->table}_q_search" => $request->q,
        ]);
        return view("master.{$this->table}_list",[
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
        $row = new VlSubReason();
        $row->isactive = 'Y';
        $log = VlChangeLog::where('record_id',0)->get();
        $reason = VlReason::all();
        return view("master.{$this->table}_form",[
            'mode'  => 'new',
            'url'   => route("{$this->table}.store"),
            'row'   => $row,
            'log'   => $log,
            'reason' => $reason,
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
            'identity'      => ['required'],
            'isactive'      => ['required'],
        ]);
        $row = new VlSubReason();
        $row->fill($request->all());
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
        abort_if($id!='download',403,'No se puede descargar');
        $result = VlSubReason::all();
        $filename = app(VlSubReason::class)->getTable() . date("_Ymd_His");
        return response()->streamDownload(function () use ($result) {
            $spreadsheet = new Spreadsheet;
            $sheet       = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'IDENTIFICADOR');
            $sheet->setCellValue('C1', 'ABREVIADOR');
            $sheet->getStyle('A1:C1')->applyFromArray(['font' => ['bold' => true]]);
            $sheet->getStyle('A1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
            $key=1;
            foreach($result as $item){
                $key++;
                $sheet->setCellValue("A$key", $item->id);
                $sheet->setCellValueExplicit("B$key", $item->identity,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("C$key", $item->shortname,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
            $cols = explode(',','A,B,C');
            foreach($cols as $col){
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            (new Xlsx($spreadsheet))->save('php://output');
        }, "{$filename}.xlsx");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlSubReason::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $log = VlChangeLog::whereTablename(app(VlSubReason::class)->getTable())
                            ->whereRecordId($row->id)
                            ->limit(20)
                            ->orderBy('datelog','DESC')
                            ->get();
        $reason = VlReason::all();
        return view("master.{$this->table}_form",[
            'mode'  => 'edit',
            'url'   => route("{$this->table}.update",$id),
            'row'   => $row,
            'log'   => $log,
            'reason' => $reason,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlSubReason::whereToken($id)->first();
        $request->validate([
            'identity'      => ['required'],
            'shortname'     => ['required'],
            'isactive'      => ['required'],
        ]);
        /* Grabando LOG */
        $l = new VlChangeLog();
        $l->user_id     = auth()->user()->id;
        $l->tablename   = app(VlSubReason::class)->getTable();
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
        $row = VlSubReason::whereToken($id)->first();
        if($row && $grant){
            
            if(
                VlSubReason::where('reason_id',$row->reason_id)
                ->get()
                ->count('reason_id')
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
