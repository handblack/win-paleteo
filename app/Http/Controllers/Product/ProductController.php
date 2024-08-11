<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlChangeLog;
use App\Models\VlProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isgrant('pr_isgrant'),403,'Acceso restringido');
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace("@",' ',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = session('session_provider_q_search');
        }
        $result = VlProduct::orWhere('productname','LIKE',$q)
                        ->orWhere('productcode','LIKE',$q)
                        ->orderBy('productname','ASC')
                        ->orderBy('isactive','ASC')
                        ->paginate(env('PAGINATE',18))
                        ->withQueryString();
        session([
            'session_provider_q_search' => $request->q,
        ]);
        return view('product.pr_list',[
            'result' => $result,
            'q' => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->isgrant('pr_isgrant'),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant('pr_iscreated'),403,'Acceso restringido');
        $row = new VlProduct();
        $row->subfamilia_id     = 1;
        $row->tejido_id         = 1;
        $row->hilatura_id       = 1;
        $row->titulo_id         = 1; 
        $row->gama_id           = 1;
        $row->tenido_id         = 1;
        $row->acabado_id        = 1;
        //elementos ocultos
        $row->presentacion_id   = 1;
        $row->um_id             = 1;
        $log = VlChangeLog::where('record_id',0)->get();
        return view('product.pr_form',[
            'mode'  => 'new',
            'url'   => route('product.store'),
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
            'productname'   => ['required'],
            'isactive'      => ['required'],
        ]);
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $code = User::get_param('SEQUENCE.PRODUCT.SKU');
        $code++;
        $row = new VlProduct();
        $row->fill($request->all());
        $row->productcode   = str_pad($code,4,'0',STR_PAD_LEFT);
        $row->token         = User::get_token();
        $row->created_by    = auth()->user()->id;
        $row->save();
        User::set_param('SEQUENCE.PRODUCT.SKU',$code);
        return redirect()->route('product.index')->with('message','Registro creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ch = md5('download'.date('Ymd'));
        abort_if($id != $ch,403,'Token no valido de descarga');
        $result = VlProduct::all();
        $filename = date("Ymd_His");
        return response()->streamDownload(function () use ($result) {
            $spreadsheet = new Spreadsheet;
            $sheet       = $spreadsheet->getActiveSheet();
            #$sheet->setCellValue('A1', 'CODIGO');
            $sheet->setCellValue('A1', 'SKU');
            $sheet->setCellValue('B1', 'PRODUCTO');
            $sheet->setCellValue('C1', 'GRUPO');
            $sheet->setCellValue('D1', 'FAMILIA');
            $sheet->setCellValue('E1', 'SUBFAMILIA');
            $sheet->setCellValue('F1', 'TEJIDO');
            $sheet->setCellValue('G1', 'HILATURA');
            $sheet->setCellValue('H1', 'TITULO');
            $sheet->setCellValue('I1', 'GAMA');
            $sheet->setCellValue('J1', 'TEÑIDO');
            $sheet->setCellValue('K1', 'ACABADO');
            $sheet->getStyle('A1:K1')->applyFromArray(['font' => ['bold' => true]]);
            $sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
            $key=1;
            foreach($result as $product){
                $key++;
                #$sheet->setCellValueExplicit("A$key", $product->id, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("A$key", $product->productcode,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("B$key", $product->productname);
                $sheet->setCellValue("C$key", $product->group->identity);
                $sheet->setCellValue("D$key", $product->familia->identity);
                $sheet->setCellValue("E$key", $product->subfamilia->identity);
                $sheet->setCellValue("F$key", $product->tejido->identity);
                $sheet->setCellValue("G$key", $product->hilatura->identity);
                $sheet->setCellValue("H$key", $product->titulo->identity);
                $sheet->setCellValue("I$key", $product->gama->identity);
                $sheet->setCellValue("J$key", $product->tenido->identity);
                $sheet->setCellValue("K$key", $product->acabado->identity);
            }
            $cols = explode(',','A,B,C,D,E,F,G,H,I,J');
            foreach($cols as $col){
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            (new Xlsx($spreadsheet))->save('php://output');
        }, "product_{$filename}.xlsx");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->isgrant('pr_isupdated'),403,'Acceso restringido');
        $row = VlProduct::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $log = VlChangeLog::whereTablename(app(VlProduct::class)->getTable())
                            ->whereRecordId($row->id)
                            ->limit(20)
                            ->orderBy('datelog','DESC')
                            ->get();
        return view('product.pr_form',[
            'mode'  => 'edit',
            'url'   => route('product.update',$id),
            'row'   => $row,
            'log'   => $log,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->isgrant('pr_isupdated'),403,'Acceso restringido');
        $row = VlProduct::whereToken($id)->first();
        $request->validate([
            'productname'   => ['required'],
            //'productcode'   => ['required','vl_products,productcode,' . $row->id],
            'isactive'      => ['required','in:Y,N'],
        ]);       
        /* Grabando LOG */
        $l = new VlChangeLog();
        $l->user_id     = auth()->user()->id;
        $l->tablename   = app(VlProduct::class)->getTable();
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
        return redirect()->route('product.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grant = auth()->user()->isgrant('pr_isdeleted');
        $row = VlProduct::whereToken($id)->first();
        if($row && $grant){
            $data['status'] = 102;
            $data['message'] = 'No se puede eliminar registro por proteccion de registros!';
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
