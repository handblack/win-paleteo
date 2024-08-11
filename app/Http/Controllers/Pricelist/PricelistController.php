<?php

namespace App\Http\Controllers\Pricelist;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlChangeLog;
use App\Models\VlCurrency;
use App\Models\VlPriceList;
use App\Models\VlPriceListLine;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PricelistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'pl';
    private $table      = 'pricelist';
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
        $result = VlPriceList::orWhere('identity','LIKE',$q)
                        ->orWhere('shortname','LIKE',$q)
                        ->orderBy('identity','ASC')
                        ->orderBy('isactive','ASC')
                        ->paginate(env('PAGINATE',18));
        session([
            "session_{$this->table}_q_search" => $request->q,
        ]);
        return view("pricelist.{$this->table}_list",[
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
        $row = new VlPriceList();
        $log = VlChangeLog::where('record_id',0)->get();
        return view("pricelist.{$this->table}_form",[
            'mode'      => 'new',
            'url'       => route("{$this->table}.store"),
            'row'       => $row,
            'log'       => $log,
            'currency'  => VlCurrency::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identity'      => ['required'],
            'currency_id'   => ['required'],
            'isactive'      => ['required'],
        ]);
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new VlPriceList();
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
        $row = VlPriceList::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        session(['session_pricelist_id'         => $row->id]);
        session(['session_pricelist_token'      => $row->token]);
        session(['session_pricelist_identity'   => $row->identity]);
        session(['session_pricelist_shortname'  => $row->shortname]);
        return redirect()->route('pricelistline.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlPriceList::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $log = VlChangeLog::whereTablename(app(VlPriceList::class)->getTable())
                            ->whereRecordId($row->id)
                            ->limit(20)
                            ->orderBy('datelog','DESC')
                            ->get();
        return view("pricelist.{$this->table}_form",[
            'mode'      => 'edit',
            'url'       => route("{$this->table}.update",$id),
            'row'       => $row,
            'log'       => $log,
            'currency'  => VlCurrency::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isupdated"),403,'Acceso restringido');
        $row = VlPriceList::whereToken($id)->first();
        $request->validate([
            'identity'      => ['required'],
            'currency_id'   => ['required'],
            'isactive'      => ['required'],
        ]);
        /* Grabando LOG */
        $l = new VlChangeLog();
        $l->user_id     = auth()->user()->id;
        $l->tablename   = app(VlPriceList::class)->getTable();
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
        $grant = auth()->user()->isgrant("{$this->grantname}_isdeleted");
        $row = VlPriceList::whereToken($id)->first();
        if($row && $grant){
            if(
                VlProduct::where('familia_id',$row->familia_id)
                ->get()
                ->count('family_id')
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

    public function download_pricelist($id,$hash){
        $ids = md5('download'.date('Ymd'));
        abort_if($hash != $ids,403,'Token no valido de descarga');
        /* si envia id=0 se refiere toda la lista */
        $filename = date("Ymd_His");
        if($id == 0){
            $result = VlPriceList::all();
            $filename =  '_todo_'.$filename;
        }else{
            $result = VlPriceList::whereId($id)->get();
            $filename =  "_{$id}_".$filename;
        }
        return response()->streamDownload(function () use ($result) {
            $spreadsheet = new Spreadsheet;
            
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('detailsprice');
            
            $sheet->setCellValue('A1', 'LISTA');
            $sheet->setCellValue('B1', 'SKU');
            $sheet->setCellValue('C1', 'PRODUCTO');
            $sheet->setCellValue('D1', 'GRUPO');
            $sheet->setCellValue('E1', 'DIVISA');
            $sheet->setCellValue('F1', 'PU_SIN');
            $sheet->setCellValue('G1', 'PU_CON');
            $sheet->setCellValue('H1', 'KEY-ID');
            $sheet->getStyle('A1:H1')->applyFromArray(['font' => ['bold' => true]]);
            $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
            $key = 1;
            foreach($result as $lista){
                if(count($lista->lines)){
                    foreach($lista->lines as $line){
                        $key++;
                        $sheet->setCellValue("A$key", $line->pricelist->identity);
                        $sheet->setCellValueExplicit("B$key", $line->product->productcode,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue("C$key", $line->product->productname);
                        $sheet->setCellValue("D$key", $line->product->group->identity);
                        $sheet->setCellValue("E$key", $line->pricelist->currency->currencycode);
                        $sheet->setCellValue("F$key", $line->priceunit);
                        $sheet->setCellValue("G$key", $line->priceunit_wtax);
                        $sheet->setCellValue("H$key", $line->pricelist->id . '-' . $line->product->id);
                    }
                    $cols = explode(',','A,B,C,D,E,F,G,H');
                    foreach($cols as $col){
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                }
            }
            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle('listas');
            $sheet->setCellValue('A1', 'LISTA DE PRECIOS - '.date("Y-m-d H:i:s"));
            $sheet->setCellValue('A3', 'IDENTIFICADOR');
            $sheet->setCellValue('B3', 'SHORTNAME');
            $sheet->setCellValue('C3', 'CURRENCY');
            $sheet->setCellValue('D3', 'ID');
            $key = 3;
            foreach($result as $list){
                $key++;
                $sheet->setCellValue("A$key", $list->identity);
                $sheet->setCellValue("B$key", $list->shortname);
                $sheet->setCellValue("C$key", $list->currency->currencycode);
                $sheet->setCellValue("D$key", $list->id);
            }
            $sheet->getStyle('A3:D3')->applyFromArray(['font' => ['bold' => true]]);
            $sheet->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
            $cols = explode(',','A,B,C');
            foreach($cols as $col){
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            (new Xlsx($spreadsheet))->save('php://output');
        }, "pricelist_{$filename}.xlsx");
    }

    public function pricelist_upload_excel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        foreach ($sheetData as $index => $row) {
            // Ignorar la primera fila si contiene encabezados
            if ($index == 0) {
                continue;
            }
            if(isset($row[7])){
                $p = explode('-',$row[7]);
                if(isset($p[0]) && isset($p[1])){
                    // hay datos, asi que buscamos el indice para actualizar el dato
                    $pu1 = $row[5];
                    $pu2 = $row[6];
                    $line = VlPriceListLine::where('pricelist_id',$p[0])
                                            ->where('product_id',$p[1])
                                            ->first();
                    if($line){
                        $line->priceunit        = $pu1;
                        $line->priceunit_wtax   = $pu2;
                        $line->updated_by       = auth()->user()->id;
                        $line->save();
                    }
                }
            }else{
                return redirect()->route('pricelist.index')->with('error', 'El archivo no tiene la estructura correcta');        
            }
        }
        return redirect()->route('pricelist.index')->with('message', 'Archivo cargado');
    } 

}
