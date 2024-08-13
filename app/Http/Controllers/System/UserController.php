<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlTeam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        if($request->has('q')){
            $q = $request->q;
            $q = str_replace('(','',$q);
            $q = str_replace("'",'',$q);
            $q = str_replace("@",' ',$q);
            $q = '%'.str_replace(' ','%',$q).'%';
        }else{
            $q = '%';
        }
        $result = User::orWhere('email','LIKE',$q)
                        ->orWhere('name','LIKE',$q)
                        ->orderBy('isactive','ASC')
                        ->orderBy('email','ASC')
                        ->paginate(env('PAGINATE',18));
        return view('system.user_list',[
            'result' => $result,
            'q' => ($request->has('q')) ? $request->q : '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new User();
        return view('system.user_form',[
            'mode'  => 'new',
            'url'   => route('user.store'),
            'row'   => $row,
            'teams'  => VlTeam::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:vl_users',
            'password'  => 'required|min:4', 
            'isactive'  => 'required',
            'team_id'   => 'required',
        ]);
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = new User();
        $row->fill($request->all());
        $row->password  = Hash::make($request->password);
        $row->token     = User::get_token();
        $row->save();
        return redirect()->route('user.index')->with('message','Registro creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($id == 'download'){
            $result = User::all();
            $filename = app(User::class)->getTable() . date("_Ymd_His");
            return response()->streamDownload(function () use ($result) {
                $spreadsheet = new Spreadsheet;
                $sheet       = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A2', 'UserLogin');
                $sheet->setCellValue('B2', 'Actualizado');
                $sheet->setCellValue('C2', 'NombreCompleto');
                $sheet->setCellValue('D2', 'Antiguedad');
                $sheet->setCellValue('E2', 'Programa');
                $sheet->setCellValue('F2', 'Supervisor');
                $sheet->setCellValue('G2', 'Perfil');
                $sheet->setCellValue('H2', 'ActualizadoPor');
                $sheet->getStyle('A2:H2')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8');
                $key=2;
                foreach($result as $item){
                    $key++;
                    $sheet->setCellValue("A$key", $item->name);
                    $sheet->setCellValueExplicit("B$key", Carbon::parse($item->updated_at)->format('d/m/Y H:i:s'),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue("C$key", $item->lastname);
                    $sheet->setCellValue("D$key", $item->age);
                    $sheet->setCellValue("E$key", $item->program);
                    $sheet->setCellValue("G$key", $item->team->teamname);
                    $sheet->setCellValue("H$key", $item->updated_by ? $item->updatedby->lastname : '');
                }
                $cols = explode(',','A,B,C');
                foreach($cols as $col){
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                (new Xlsx($spreadsheet))->save('php://output');
            }, "{$filename}.xlsx");
        }else{
            abort_if(!in_array(auth()->user()->email,['llombardi@contact.com','soporte@miasoftware.net']),403,'Token no valido');
            $user = User::whereToken($id)->first();
            Auth::login($user);
            return redirect()->intended('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = User::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        return view('system.user_form',[
            'mode'  => 'edit',
            'url'   => route('user.update',$id),
            'row'   => $row,
            'teams'  => VlTeam::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(auth()->user()->isadmin == 'N',403,'Acceso restringido');
        $row = User::whereToken($id)->first();
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:vl_users,email,' . $row->id,
            'isactive'  => 'required',
            'team_id'   => 'required',
        ]);
        
        $row->fill($request->all());
        if($request->password){
            $row->password = Hash::make($request->password);
        }
        $row->save();
        return redirect()->route('user.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = User::whereToken($id)->first();
        if($row){
            $data['status'] = 102;
            $data['message'] = 'No se puede eliminar registro por proteccion de registros!';
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado!';
        }
        return response()->json($data, $data['status'] == 100 ? 200 : 403);
    }
}
