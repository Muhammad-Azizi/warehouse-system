@extends('layouts.warehouse')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Picking List
            </h1>

            <p class="text-gray-500 mt-1">
                Daftar material yang harus disiapkan dari warehouse
            </p>
        </div>

        {{-- KEMBALI --}}
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center px-5 py-3
                  bg-gray-200 text-gray-700
                  rounded-lg hover:bg-gray-300 transition">

            ← Kembali

        </a>

    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-5 border-b">

            <h2 class="text-xl font-bold text-slate-800">
                Daftar Picking
            </h2>

            <p class="text-sm text-gray-500">
                Pilih transaksi barang keluar untuk melihat detail material
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

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

                        <th class="px-6 py-4 text-center">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($barangKeluars as $barangKeluar)

                        @php
                            $totalItem = $barangKeluar->details->count();
                            $totalQty = $barangKeluar->details->sum('qty');
                        @endphp

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <a href="{{ route('picking-list.show', $barangKeluar) }}"
                                   class="text-blue-600 font-semibold hover:underline">

                                    {{ $barangKeluar->no_keluar }}

                                </a>

                            </td>


                            <td class="px-6 py-4">

                                {{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d-m-Y') }}

                            </td>


                            <td class="px-6 py-4">

                                {{ $barangKeluar->tujuan }}

                            </td>


                            <td class="px-6 py-4 text-center">

                                {{ $totalItem }}

                            </td>


                            <td class="px-6 py-4 text-center font-semibold">

                                {{ $totalQty }}

                            </td>


                            <td class="px-6 py-4 text-center">

                                <a href="{{ route('picking-list.show', $barangKeluar) }}"
                                   class="inline-flex items-center px-4 py-2
                                          bg-blue-600 text-white rounded-lg
                                          hover:bg-blue-700">

                                    Lihat Picking

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-10 text-center text-gray-500">

                                Belum ada transaksi barang keluar.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection