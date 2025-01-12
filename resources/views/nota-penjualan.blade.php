<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        @page {
            margin: 0px;
            margin-right: 2cm;
        }
    </style>
</head>

<body>
    <p style="text-align: center;">Apotek Orange Bligo<br>Bligo, Kec Candi<br>Sidoarjo</p>
    <p style="text-align: center;">
        =======================================================================================================================================================================================================
    </p>
    <table style="width: 100%; border-collapse: collapse; border: none rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0); font-size: 13px;">No Nota : {{ $data->no_nota }}</td>
                <td style="width: 50%; border: none rgb(0, 0, 0); font-size: 13px; text-align: right;">
                    {{ carbon\Carbon::parse($data->created_at)->isoFormat('D MMM YYYY') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            {{-- <tr>
                <td style="width: 30%; border: none rgb(0, 0, 0); font-size: 13px;">Customer</td>
                <td style="width: 80%; border: none rgb(0, 0, 0); font-size: 13px; ">
                    {{ $data->customer->nama }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr> --}}
        </tbody>
    </table>
    <p style="text-align: center;">
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </p>
    @foreach ($data->details as $detail)
        <p style="font-size: 13px; margin-left: 0px;"> {{ $loop->iteration }}) {{ $detail->obat->nama_obat }}</p>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 25.0000%; font-size: 13px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ $detail->jumlah }} {{ $detail->satuan }} </td>

                    <td style="width: 25.0000%; font-size: 13px;">@ {{ $detail->harga }}</td>
                    <td style="width: 25.0000%; font-size: 13px;">&nbsp; &nbsp; &nbsp;{{ $detail->subtotal }}
                    </td>
                    {{-- <td style="width: 25.0000%; font-size: 13px;">
                        {{ formatAngka($detail->harga) }}&nbsp;&nbsp;&nbsp;&nbsp;</td> --}}
                </tr>
            </tbody>
        </table>
    @endforeach

    <p style="text-align: center;">
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </p>
    <table style="width: 100%; border-collapse: collapse; border: none rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Total</td>
                <td style="width: 50%; border: none rgb(0, 0, 0);">
                    <div style="text-align: right;">
                        {{ $data->total }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </td>
            </tr>
            {{-- @if ($data->jenis_pembayaran == 'kredit')
                <tr>
                    <td style="width: 50%; border: none rgb(0, 0, 0);">Jatuh Tempo</td>
                    <td style="width: 50%; border: none rgb(0, 0, 0);">
                        <div style="text-align: right; font-size: 13px;">
                            {{ carbon\Carbon::parse($data->jatuh_tempo)->isoFormat('D MMM YYYY') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                </tr>
            @endif
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Pembayaran</td>
                <td style="text-align: right; width: 50%; border: none rgb(0, 0, 0);">
                    {{ strtoupper($data->jenis_pembayaran) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr> --}}
        </tbody>
    </table>

    <p style="text-align: center;">Sales : {{ $data->user->username ?? '-' }}</p>
</body>

</html>
