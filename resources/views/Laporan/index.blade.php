@extends('layouts.warehouse')

@section('content')

<div class="space-y-6">

    {{-- ====================================================== --}}
    {{-- HEADER --}}
    {{-- ====================================================== --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-2xl font-bold text-slate-900">
                Laporan Warehouse
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Laporan stok material, barang masuk, barang keluar, dan picking list
            </p>

        </div>


        {{-- DOWNLOAD EXCEL --}}
        <a
            href="{{ route('laporan.export.excel', [
                'jenis_laporan' => $jenisLaporan ?? 'semua',
                'dari_tanggal' => $dariTanggal ?? '',
                'sampai_tanggal' => $sampaiTanggal ?? ''
            ]) }}"
            style="background-color: #16a34a !important; color: #ffffff !important;"
            class="inline-flex items-center justify-center gap-2
                   px-6 py-3
                   rounded-lg
                   font-semibold
                   shadow-md
                   hover:opacity-90
                   transition
                   cursor-pointer"
        >

            <span class="text-lg">
                📥
            </span>

            <span>
                Download Excel
            </span>

        </a>

    </div>


    {{-- ====================================================== --}}
    {{-- FILTER LAPORAN --}}
    {{-- ====================================================== --}}

    <div class="bg-white rounded-xl shadow-sm border p-6">

        <form
            method="GET"
            action="{{ route('laporan.index') }}"
        >

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- JENIS LAPORAN --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Laporan
                    </label>

                    <select
                        name="jenis_laporan"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option
                            value="semua"
                            {{ ($jenisLaporan ?? 'semua') == 'semua' ? 'selected' : '' }}
                        >
                            Semua Laporan
                        </option>

                        <option
                            value="stok"
                            {{ ($jenisLaporan ?? '') == 'stok' ? 'selected' : '' }}
                        >
                            Stok Material
                        </option>

                        <option
                            value="barang_masuk"
                            {{ ($jenisLaporan ?? '') == 'barang_masuk' ? 'selected' : '' }}
                        >
                            Barang Masuk
                        </option>

                        <option
                            value="barang_keluar"
                            {{ ($jenisLaporan ?? '') == 'barang_keluar' ? 'selected' : '' }}
                        >
                            Barang Keluar
                        </option>

                        <option
                            value="picking_list"
                            {{ ($jenisLaporan ?? '') == 'picking_list' ? 'selected' : '' }}
                        >
                            Picking List
                        </option>

                    </select>

                </div>


                {{-- DARI TANGGAL --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        name="dari_tanggal"
                        value="{{ $dariTanggal ?? '' }}"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- SAMPAI TANGGAL --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        name="sampai_tanggal"
                        value="{{ $sampaiTanggal ?? '' }}"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="flex gap-3 mt-5">

                <button
                    type="submit"
                    class="flex-1 bg-slate-800 text-white
                           py-3 rounded-lg font-semibold
                           hover:bg-slate-900 transition"
                >
                    Tampilkan Laporan
                </button>


                <a
                    href="{{ route('laporan.index') }}"
                    class="px-6 py-3 bg-gray-200 text-gray-700
                           rounded-lg font-semibold
                           hover:bg-gray-300 transition"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- ====================================================== --}}
    {{-- RINGKASAN --}}
    {{-- ====================================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- TOTAL MATERIAL --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500">
                Total Material
            </p>

            <h3 class="text-2xl font-bold text-slate-900 mt-2">
                {{ $materials->count() }}
            </h3>

        </div>


        {{-- BARANG MASUK --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500">
                Transaksi Barang Masuk
            </p>

            <h3 class="text-2xl font-bold text-green-600 mt-2">
                {{ $barangMasuk->count() }}
            </h3>

        </div>


        {{-- BARANG KELUAR --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500">
                Transaksi Barang Keluar
            </p>

            <h3 class="text-2xl font-bold text-red-600 mt-2">
                {{ $barangKeluar->count() }}
            </h3>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- LAPORAN STOK MATERIAL --}}
    {{-- ====================================================== --}}

    @if(
        ($jenisLaporan ?? 'semua') === 'semua' ||
        ($jenisLaporan ?? '') === 'stok'
    )

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-lg font-bold text-slate-900">
                    Laporan Stok Material
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar stok material saat ini
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                No
                            </th>

                            <th class="px-6 py-4 text-left">
                                Material Number
                            </th>

                            <th class="px-6 py-4 text-left">
                                Description
                            </th>

                            <th class="px-6 py-4 text-right">
                                Stock
                            </th>

                            <th class="px-6 py-4 text-left">
                                UOM
                            </th>

                            <th class="px-6 py-4 text-left">
                                Storage Bin
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse($materials as $material)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 font-semibold">
                                    {{ $material->material_number ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $material->description ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-right font-semibold">
                                    {{ number_format($material->qty_stock ?? 0) }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $material->uom ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $material->storage_bin ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-10 text-center text-gray-500"
                                >
                                    Belum ada data material.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- LAPORAN BARANG MASUK --}}
    {{-- ====================================================== --}}

    @if(
        ($jenisLaporan ?? 'semua') === 'semua' ||
        ($jenisLaporan ?? '') === 'barang_masuk'
    )

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-lg font-bold text-slate-900">
                    Laporan Barang Masuk
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Data penerimaan material warehouse
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                No
                            </th>

                            <th class="px-6 py-4 text-left">
                                No. Masuk
                            </th>

                            <th class="px-6 py-4 text-left">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left">
                                Supplier
                            </th>

                            <th class="px-6 py-4 text-center">
                                Total Item
                            </th>

                            <th class="px-6 py-4 text-center">
                                Total Qty
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse($barangMasuk as $item)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-blue-600">
                                    {{ $item->no_masuk }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->tanggal?->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->supplier }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $item->details->count() }}
                                </td>

                                <td class="px-6 py-4 text-center font-semibold">
                                    {{ $item->details->sum('qty') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-10 text-center text-gray-500"
                                >
                                    Tidak ada data barang masuk sesuai filter.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    @if($barangMasuk->count() > 0)

                        <tfoot class="bg-gray-50 border-t">

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-right font-bold"
                                >
                                    Total Qty
                                </td>

                                <td class="px-6 py-4 text-center font-bold">

                                    {{ $barangMasuk->sum(fn($item) => $item->details->sum('qty')) }}

                                </td>

                            </tr>

                        </tfoot>

                    @endif

                </table>

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- LAPORAN BARANG KELUAR / PICKING LIST --}}
    {{-- ====================================================== --}}

    @if(
        ($jenisLaporan ?? 'semua') === 'semua' ||
        ($jenisLaporan ?? '') === 'barang_keluar' ||
        ($jenisLaporan ?? '') === 'picking_list'
    )

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-lg font-bold text-slate-900">

                    {{
                        ($jenisLaporan ?? '') === 'picking_list'
                        ? 'Laporan Picking List'
                        : 'Laporan Barang Keluar'
                    }}

                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Data material yang keluar dari warehouse
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                No
                            </th>

                            <th class="px-6 py-4 text-left">
                                No. Keluar
                            </th>

                            <th class="px-6 py-4 text-left">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left">
                                Tujuan / Pemakai
                            </th>

                            <th class="px-6 py-4 text-center">
                                Total Item
                            </th>

                            <th class="px-6 py-4 text-center">
                                Total Qty
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse($barangKeluar as $item)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-blue-600">
                                    {{ $item->no_keluar }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->tanggal?->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->tujuan }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $item->details->count() }}
                                </td>

                                <td class="px-6 py-4 text-center font-semibold">
                                    {{ $item->details->sum('qty') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-10 text-center text-gray-500"
                                >
                                    Tidak ada data barang keluar sesuai filter.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    @if($barangKeluar->count() > 0)

                        <tfoot class="bg-gray-50 border-t">

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-right font-bold"
                                >
                                    Total Qty
                                </td>

                                <td class="px-6 py-4 text-center font-bold">

                                    {{ $barangKeluar->sum(fn($item) => $item->details->sum('qty')) }}

                                </td>

                            </tr>

                        </tfoot>

                    @endif

                </table>

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- INFORMASI FILTER --}}
    {{-- ====================================================== --}}

    @if($dariTanggal || $sampaiTanggal)

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">

            <p class="font-semibold text-blue-800">
                Filter Aktif
            </p>

            <p class="text-sm text-blue-700 mt-1">

                @if($dariTanggal)

                    Dari:
                    {{ \Carbon\Carbon::parse($dariTanggal)->format('d-m-Y') }}

                @endif

                @if($sampaiTanggal)

                    @if($dariTanggal)
                        &nbsp; sampai &nbsp;
                    @endif

                    Sampai:
                    {{ \Carbon\Carbon::parse($sampaiTanggal)->format('d-m-Y') }}

                @endif

            </p>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- DOWNLOAD INFO --}}
    {{-- ====================================================== --}}

    <div
        style="background-color: #f0fdf4; border: 1px solid #bbf7d0;"
        class="rounded-xl p-5"
    >

        <div class="flex items-center gap-3">

            <div class="text-2xl">
                📊
            </div>

            <div>

                <p
                    style="color: #166534;"
                    class="font-semibold"
                >
                    Export Excel
                </p>

                <p
                    style="color: #15803d;"
                    class="text-sm mt-1"
                >
                    Klik tombol Download Excel di bagian atas untuk mengunduh
                    laporan sesuai filter yang dipilih.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection