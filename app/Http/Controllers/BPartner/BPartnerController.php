<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlBpartner;
use App\Models\VlChangeLog;
use App\Models\VlDocType;
use App\Models\VlParameter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'bp';
    private $table = 'bpartner';
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isgrant('bp_isgrant'),403,'Acceso restringido');
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace("@",' ',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = session("session_{$this->table}_q_search");
        }
        $result = VlBpartner::orWhere('bpartnername','LIKE',$q)
                        ->orWhere('bpartnercode','LIKE',$q)
                        //->orderBy('isactive','ASC')
                        ->paginate(env('PAGINATE',18))
                        ->withQueryString();
        session([
            "session_{$this->table}_q_search" => $request->q,
        ]);
        return view('bpartner.bp_list',[
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
        $row = new VlBpartner();
        $row->bpartnertype  = 'C';
        $row->isactive      = 'Y';
        $row->doctype_id    = 4;
        $log = VlChangeLog::where('record_id',0)->get();
        
        return view('bpartner.bp_form',[
            'mode'      => 'new',
            'url'       => route('bpartner.store'),
            'row'       => $row,
            'log'       => $log,
            'doctype'   => VlDocType::whereDoctypeGroupId(1)->get(),
            'clasifica' => auth()->user()->get_group(5),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->isgrant('pr_isgrant'),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant('pr_iscreated'),403,'Acceso restringido');
        $request->validate([
            'bpartnertype'      => ['required'],
            'bpartnername'      => ['required'],
            'isactive'          => ['required'],
            'pricelist_id'      => ['required'],
            'salesperson_id'    => ['required'],
            'clasifica_id'      => ['required'],
            'doctype_id'        => ['required'],
            'documentno'        => function($attribute,$value,$fail) use($request){                
                if(!is_numeric($request->documentno) && in_array($request->doctype_id,[1,2,3])){
                    $fail('El número de documento debe ser numerico!');
                }
                switch($request->doctype_id){
                    case 1: //RUC
                        $c = substr($request->documentno,0,1);
                        if(!strlen($request->documentno) != 11){
                            $fail('El número de RUC es de 11 digitos!');
                        }elseif(!in_array($c,['1','2'])){
                            $fail('El número de RUC no es valido!');
                        }
                        break;
                    case 2: //DNI
                        if(!strlen($request->documentno) != 8){
                            $fail('En número de DNI debe ser de 8 digitos!');
                        }
                        break;
                    case 3: //CE
                        if(!in_array(strlen($request->documentno),[8,9])){
                            $fail('En número de CE no es valido!');
                        }
                        break;
                }
            },
        ]);        
        $code = 'C' . str_pad(strtoupper(trim($request->documentno)),11,'0',STR_PAD_LEFT);
        if($request->doctype_id == 4){
            $codx = User::get_param('SEQUENCE.BPARTNER.CODE');
            $codx = $codx ? $codx : 10000000000; 
            $codx++;
            $code = 'C' . str_pad($codx,11,'0',STR_PAD_LEFT);
        }
        //Aqui valido si el codigo es unico
        $u = VlBpartner::whereBpartnercode($code)->first();
        if($u){
            return back()->withErrors(['error' => 'El codigo ya esta registrado en el sistema']);
        }
        $row = new VlBpartner();
        $row->fill($request->all());
        $row->documentno    = $request->documentno ? $request->documentno : $codx;
        $row->bpartnertype  = 'C';
        $row->token         = User::get_token();
        $row->bpartnercode  = $code;//'C' . str_pad(strtoupper(trim($request->documentno)),11,'0',STR_PAD_LEFT);
        $row->created_by    = auth()->user()->id;        
        $row->save();
        if($request->doctype_id == 4){
            User::set_param('SEQUENCE.BPARTNER.CODE',$codx);
        }
        return redirect()->route("{$this->table}.index")->with('message','Registro creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Proceso para descargar el archivos de clientes
        $ch = md5('download'.date('Ymd'));
        abort_if($id != $ch,403,'Token no valido de descarga');

        $result = VlBpartner::all();
        $filename = date("Ymd_His");
        return response()->streamDownload(function () use ($result) {
            $spreadsheet = new Spreadsheet;
            $sheet       = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'CODIGO');
            $sheet->setCellValue('B1', 'TDC');
            $sheet->setCellValue('C1', 'NRO');
            $sheet->setCellValue('D1', 'CLIENTE');
            $sheet->setCellValue('E1', 'ALIAS');
            $sheet->setCellValue('F1', 'PL');
            $sheet->setCellValue('G1', 'EJECUTIVO');
            $sheet->setCellValue('H1', 'CLASE');
            $sheet->setCellValue('I1', 'ESTADO');            
            $sheet->setCellValue('J1', 'UBIGEO');            
            $sheet->setCellValue('K1', 'DEP');            
            $sheet->setCellValue('L1', 'PRO');            
            $sheet->setCellValue('M1', 'DIS');            
            $sheet->getStyle('A1:M1')->applyFromArray(['font' => ['bold' => true]]);
            $sheet->getStyle('A1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
            $key=1;
            foreach($result as $bpartner){
                $key++;
                $sheet->setCellValueExplicit("A$key", $bpartner->bpartnercode, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("B$key", $bpartner->doctype->shortname);
                $sheet->setCellValueExplicit("C$key", $bpartner->documentno,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("D$key", $bpartner->bpartnername);
                $sheet->setCellValue("E$key", $bpartner->shortname);                
                $sheet->setCellValue("F$key", $bpartner->pricelist->shortname);                
                $sheet->setCellValue("G$key", $bpartner->salesperson->shortname);                
                $sheet->setCellValue("H$key", $bpartner->clasifica->value);                
                $sheet->setCellValue("I$key", $bpartner->isactive);
                if($bpartner->ubigeo_id){
                    $sheet->setCellValue("J$key", $bpartner->ubigeo->ubigeo);
                    $sheet->setCellValue("K$key", $bpartner->ubigeo->dep);
                    $sheet->setCellValue("L$key", $bpartner->ubigeo->pro);
                    $sheet->setCellValue("M$key", $bpartner->ubigeo->dis);
                }
            }
            $cols = explode(',','A,B,C,D,E,F,G,H,I');
            foreach($cols as $col){
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            (new Xlsx($spreadsheet))->save('php://output');
        }, "clientes_{$filename}.xlsx");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlBpartner::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $log = VlChangeLog::whereTablename(app(VlBpartner::class)->getTable())
                            ->whereRecordId($row->id)
                            ->limit(20)
                            ->orderBy('datelog','DESC')
                            ->get();
        return view("bpartner.bp_form",[
            'mode'      => 'edit',
            'url'       => route("{$this->table}.update",$id),
            'row'       => $row,
            'log'       => $log,
            'doctype'   => VlDocType::whereDoctypeGroupId(1)->get(),
            'clasifica' => auth()->user()->get_group(5),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlBpartner::whereToken($id)->first();
        $request->validate([
            'bpartnertype'      => ['required'],
            'doctype_id'        => ['required'],
            'documentno'        => ['required'],
            'bpartnername'      => ['required'],
            'isactive'          => ['required'],
            'pricelist_id'      => ['required'],
            'salesperson_id'    => ['required'],
            'clasifica_id'      => ['required'],
        ]);
        /* Grabando LOG */
        $l = new VlChangeLog();
        $l->user_id     = auth()->user()->id;
        $l->tablename   = app(VlBpartner::class)->getTable();
        $l->data_before = $row;
        $l->record_id   = $row->id;
        /* Datos */
        $row->fill($request->all());
        $row->updated_by = auth()->user()->id;
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
        //
    }

    public function get_ruc(Request $request){
        $url = "https://mpv.essalud.gob.pe/Parametro/BuscarRUC";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            "Content-Type: application/x-www-form-urlencoded",
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = "numeroRUC={$request->numeroRUC}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp   = curl_exec($curl);
        curl_close($curl);
        $json   = json_decode($resp,true);
        $j['curl']  = json_decode($resp,true);
        if($json){
            foreach($json as $k => $v){
                $j[$k] = isset($v) ? trim($v) : 'NO_DEF';
            }
        }
        return response()->json($j, $json ? 200 : 403); 
    }
}
