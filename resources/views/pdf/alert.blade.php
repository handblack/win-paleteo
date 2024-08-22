@extends('layouts.pdf')

@section('content')
    <header>
        <table class="table-no-border" cellspacing="0" cellpadding="3" style="border-collapse: collapse;">
            <tr>

                <td style="vertical-align: top;align:center">
                    <span style="font-size:18px;line-height:1.8;">
                        <strong>INFORME DE ATENCION</strong>
                    </span>

                </td>
                <td style="width:180px;">
                     
                </td>
            </tr>
        </table>
    </header>

    <main>
        <div class="margin-top">
            <table width="100%">
                <tr>
                    <td width="50%" class="border">ASUNTO EMAIL:</td>
                    <td width="50%" class="border">{{ $row->subject }}</td>
                </tr>
                <tr>
                    <td class="border">FECHA Y HORA EMAIL:</td>
                    <td class="border">{{ $row->created_at }}</td>
                </tr>
                <tr>
                    <td class="border">SUPERVISOR A CARGO:</td>
                    <td class="border">{{ $row->supervidor }}</td>
                </tr>
                <tr>
                    <td class="border">FECHA Y HORA DE RESPUESTA:</td>
                    <td class="border">{{ $row->response_at }}</td>
                </tr>
                <tr>
                    <td class="border">ASESOR:</td>
                    <td class="border">{{ $row->asesor }}</td>
                </tr>
                <tr>
                    <td class="border">DNI ASESOR:</td>
                    <td class="border">{{ $row->user->name }}</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td class="border">
                        <span><strong>VOZ CLIENTE</strong></span>
                        <p>{{ $row->msg_cliente }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="border">
                        <span><strong>OPORTUNIDAD DE MEJORA</strong></span>
                        <p>{{ $row->msg_mejora }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="border">
                        <span><strong>FORTALEZA EN LA LLAMDA</strong></span>
                        <p>{{ $row->msg_fortaleza }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="border">
                        <span><strong>ACCIONES CORRECTIVAS</strong></span>
                        <p>{{ $row->msg_acciones }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="border">
                        <span><strong>FOTO DE FEEDBACK:</strong></span>
                        {{ $path_foto }}
                        <p><img src="{{ $path_foto }}" alt="" style="max-width: 100%;"></p>
                    </td>
                </tr>
            </table>
             
        </div>
    </main>

    

    <footer>
        <br>
 
        
    </footer>
@endsection
