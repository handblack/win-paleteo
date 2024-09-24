<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlAlert;
use App\Models\VlChangeLog;
use App\Models\VlSource;
use App\Models\VlvAlert;
use App\Models\VlvDimensionado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'al';
    private $table      = 'alert';
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

        $result = VlAlert::where(function($query) use ($q){
                                $query->orWhere('subject','LIKE',$q);
                            })
                            /*
                            ->where(function($query){
                                if(auth()->user()->isadmin == 'N'){
                                    $query->where('created_by',auth()->user()->id);
                                }
                            })
                            */
                            ->orderBy('id','DESC')
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
        $row = new VlAlert();
        $row->isactive = 'Y';
        $log = VlChangeLog::where('record_id',0)->get();
        $sou = VlSource::all();
        return view("operation.{$this->table}_form",[
            'mode'  => 'new',
            'url'   => route("{$this->table}.store"),
            'row'   => $row,
            'log'   => $log,
            'sou'   => $sou,
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
            'subject'       => ['required'],
            'source_id'     => ['required'],
            'user_id'       => ['required'],
            'message'       => ['required'],
        ]);
        $row = new VlAlert();
        $row->fill($request->all());
        $row->token         = User::get_token();
        $row->created_by    = auth()->user()->id;
        $row->save();
        $row->leader_id = $row->user->leader_id;
        $row->program   = $row->user->program; 
        $row->save();
        return redirect()->route("{$this->table}.index")->with('message','Registro creado');
        //return redirect()->route('alert.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mod = ['download','dimensionado'];
        abort_if(!in_array($id,$mod),403,'No se puede descargar');
        switch($id){
            case 'download':
                $result = VlvAlert::all();
                $filename = app(VlvAlert::class)->getTable() . date("_Ymd_His");
                return response()->streamDownload(function () use ($result) {
                    $spreadsheet = new Spreadsheet;
                    $sheet       = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A2', 'Origen');
                    $sheet->setCellValue('B2', 'Mail');
                    $sheet->setCellValue('C2', 'Fecha.Mail');
                    $sheet->setCellValue('D2', 'Hora.Mail');
                    $sheet->setCellValue('E2', 'Fecha.Rta');
                    $sheet->setCellValue('F2', 'Hora.Rta');
                    $sheet->setCellValue('G2', 'Estado');
                    $sheet->setCellValue('H2', 'Resultado');
                    $sheet->setCellValue('I2', 'Supervisor');
                    $sheet->setCellValue('J2', 'Asesor');
                    $sheet->setCellValue('K2', 'Asunto');
                    $sheet->setCellValue('L2', 'Detalle');
                    $sheet->getStyle('A2:L2')->applyFromArray(['font' => ['bold' => true]]);
                    $sheet->getStyle('A2:L2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
                    $key=2;
                    foreach($result as $item){
                        $key++;
                        $sheet->setCellValue("A$key", $item->source->identity);
                        $sheet->setCellValue("C$key", Carbon::parse($item->created_at)->format('d/m/Y'));
                        $sheet->setCellValueExplicit("D$key", Carbon::parse($item->created_at)->format('H:i:s'),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        if($item->response_at){
                            $sheet->setCellValue("E$key", Carbon::parse($item->response_at)->format('d/m/Y'));
                            $sheet->setCellValueExplicit("F$key", Carbon::parse($item->response_at)->format('H:i:s'),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        }
                        $sheet->setCellValue("G$key", $item->status == 'P' ? 'Pendiente' : 'Finalizado');
                        $sheet->setCellValue("H$key", $item->response);
                        $sheet->setCellValue("I$key", $item->leader_id ? $item->leader->lastname : '');
                        $sheet->setCellValue("J$key", $item->user->lastname);
                        $sheet->setCellValue("K$key", $item->subject);
                        $sheet->setCellValue("L$key", $item->message);
                    }
                    $cols = explode(',','A,B,C');
                    foreach($cols as $col){
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                    (new Xlsx($spreadsheet))->save('php://output');
                }, "{$filename}.xlsx");
                break;
            case 'dimensionado':
                $result = VlvDimensionado::all();
                $filename = 'dimensionado' . date("_Ymd_His");
                return response()->streamDownload(function () use ($result) {
                    $spreadsheet = new Spreadsheet;
                    $sheet       = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A1', 'Usuario');
                    $sheet->setCellValue('B1', 'DNI');
                    $sheet->setCellValue('C1', 'Nombre y apellido');
                    $sheet->setCellValue('D1', 'Lider_Usuario');
                    $sheet->setCellValue('E1', 'Lider_DNI');
                    $sheet->setCellValue('F1', 'Lider_Nombres');
                    $sheet->setCellValue('G1', 'Programa');
                    $sheet->setCellValue('H1', 'Antiguedad');
                    $sheet->getStyle('A1:H1')->applyFromArray(['font' => ['bold' => true]]);
                    $sheet->getStyle('A1:A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
                    $sheet->getStyle('C1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
                    $sheet->getStyle('E1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
                    $sheet->getStyle('B1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
                    $sheet->getStyle('D1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
                    $sheet->getStyle('G1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
                    $key=1;
                    foreach($result as $item){
                        $key++;
                        $sheet->setCellValueExplicit("A$key", $item->name,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValueExplicit("B$key", $item->documentno,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue("C$key", $item->lastname);
                        $sheet->setCellValueExplicit("D$key", $item->leader_name,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue("E$key", $item->leader_documentno);
                        $sheet->setCellValue("F$key", $item->leader_lastname);
                        $sheet->setCellValue("G$key", $item->program);
                        $sheet->setCellValue("H$key", $item->age);
                    }
                    $cols = explode(',','A,B,C');
                    foreach($cols as $col){
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                    (new Xlsx($spreadsheet))->save('php://output');
                }, "{$filename}.xlsx");
                break;
        }
            
            
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isgrant"),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlAlert::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $log = VlChangeLog::whereTablename(app(VlAlert::class)->getTable())
                            ->whereRecordId($row->id)
                            ->limit(20)
                            ->orderBy('datelog','DESC')
                            ->get();
        $sou = VlSource::all();
        return view("operation.{$this->table}_form",[
            'mode'  => 'edit',
            'url'   => route("{$this->table}.update",$id),
            'row'   => $row,
            'log'   => $log,
            'sou'   => $sou,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlAlert::whereToken($id)->first();
        abort_if($row->status == 'R',403,'El registro contiene respueta y esta cerrado');
        $request->validate([
            'identity'      => ['required'],
            'isactive'      => ['required'],
        ]);
        /* Grabando LOG */
        $l = new VlChangeLog();
        $l->user_id     = auth()->user()->id;
        $l->tablename   = app(VlAlert::class)->getTable();
        $l->data_before = $row;
        $l->record_id   = $row->id;
        /* Datos */
        $row->fill($request->all());
        $row->updated_by    = auth()->user()->id;
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
        $row = VlAlert::whereToken($id)->first();
        if($row && $grant){
            if($row->status == 'R'){
                $data['status']     = 102;
                $data['message']    = 'No se puede eliminar el registro tiene respuesta';
            }else{
                $data['status']     = 100;
                $data['message']    = 'Registro eliminado';
                $row->delete();
            }
        }else{
            $data['status']     = 103;
            $data['message']    = 'Error interno';
        }
        return response()->json($data, $data['status'] == 100 ? 200 : 403);
    }


    public function user_upload_excel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        $error = 0;
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        foreach ($sheetData as $index => $row) {
            // Ignorar la primera fila si contiene encabezados
            if ($index == 0) {
                continue;
            }
            if(isset($row[0])){
                $user = $row[0];
                $dni = $row[1];
                $lead = $row[3];
                $prg  = $row[6];
                $age  = $row[7];
                $un = strtolower(trim($user).'@contact.com');
                $line = User::whereEmail($un)
                            ->whereTeamId(1)
                            ->first();
                if($line){
                    $l = User::whereName(trim($lead))
                                ->whereNotIn('team_id',[1])
                                ->first();
                    if($l){
                        $line->leader_id = $l->id;
                    }else{
                        $error++;
                        $line->leader_id = null;
                    }
                    $line->documentno   = trim($dni);
                    $line->program      = trim($prg);
                    $line->age          = $age;
                    $line->updated_by = auth()->user()->id;
                    $line->save();
                }
                #if(isset($p[0]) && isset($p[1])){
                #    // hay datos, asi que buscamos el indice para actualizar el dato
                #}
            }else{
                return redirect()->route('alert.index')->with('error', 'El archivo no tiene la estructura correcta');        
            }
        }
        // Aqui ejecutamos los FILL para completar otros campos adicionaes en las alertas
        DB::select('call sp_actualiza_leader()');
        return redirect()->route('alert.index')->with('message', 'Archivo cargado'.($error > 0 ? ", se encontraron {$error} inconsistencias" : ''));
    } 

}
