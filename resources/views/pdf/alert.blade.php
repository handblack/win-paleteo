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
            <table class="table-no-border">
                <tr>
                    <td class="width-30" style="vertical-align: top;">
                        <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                            <tr>
                                <td><strong>Fecha</strong></td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td>{{ $row->date_voucher }}</td>
                            </tr>
                            <tr>
                                <td><strong>Invoice</strong></td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td>{{ $row->number_voucher }}<</td>
                            </tr>
                            <tr>
                                <td><strong>Moneda</strong></td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td class="width-70" style="vertical-align: top;">
                        <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                            <tr>
                                <td style="vertical-align: top;"><strong>Proveedor</strong></td>
                                <td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top; width:105px;"><strong>Almacen Ingreso</strong></td>
                                <td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;"><strong>Agencia Aduana</strong></td>
                                <td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;"><strong>Usuario</strong></td>
                                <td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </main>

    
    {{--
    <div class="footer-div">
        <p>Thank you, <br />@ItSolutionStuff.com</p>
    </div>
    --}}

    <footer>
        <br>
        <table width="100%">
            <tr>
                <td class="border-sign">
                    <table width="100%">
                        <tr>
                            <td>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">_____________________<br><small> ALMACEN</small></td>
                        </tr>
                    </table>
                </td>
                <td class="border-sign">
                    <table width="100%">
                        <tr>
                            <td>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">_____________________<br><small> VIGILANCIA</small></td>
                        </tr>
                    </table>
                </td>
                <td class="border-sign">
                    <table width="100%">
                        <tr>
                            <td>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">_____________________<br><small> DESTINO</small></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="50%">
                     
                </td>
                <td style="text-align: right;vertical-align: top;">
                    <span style="font-size: 10px;"><small>Generado: {{ date('d/m/Y H:i:s') }}</small></span>
                </td>
            </tr>
        </table>
    </footer>
@endsection
