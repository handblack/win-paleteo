<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VlAlert;
use App\Models\VlvAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AlertLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $grantname  = 'ar';
    private $table      = 'alertline';
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = VlvAlert::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $fn = $row->path_full.'.'.$row->extension; 
        if(File::exists(public_path('images/fotos/'.$fn) && !$row->extension)){
            $path_foto = 'images/fotos/'.$fn;
        }else{
            $path_foto = 'images/no-image.png';
        }
        //dd($row);
        $pdf = Pdf::loadView('pdf.alert', [
            'row'       => $row,
            'path_foto' => $path_foto,
        ]);
        $pdf->setPaper('A4','portrait');
        $fil = 'informe_' . str_pad($row->id,4,'0',STR_PAD_LEFT).date('_Ymd_his').'.pdf';
        return $pdf->download($fil);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->isgrant("{$this->grantname}_isgrant"),403,'Acceso restringido');
        abort_if(!auth()->user()->isgrant("{$this->grantname}_iscreated"),403,'Acceso restringido');
        $row = VlAlert::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        return view('operation.alert_response',[
            'mode'  => 'edit',
            'url'   => route('alertline.update',$id),
            'row'   => $row,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'msg_cliente'   => 'required',
            'msg_mejora'    => 'required',
            'msg_fortaleza' => 'required',
            'msg_acciones'  => 'required'
        ]);
        $row = VlAlert::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        
        $foto           = $request->file('foto');
        $filename       = $foto->getClientOriginalName();
        $extension      = $foto->getClientOriginalExtension();

        $row->msg_cliente   = $request->msg_cliente;
        $row->msg_mejora    = $request->msg_mejora;
        $row->msg_fortaleza = $request->msg_fortaleza;
        $row->msg_acciones  = $request->msg_acciones;
        $row->response_at   = date('Y-m-d H:i:s');
        $row->response      = $request->response;
        $row->status        = 'R';
        $row->isactive      = 'N';
        $row->updated_by    = auth()->user()->id;
        $row->path_public   = $filename;
        $row->path_local    = User::get_token().'.'.$extension;
        $row->extension     = $extension;
        $row->save();
        // ahora almacenamos la imagen en el storage
        $imagenes= $request->file('foto')->store('images/fotos');
        Storage::url($imagenes);
        //Storage::disk('fotos')->put($row->path_local,  File::get($foto));
        /*
        Storage::disk('fotos')->put($row->path_local,  File::get($foto));
        */

        return redirect()->route('dashboard')->with('success','Mensaje enviado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
