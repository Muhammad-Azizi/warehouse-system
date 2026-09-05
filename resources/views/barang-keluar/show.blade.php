<x-app-layout>

    {{-- =========================================================
        CSS KHUSUS PRINT
    ========================================================== --}}
    <style>
        @media print {

            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            /* Sembunyikan seluruh layout Laravel */
            body * {
                visibility: hidden !important;
            }

            /* Hanya area print yang ditampilkan */
            #print-area,
            #print-area * {
                visibility: visible !important;
            }

            /* Area print memenuhi halaman */
            #print-area {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }

            /* Sembunyikan elemen yang tidak diperlukan */
            .no-print {
                display: none !important;
            }

            /* Hilangkan shadow */
            .print-card {
                box-shadow: none !important;
                border: 1px solid #d1d5db !important;
            }

            /* Jangan pecah card */
            .print-card,
            .print-table {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Judul */
            .print-title {
                font-size: 20px !important;
                color: #111827 !important;
            }

            .print-subtitle {
                font-size: 12px !important;
                color: #6b7280 !important;
            }

            /* Table */
            .print-table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 11px !important;
            }

            .print-table th,
            .print-table td {
                border: 1px solid #9ca3af !important;
                padding: 7px 8px !important;
                color: #111827 !important;
            }

            .print-table th {
                background: #f3f4f6 !important;
                font-weight: bold !important;
            }

            /* Hindari row terpotong */
            .print-table tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Card informasi */
            .info-grid {
                display: grid !important;
                grid-template-columns: repeat(4, 1fr) !important;
                gap: 15px !important;
            }

            /* Hapus rounded/shadow berlebihan */
            .print-rounded {
                border-radius: 4px !important;
            }
        }

        @media screen {

            .print-only-header {
                display: none;
            }

        }

        @media print {

            .print-only-header {
                display: block !important;
                margin-bottom: 18px;
            }

        }
    </style>


    {{-- =========================================================
        AREA PRINT
    ========================================================== --}}
    <div
        id="print-area"
        class="py-8"
    >

        <div class="max-w-6xl mx-auto px-6">

            {{-- =================================================
                HEADER HALAMAN
            ================================================== --}}
            <div class="mb-6">

                {{-- KEMBALI --}}
                <a
                    href="{{ route('barang-keluar.index') }}"
                    class="no-print text-blue-600 hover:underline"
                >
                    ← Kembali ke Barang Keluar
                </a>


                <div class="flex items-center justify-between mt-3">

                    <div>

                        <h2 class="print-title text-2xl font-bold text-gray-800">
                            Detail Barang Keluar
                        </h2>

                        <p class="print-subtitle text-gray-500">
                            Detail transaksi pengeluaran material
                        </p>

                    </div>


                    {{-- TOMBOL PRINT --}}
                    <div class="flex items-center gap-2 no-print">
                        <a
                            href="{{ route('barang-keluar.print', $barangKeluar) }}"
                            target="_blank"
                            class="px-5 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition flex items-center gap-2 text-sm font-medium"
                        >
                            🖨️ Cetak Dokumen
                        </a>
                    </div>

                </div>

            </div>


            {{-- =================================================
                HEADER KHUSUS SAAT PRINT
            ================================================== --}}
            <div class="print-only-header">

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        border-bottom:2px solid #111827;
                        padding-bottom:10px;
                        margin-bottom:15px;
                    "
                >

                    <div>

                        <div
                            style="
                                font-size:18px;
                                font-weight:bold;
                            "
                        >
                            PT SOLUSI BANGUN ANDALAS
                        </div>

                        <div
                            style="
                                font-size:11px;
                                color:#6b7280;
                            "
                        >
                            Sistem Informasi Warehouse
                        </div>

                    </div>


                    <div
                        style="
                            text-align:right;
                            font-size:12px;
                        "
                    >

                        <strong>DETAIL BARANG KELUAR</strong>

                    </div>

                </div>

            </div>


            {{-- =================================================
                INFORMASI TRANSAKSI
            ================================================== --}}
            <div
                class="print-card bg-white rounded-xl shadow-sm p-6 mb-6"
            >

                <div class="info-grid grid grid-cols-1 md:grid-cols-4 gap-6">


                    {{-- NO KELUAR --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            No. Keluar
                        </p>

                        <p class="font-bold text-gray-800 mt-1">
                            {{ $barangKeluar->no_keluar }}
                        </p>

                    </div>


                    {{-- TANGGAL --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Tanggal
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">

                            {{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d-m-Y') }}

                        </p>

                    </div>


                    {{-- TUJUAN --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Tujuan / Pemakai
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $barangKeluar->tujuan }}
                        </p>

                    </div>


                    {{-- TOTAL MATERIAL --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Total Material
                        </p>

                        <p class="font-bold text-blue-600 mt-1">

                            {{ $barangKeluar->details->count() }}
                            Item

                        </p>

                    </div>

                </div>


                {{-- =================================================
                    KETERANGAN
                ================================================== --}}
                @if ($barangKeluar->keterangan)

                    <div class="mt-6 pt-5 border-t">

                        <p class="text-sm text-gray-500">
                            Keterangan
                        </p>

                        <p class="text-gray-800 mt-1">
                            {{ $barangKeluar->keterangan }}
                        </p>

                    </div>

                @endif

            </div>


            {{-- =================================================
                MATERIAL YANG KELUAR
            ================================================== --}}
            <div
                class="print-card bg-white rounded-xl shadow-sm overflow-hidden"
            >

                <div class="px-6 py-5 border-b">

                    <h3 class="text-lg font-bold text-gray-800">
                        Material yang Keluar
                    </h3>

                </div>


                <div class="overflow-x-auto">

                    <table class="print-table w-full">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-4 text-left">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Nomor Item
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Material
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Quantity
                                </th>

                                <th class="px-6 py-4 text-center">
                                    UOM
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y">


                            @forelse ($barangKeluar->details as $detail)

                                <tr class="hover:bg-gray-50">

                                    {{-- NO --}}
                                    <td class="px-6 py-4">

                                        {{ $loop->iteration }}

                                    </td>


                                    {{-- NOMOR ITEM --}}
                                    <td class="px-6 py-4 font-semibold">

                                        {{ $detail->material->material_number ?? '-' }}

                                    </td>


                                    {{-- MATERIAL --}}
                                    <td class="px-6 py-4">

                                        {{ $detail->material->description ?? '-' }}

                                    </td>


                                    {{-- QUANTITY --}}
                                    <td class="px-6 py-4 text-center font-bold">

                                        {{ number_format($detail->qty) }}

                                    </td>


                                    {{-- UOM --}}
                                    <td class="px-6 py-4 text-center font-semibold">

                                        @if(!empty($detail->satuan))

                                            {{ $detail->satuan }}

                                        @elseif($detail->material && !empty($detail->material->uom))

                                            {{ $detail->material->uom }}

                                        @else

                                            -

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="px-6 py-10 text-center text-gray-500"
                                    >

                                        Tidak ada material pada transaksi ini.

                                    </td>

                                </tr>

                            @endforelse


                        </tbody>


                        {{-- =================================================
                            TOTAL
                        ================================================== --}}
                        <tfoot class="bg-gray-50">

                            <tr>

                                <td
                                    colspan="3"
                                    class="px-6 py-4 text-right font-bold"
                                >

                                    Total

                                </td>


                                <td
                                    class="px-6 py-4 text-center font-bold"
                                >

                                    {{ number_format($barangKeluar->details->sum('qty')) }}

                                </td>


                                <td></td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>


            {{-- =================================================
                TANDA TANGAN
            ================================================== --}}
            <div
                class="print-only-header"
                style="
                    margin-top:45px;
                "
            >

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        text-align:center;
                        font-size:12px;
                    "
                >

                    <div style="width:30%;">

                        <div>
                            Dibuat Oleh
                        </div>

                        <div style="height:65px;"></div>

                        <div
                            style="
                                border-top:1px solid #111827;
                                padding-top:5px;
                            "
                        >
                            Warehouse
                        </div>

                    </div>


                    <div style="width:30%;">

                        <div>
                            Diperiksa Oleh
                        </div>

                        <div style="height:65px;"></div>

                        <div
                            style="
                                border-top:1px solid #111827;
                                padding-top:5px;
                            "
                        >
                            Supervisor
                        </div>

                    </div>


                    <div style="width:30%;">

                        <div>
                            Diterima Oleh
                        </div>

                        <div style="height:65px;"></div>

                        <div
                            style="
                                border-top:1px solid #111827;
                                padding-top:5px;
                            "
                        >
                            Pemakai
                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


</x-app-layout>