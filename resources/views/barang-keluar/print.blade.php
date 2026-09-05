<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Print Barang Keluar - {{ $barangKeluar->no_keluar }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            background: #fff;
        }

        .header {
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header h2 {
            margin: 4px 0 15px;
            font-size: 20px;
        }

        .line {
            border-top: 2px solid #111827;
            margin: 15px 0;
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h2 {
            margin: 0 0 6px;
            font-size: 20px;
        }

        .title p {
            margin: 0;
            color: #475569;
        }

        .info {
            width: 100%;
            margin-bottom: 20px;
        }

        .info td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info .label {
            width: 120px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #111827;
            padding: 9px;
        }

        th {
            background: #f1f5f9;
            text-align: center;
        }

        td.center {
            text-align: center;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        @media print {

            body {
                padding: 15px;
            }

            .print-button {
                display: none;
            }

        }

    </style>

</head>


<body>

    {{-- PRINT BUTTON --}}
    <button
        class="print-button"
        onclick="window.print()"
    >
        🖨 Print
    </button>


    {{-- HEADER --}}

    <div class="header">

        <h1>
            PT. SOLUSI BANGUN ANDALAS
        </h1>

        <h2>
            LHOKNGA WAREHOUSE
        </h2>

    </div>


    <div class="line"></div>


    {{-- TITLE --}}

    <div class="title">

        <h2>
            LAPORAN BARANG KELUAR
        </h2>

        <p>
            Data pengeluaran material warehouse
        </p>

    </div>


    {{-- INFORMASI --}}

    <table class="info">

        <tr>
            <td class="label">
                No. Keluar
            </td>

            <td>
                : {{ $barangKeluar->no_keluar }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Tanggal
            </td>

            <td>
                :
                {{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d/m/Y') }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Tujuan
            </td>

            <td>
                : {{ $barangKeluar->tujuan }}
            </td>
        </tr>

        @if ($barangKeluar->keterangan)

            <tr>
                <td class="label">
                    Keterangan
                </td>

                <td>
                    : {{ $barangKeluar->keterangan }}
                </td>
            </tr>

        @endif

    </table>


    {{-- DETAIL MATERIAL --}}

    <table>

        <thead>

            <tr>

                <th style="width: 50px;">
                    No
                </th>

                <th>
                    Material Number
                </th>

                <th>
                    Description
                </th>

                <th style="width: 100px;">
                    Qty
                </th>

                <th style="width: 100px;">
                    UOM
                </th>

                <th>
                    Storage Bin
                </th>

            </tr>

        </thead>


        <tbody>

            @foreach ($barangKeluar->details as $index => $detail)

                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $detail->material->material_number }}
                    </td>

                    <td>
                        {{ $detail->material->description }}
                    </td>

                    <td class="center">
                        {{ $detail->qty }}
                    </td>

                    <td class="center">
                        {{ $detail->satuan }}
                    </td>

                    <td>
                        {{ $detail->material->storage_bin }}
                    </td>

                </tr>

            @endforeach


            <tr class="total">

                <td colspan="3" style="text-align: right;">
                    TOTAL
                </td>

                <td class="center">
                    {{ $barangKeluar->details->sum('qty') }}
                </td>

                <td colspan="2">
                </td>

            </tr>

        </tbody>

    </table>


    {{-- FOOTER --}}

    <div class="footer">

        <div>
            Dicetak:
            {{ now()->format('d-m-Y H:i') }}
        </div>

        <div>
            Sistem Informasi Warehouse
        </div>

    </div>


</body>

</html>