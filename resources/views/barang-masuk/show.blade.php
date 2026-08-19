<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Barang Masuk
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Detail transaksi penerimaan material
                </p>

            </div>


            <div class="flex gap-2">

                <button
                    onclick="window.print()"
                    class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900"
                >
                    🖨 Print
                </button>


                <a
                    href="{{ route('barang-masuk.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                    Kembali
                </a>

            </div>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- INFORMASI TRANSAKSI --}}
            <div class="bg-white shadow-sm rounded-xl p-6 mb-6">

                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h3 class="text-lg font-semibold text-gray-800">
                            Informasi Barang Masuk
                        </h3>

                        <p class="text-sm text-gray-500">
                            Nomor transaksi:
                            <span class="font-semibold text-blue-600">
                                {{ $barangMasuk->no_masuk }}
                            </span>
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                    {{-- NO MASUK --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            No. Barang Masuk
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $barangMasuk->no_masuk }}
                        </p>

                    </div>


                    {{-- TANGGAL --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Tanggal
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">

                            {{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d-m-Y') }}

                        </p>

                    </div>


                    {{-- SUPPLIER --}}
                    <div>

                        <p class="text-sm text-gray-500">
                            Supplier
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $barangMasuk->supplier }}
                        </p>

                    </div>


                    {{-- KETERANGAN --}}
                    <div class="md:col-span-3">

                        <p class="text-sm text-gray-500">
                            Keterangan
                        </p>

                        <p class="text-gray-800 mt-1">

                            {{ $barangMasuk->keterangan ?: '-' }}

                        </p>

                    </div>

                </div>

            </div>



            {{-- DETAIL MATERIAL --}}
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">


                <div class="px-6 py-5 border-b">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Detail Material
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Material yang diterima pada transaksi ini
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">


                        <thead class="bg-gray-50 border-b">

                            <tr>

                                <th class="px-6 py-3 font-semibold">
                                    No
                                </th>

                                <th class="px-6 py-3 font-semibold">
                                    Nomor Item
                                </th>

                                <th class="px-6 py-3 font-semibold">
                                    Material
                                </th>

                                <th class="px-6 py-3 font-semibold">
                                    Lokasi
                                </th>

                                <th class="px-6 py-3 font-semibold text-center">
                                    Qty
                                </th>

                                <th class="px-6 py-3 font-semibold">
                                    UOM
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y">


                            @forelse ($barangMasuk->details as $index => $detail)

                                <tr class="hover:bg-gray-50">


                                    {{-- NO --}}
                                    <td class="px-6 py-4">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- NOMOR ITEM --}}
                                    <td class="px-6 py-4 font-medium text-blue-600">

                                        {{ $detail->material->material_number ?? '-' }}

                                    </td>


                                    {{-- MATERIAL --}}
                                    <td class="px-6 py-4">

                                        {{ $detail->material->description ?? '-' }}

                                    </td>


                                    {{-- LOKASI --}}
                                    <td class="px-6 py-4">

                                        {{ $detail->material->storage_bin ?? '-' }}

                                    </td>


                                    {{-- QTY --}}
                                    <td class="px-6 py-4 text-center font-semibold">

                                        {{ number_format($detail->qty) }}

                                    </td>


                                    {{-- UOM --}}
                                    <td class="px-6 py-4">

                                        {{ $detail->uom ?? ($detail->material->uom ?? '-') }}

                                    </td>


                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-10 text-center text-gray-500"
                                    >

                                        sudah ada detail material.

                                    </td>

                                </tr>

                            @endforelse


                        </tbody>


                        @if ($barangMasuk->details->count() > 0)

                            <tfoot class="bg-gray-50 border-t">

                                <tr>

                                    <td
                                        colspan="4"
                                        class="px-6 py-4 text-right font-semibold"
                                    >
                                        Total
                                    </td>

                                    <td class="px-6 py-4 text-center font-bold">

                                        {{ number_format($barangMasuk->details->sum('qty')) }}

                                    </td>

                                    <td></td>

                                </tr>

                            </tfoot>

                        @endif


                    </table>

                </div>

            </div>


        </div>

    </div>


    {{-- PRINT STYLE --}}
    <style>

        @media print {

            nav,
            header,
            button,
            a {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .shadow-sm {
                box-shadow: none !important;
            }

        }

    </style>


</x-app-layout>