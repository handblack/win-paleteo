<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlAlert;
use App\Models\VlChangeLog;
use App\Models\VlSource;
use App\Models\VlvAlert;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            #'user_id'       => ['required'],
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
     
                abort_if($id!='download',403,'No se puede descargar');
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
                $lead = $row[2];
                $prg  = $row[3];
                $age  = $row[4];
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
                        $line->program   = trim($prg);
                        $line->age       = $age;
                    }else{
                        $error++;
                        $line->leader_id = null;
                        $line->program   = trim($prg);
                        $line->age       = $age;
                        
                    }
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
        return redirect()->route('alert.index')->with('message', 'Archivo cargado'.($error > 0 ? ", se encontraron {$error} inconsistencias" : ''));
    } 

}
