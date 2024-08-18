@extends('layouts.pdf')

@section('content')
    <header>
        <table class="table-no-border" cellspacing="0" cellpadding="3" style="border-collapse: collapse;">
            <tr>

                <td style="vertical-align: top;">
                    <span style="font-size:14px;line-height:1.8;">
                        <strong>Informe de Atención</strong>
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
                    <td>ASUNTO EMAIL:</td>
                    <td>{{ $row->subject }}</td>
                </tr>
                <tr>
                    <td>FECHA Y HORA EMAIL:</td>
                    <td>{{ $row->created_at }}</td>
                </tr>
                <tr>
                    <td>SUPERVISOR A CARGO:</td>
                    <td>{{ $row->supervidor }}</td>
                </tr>
                <tr>
                    <td>FECHA Y HORA DE RESPUESTA:</td>
                    <td>{{ $row->response_at }}</td>
                </tr>
                <tr>
                    <td>ASESOR:</td>
                    <td>{{ $row->asesor }}</td>
                </tr>
                <tr>
                    <td>DNI ASESOR:</td>
                    <td>{{ $row->user->name }}</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td>
                        <span>VOZ CLIENTE</span>
                        <p>{{ $row->msg_cliente }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>OPORTUNIDAD DE MEJORA</span>
                        <p>{{ $row->msg_oportunidad }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>FORTALEZA EN LA LLAMDA</span>
                        <p>{{ $row->msg_fortaleza }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>ACCIONES CORRECTIVAS</span>
                        <p>{{ $row->msg_acciones }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>FOTO DE FEEDBACK</span>
                        {{ $path_foto }}
                        <p><img src="{{ $path_foto }}" alt=""></p>
                    </td>
                </tr>
            </table>
             
        </div>
    </main>

    

    <footer>
        <br>
 
        
    </footer>
@endsection
