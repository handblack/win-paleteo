<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\VlAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
        $row = VlAlert::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $pdf = Pdf::loadView('pdf.alert', [
            'row'   => $row,
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
            'response' => 'required'
        ]);
        $row = VlAlert::whereToken($id)->first();
        abort_if(!$row,403,'Token no valido');
        $row->response_at   = date('Y-m-d H:i:s');
        $row->response      = $request->response;
        $row->status        = 'R';
        $row->isactive      = 'N';
        $row->updated_by    = auth()->user()->id;
        $row->save();
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
