<x-app-layout>

    <x-slot name="title">
        Picking List
    </x-slot>


    {{-- ====================================================== --}}
    {{-- AREA PRINT --}}
    {{-- ====================================================== --}}

    <div class="print-area">

        <div class="space-y-6">


            {{-- ================================================== --}}
            {{-- HEADER --}}
            {{-- ================================================== --}}

            <div class="flex items-start justify-between no-print">

                <div>

                    <a
                        href="{{ route('picking-list.index') }}"
                        class="text-blue-600 hover:underline"
                    >
                        ← Kembali ke Picking List
                    </a>


                    <h1 class="text-3xl font-bold text-slate-800 mt-3">
                        Picking List
                    </h1>


                    <p class="text-gray-500 mt-1">
                        Daftar material yang harus disiapkan
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- TOMBOL PRINT --}}
                {{-- ================================================= --}}

                <button
                    type="button"
                    onclick="window.print()"
                    class="no-print"
                    style="
                        width: 138px !important;
                        height: 40px !important;

                        min-width: 138px !important;
                        max-width: 138px !important;

                        min-height: 40px !important;
                        max-height: 40px !important;

                        padding: 0 !important;
                        margin: 0 !important;

                        display: inline-flex !important;

                        align-items: center !important;
                        justify-content: center !important;

                        gap: 7px !important;

                        background-color: #1e293b !important;
                        color: #ffffff !important;

                        border: none !important;
                        border-radius: 8px !important;

                        font-size: 14px !important;
                        font-weight: 700 !important;

                        line-height: 1 !important;

                        box-shadow: none !important;

                        cursor: pointer !important;

                        white-space: nowrap !important;

                        box-sizing: border-box !important;
                    "
                >

                    <span
                        style="
                            font-size: 14px !important;
                            line-height: 1 !important;
                        "
                    >
                        🖨️
                    </span>


                    <span
                        style="
                            font-size: 14px !important;
                            line-height: 1 !important;
                        "
                    >
                        Print
                    </span>

                </button>

            </div>


            {{-- ================================================== --}}
            {{-- INFORMASI TRANSAKSI --}}
            {{-- ================================================== --}}

            <div class="bg-white rounded-xl shadow p-6">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                    {{-- NO BARANG KELUAR --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            No. Barang Keluar
                        </p>

                        <p class="text-lg font-bold text-slate-800 mt-1">
                            {{ $barangKeluar->no_keluar }}
                        </p>

                    </div>


                    {{-- TANGGAL --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Tanggal
                        </p>

                        <p class="text-lg font-semibold text-slate-800 mt-1">

                            {{
                                \Carbon\Carbon::parse(
                                    $barangKeluar->tanggal
                                )->format('d-m-Y')
                            }}

                        </p>

                    </div>


                    {{-- TUJUAN --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Tujuan / Pemakai
                        </p>

                        <p class="text-lg font-semibold text-slate-800 mt-1">
                            {{ $barangKeluar->tujuan }}
                        </p>

                    </div>


                </div>

            </div>


            {{-- ================================================== --}}
            {{-- MATERIAL --}}
            {{-- ================================================== --}}

            <div class="bg-white rounded-xl shadow overflow-hidden">


                {{-- JUDUL TABLE --}}
                <div class="px-6 py-5 border-b">

                    <h2 class="text-xl font-bold text-slate-800">
                        Material yang Harus Dipicking
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar material yang harus disiapkan dari warehouse
                    </p>

                </div>


                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full print-table">

                        <thead class="bg-slate-100">

                            <tr>

                                <th class="px-6 py-4 text-center">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Material Number
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Description
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Qty
                                </th>

                                <th class="px-6 py-4 text-center">
                                    UOM
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Storage Bin
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Picking
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y">

                            @forelse($barangKeluar->details as $detail)

                                <tr class="hover:bg-slate-50">

                                    {{-- NO --}}
                                    <td class="px-6 py-4 text-center">
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- MATERIAL NUMBER --}}
                                    <td class="px-6 py-4 font-semibold">

                                        {{ $detail->material->material_number ?? '-' }}

                                    </td>


                                    {{-- DESCRIPTION --}}
                                    <td class="px-6 py-4">

                                        {{ $detail->material->description ?? '-' }}

                                    </td>


                                    {{-- QTY --}}
                                    <td class="px-6 py-4 text-center font-bold">

                                        {{ $detail->qty }}

                                    </td>


                                    {{-- UOM --}}
                                    <td class="px-6 py-4 text-center">

                                        {{ $detail->material->uom ?? '-' }}

                                    </td>


                                    {{-- STORAGE BIN --}}
                                    <td class="px-6 py-4">

                                        <span
                                            class="
                                                inline-flex
                                                px-3
                                                py-1
                                                bg-blue-100
                                                text-blue-700
                                                rounded-lg
                                                font-semibold
                                            "
                                        >

                                            {{ $detail->material->storage_bin ?? '-' }}

                                        </span>

                                    </td>


                                    {{-- PICKING --}}
                                    <td class="px-6 py-4 text-center">

                                        <label
                                            class="
                                                inline-flex
                                                items-center
                                                gap-2
                                                cursor-pointer
                                            "
                                        >

                                            <input
                                                type="checkbox"
                                                class="
                                                    w-5
                                                    h-5
                                                    rounded
                                                    border-gray-300
                                                    text-blue-600
                                                    focus:ring-blue-500
                                                "
                                            >

                                            <span class="text-sm">
                                                Sudah
                                            </span>

                                        </label>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="
                                            px-6
                                            py-10
                                            text-center
                                            text-gray-500
                                        "
                                    >

                                        Tidak ada detail material.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ================================================== --}}
            {{-- KETERANGAN --}}
            {{-- ================================================== --}}

            @if($barangKeluar->keterangan)

                <div class="bg-white rounded-xl shadow p-6">

                    <h3 class="font-bold text-slate-800 mb-2">
                        Keterangan
                    </h3>

                    <p class="text-gray-600">
                        {{ $barangKeluar->keterangan }}
                    </p>

                </div>

            @endif


            {{-- ================================================== --}}
            {{-- FOOTER PRINT --}}
            {{-- ================================================== --}}

            <div class="print-footer">

                <div
                    class="
                        flex
                        justify-between
                        mt-8
                        pt-4
                        border-t
                        border-gray-400
                        text-sm
                        text-gray-600
                    "
                >

                    <span>

                        Dicetak:
                        {{ now()->format('d-m-Y H:i') }}

                    </span>


                    <span>

                        Sistem Informasi Warehouse

                    </span>

                </div>

            </div>


        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- PRINT STYLE --}}
    {{-- ====================================================== --}}

    <style>

        /* =====================================================
           NORMAL
           ===================================================== */

        .print-footer {
            display: none;
        }


        /* =====================================================
           PRINT
           ===================================================== */

        @media print {

            @page {

                size: A4 landscape;

                margin: 12mm;

            }


            html,
            body {

                margin: 0 !important;

                padding: 0 !important;

                background: #ffffff !important;

            }


            /* SIDEBAR */

            aside {

                display: none !important;

            }


            /* TOPBAR */

            body > div > main > header {

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


            /* NO PRINT */

            .no-print {

                display: none !important;

            }


            /* PRINT AREA */

            .print-area {

                display: block !important;

                width: 100% !important;

                margin: 0 !important;

                padding: 0 !important;

            }


            /* CARD */

            .bg-white {

                background: #ffffff !important;

            }


            .shadow,
            .shadow-sm {

                box-shadow: none !important;

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

                color: #000000 !important;

            }


            .print-table thead {

                background: #e5e7eb !important;

            }


            .print-table th {

                font-weight: bold !important;

            }


            /* STORAGE BIN */

            .print-table span {

                background: transparent !important;

                color: #000000 !important;

                padding: 0 !important;

            }


            /* CHECKBOX */

            input[type="checkbox"] {

                width: 16px !important;

                height: 16px !important;

            }


            /* FOOTER */

            .print-footer {

                display: block !important;

            }


            button,
            a {

                text-decoration: none !important;

            }

        }

    </style>


</x-app-layout>