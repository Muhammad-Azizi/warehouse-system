@extends('layouts.warehouse')

@section('content')

<div class="space-y-6">

    {{-- ====================================================== --}}
    {{-- HEADER HALAMAN --}}
    {{-- ====================================================== --}}

    <div class="flex items-center justify-between no-print">

        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                Barang Keluar
            </h2>

            <p class="text-gray-500 mt-1">
                Pengelolaan material yang keluar dari warehouse
            </p>

        </div>


        {{-- TAMBAH BARANG KELUAR --}}
        <a
            href="{{ route('barang-keluar.create') }}"
            class="inline-flex items-center gap-2
                   px-5 py-3
                   bg-blue-600
                   text-white
                   font-semibold
                   rounded-lg
                   hover:bg-blue-700
                   transition"
        >

            <span class="text-xl">
                +
            </span>

            Tambah Barang Keluar

        </a>

    </div>


    {{-- ====================================================== --}}
    {{-- FILTER --}}
    {{-- ====================================================== --}}

    <div class="bg-white rounded-xl shadow-sm border p-6 no-print">

        <form
            method="GET"
            action="{{ route('barang-keluar.index') }}"
        >

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- DARI TANGGAL --}}
                <div>

                    <label
                        class="block text-sm font-medium
                               text-gray-700 mb-2"
                    >
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        name="dari_tanggal"
                        value="{{ request('dari_tanggal') }}"
                        class="w-full border-gray-300
                               rounded-lg"
                    >

                </div>


                {{-- SAMPAI TANGGAL --}}
                <div>

                    <label
                        class="block text-sm font-medium
                               text-gray-700 mb-2"
                    >
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        name="sampai_tanggal"
                        value="{{ request('sampai_tanggal') }}"
                        class="w-full border-gray-300
                               rounded-lg"
                    >

                </div>


                {{-- TUJUAN --}}
                <div>

                    <label
                        class="block text-sm font-medium
                               text-gray-700 mb-2"
                    >
                        Tujuan
                    </label>

                    <input
                        type="text"
                        name="tujuan"
                        value="{{ request('tujuan') }}"
                        placeholder="Cari tujuan..."
                        class="w-full border-gray-300
                               rounded-lg"
                    >

                </div>

            </div>


            {{-- BUTTON CARI --}}
            <div class="mt-5">

                <button
                    type="submit"
                    class="w-full
                           bg-gray-800
                           text-white
                           py-3
                           rounded-lg
                           font-semibold
                           hover:bg-gray-900
                           transition"
                >
                    Cari
                </button>

            </div>

        </form>

    </div>


    {{-- ====================================================== --}}
    {{-- AREA PRINT --}}
    {{-- ====================================================== --}}

    <div class="print-area space-y-6">


        {{-- ================================================== --}}
        {{-- JUDUL PRINT --}}
        {{-- ================================================== --}}

        <div class="print-header">

            <div class="text-center">

                <h1 class="text-2xl font-bold text-slate-900">
                    PT. SOLUSI BANGUN ANDALAS
                </h1>

                <h2 class="text-xl font-bold text-slate-900">
                    LHOKNGA WAREHOUSE
                </h2>

                <div class="mt-3 border-b-2 border-gray-800"></div>

                <h3 class="text-xl font-bold mt-4">
                    LAPORAN BARANG KELUAR
                </h3>

                <p class="text-sm text-gray-600 mt-1">
                    Data pengeluaran material warehouse
                </p>

                @if(request('dari_tanggal') || request('sampai_tanggal'))

                    <p class="text-sm text-gray-600 mt-2">

                        Periode:

                        @if(request('dari_tanggal'))

                            {{ \Carbon\Carbon::parse(
                                request('dari_tanggal')
                            )->format('d-m-Y') }}

                        @else

                            -

                        @endif

                        s/d

                        @if(request('sampai_tanggal'))

                            {{ \Carbon\Carbon::parse(
                                request('sampai_tanggal')
                            )->format('d-m-Y') }}

                        @else

                            -

                        @endif

                    </p>

                @endif

            </div>

        </div>


        {{-- ================================================== --}}
        {{-- TABLE --}}
        {{-- ================================================== --}}

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden print-card">


            {{-- TABLE HEADER --}}
            <div class="flex items-center justify-between
                        px-6 py-5 border-b no-print">

                <div>

                    <h3 class="text-xl font-bold text-gray-800">
                        Daftar Barang Keluar
                    </h3>

                    <p class="text-gray-500">
                        Data pengeluaran material warehouse
                    </p>

                </div>


                {{-- PRINT --}}
                <button
                    onclick="window.print()"
                    type="button"
                    class="px-5 py-2
                           border border-gray-300
                           rounded-lg
                           hover:bg-gray-50
                           transition"
                >
                    🖨 Print
                </button>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full print-table">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4
                                       text-left
                                       text-sm
                                       font-semibold
                                       border-b">
                                No
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-sm
                                       font-semibold
                                       border-b">
                                No. Keluar
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-sm
                                       font-semibold
                                       border-b">
                                Tanggal
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-sm
                                       font-semibold
                                       border-b">
                                Tujuan
                            </th>

                            <th class="px-6 py-4
                                       text-center
                                       text-sm
                                       font-semibold
                                       border-b">
                                Total Item
                            </th>

                            <th class="px-6 py-4
                                       text-center
                                       text-sm
                                       font-semibold
                                       border-b">
                                Total Qty
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse ($barangKeluars as $barangKeluar)

                            <tr class="hover:bg-gray-50">

                                {{-- NO --}}
                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- NO KELUAR --}}
                                <td class="px-6 py-4 font-semibold">

                                    {{ $barangKeluar->no_keluar }}

                                </td>


                                {{-- TANGGAL --}}
                                <td class="px-6 py-4">

                                    {{
                                        \Carbon\Carbon::parse(
                                            $barangKeluar->tanggal
                                        )->format('d-m-Y')
                                    }}

                                </td>


                                {{-- TUJUAN --}}
                                <td class="px-6 py-4">

                                    {{ $barangKeluar->tujuan }}

                                </td>


                                {{-- TOTAL ITEM --}}
                                <td class="px-6 py-4 text-center">

                                    {{ $barangKeluar->details->count() }}

                                </td>


                                {{-- TOTAL QTY --}}
                                <td class="px-6 py-4
                                           text-center
                                           font-semibold">

                                    {{ $barangKeluar->details->sum('qty') }}

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-10
                                           text-center
                                           text-gray-500"
                                >

                                    Belum ada data barang keluar.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    {{-- TOTAL --}}
                    @if($barangKeluars->count() > 0)

                        <tfoot class="bg-gray-50">

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-4
                                           text-right
                                           font-bold
                                           border-t"
                                >
                                    Total Qty
                                </td>

                                <td
                                    class="px-6 py-4
                                           text-center
                                           font-bold
                                           border-t"
                                >

                                    {{
                                        $barangKeluars->sum(
                                            fn($item) =>
                                            $item->details->sum('qty')
                                        )
                                    }}

                                </td>

                            </tr>

                        </tfoot>

                    @endif

                </table>

            </div>

        </div>


        {{-- ================================================== --}}
        {{-- FOOTER PRINT --}}
        {{-- ================================================== --}}

        <div class="print-footer">

            <div class="flex justify-between mt-8 pt-4
                        border-t border-gray-400 text-sm">

                <div>

                    Dicetak:
                    {{ now()->format('d-m-Y H:i') }}

                </div>

                <div>

                    Sistem Informasi Warehouse

                </div>

            </div>

        </div>


    </div>

</div>


{{-- ====================================================== --}}
{{-- PRINT STYLE --}}
{{-- ====================================================== --}}

<style>

    @media print {

        @page {

            size: A4 landscape;

            margin: 12mm;

        }


        /* BODY */

        html,
        body {

            background: white !important;

            margin: 0 !important;

            padding: 0 !important;

        }


        /* SIDEBAR */

        aside {

            display: none !important;

        }


        /* TOPBAR */

        header {

            display: none !important;

        }


        /* MAIN */

        main {

            width: 100% !important;

            min-width: 100% !important;

            margin: 0 !important;

            padding: 0 !important;

        }


        main > section {

            padding: 0 !important;

            margin: 0 !important;

        }


        /* ELEMENT NO PRINT */

        .no-print {

            display: none !important;

        }


        /* AREA PRINT */

        .print-area {

            width: 100% !important;

            display: block !important;

        }


        /* HEADER PRINT */

        .print-header {

            display: block !important;

            margin-bottom: 20px !important;

        }


        /* CARD */

        .print-card {

            box-shadow: none !important;

            border: 0 !important;

            border-radius: 0 !important;

            overflow: visible !important;

        }


        /* TABLE */

        .print-table {

            width: 100% !important;

            border-collapse: collapse !important;

            font-size: 11px !important;

        }


        .print-table th,
        .print-table td {

            border: 1px solid #000 !important;

            padding: 8px !important;

            color: #000 !important;

        }


        .print-table thead {

            background: #e5e7eb !important;

        }


        .print-table th {

            font-weight: bold !important;

        }


        /* FOOTER */

        .print-footer {

            display: block !important;

        }


        /* SHADOW */

        .shadow-sm,
        .shadow {

            box-shadow: none !important;

        }

    }

</style>

@endsection