@extends('layouts.warehouse')

@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- STATISTICS --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">

        {{-- TOTAL MATERIAL --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border">

            <p class="text-sm text-gray-500">
                Total Material
            </p>

            <h3 class="text-3xl font-bold mt-2">
                {{ number_format($totalMaterial ?? 0) }}
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Item
            </p>

        </div>


        {{-- TOTAL STOCK --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border">

            <p class="text-sm text-gray-500">
                Total Stock
            </p>

            <h3 class="text-3xl font-bold mt-2">
                {{ number_format($totalStock ?? 0) }}
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Pcs
            </p>

        </div>


        {{-- BARANG MASUK --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border">

            <p class="text-sm text-gray-500">
                Barang Masuk
            </p>

            <h3 class="text-3xl font-bold mt-2 text-green-600">
                {{ number_format($barangMasukHariIni ?? 0) }}
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Hari Ini
            </p>

        </div>


        {{-- BARANG KELUAR --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border">

            <p class="text-sm text-gray-500">
                Barang Keluar
            </p>

            <h3 class="text-3xl font-bold mt-2 text-red-600">
                {{ number_format($barangKeluarHariIni ?? 0) }}
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Hari Ini
            </p>

        </div>


        {{-- PICKING LIST --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border">

            <p class="text-sm text-gray-500">
                Picking List
            </p>

            <h3 class="text-3xl font-bold mt-2 text-blue-600">
                {{ number_format($totalPickingList ?? 0) }}
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Total
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- BARANG MASUK & BARANG KELUAR TERBARU --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


        {{-- BARANG MASUK TERBARU --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">

            <div class="flex justify-between items-center mb-5">

                <div>

                    <h3 class="font-bold text-lg">
                        Barang Masuk Terbaru
                    </h3>

                    <p class="text-sm text-gray-500">
                        Data penerimaan material terbaru
                    </p>

                </div>

                <a
                    href="{{ route('barang-masuk.index') }}"
                    class="text-sm text-blue-600 hover:underline"
                >
                    Lihat Semua
                </a>

            </div>


            <div class="space-y-4">

                @forelse($barangMasukTerbaru ?? [] as $barangMasuk)

                    <div class="flex gap-4 border-b pb-4">

                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            📥
                        </div>


                        <div class="flex-1">

                            <p class="font-semibold">
                                {{ $barangMasuk->no_masuk }}
                            </p>


                            <p class="text-sm text-gray-500">

                                {{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d-m-Y') }}

                                @if($barangMasuk->supplier)
                                    · {{ $barangMasuk->supplier }}
                                @endif

                            </p>

                        </div>

                    </div>

                @empty

                    <p class="text-sm text-gray-500">
                        Belum ada data barang masuk.
                    </p>

                @endforelse

            </div>

        </div>



        {{-- BARANG KELUAR TERBARU --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">

            <div class="flex justify-between items-center mb-5">

                <div>

                    <h3 class="font-bold text-lg">
                        Barang Keluar Terbaru
                    </h3>

                    <p class="text-sm text-gray-500">
                        Data pengeluaran material terbaru
                    </p>

                </div>


                <a
                    href="{{ route('barang-keluar.index') }}"
                    class="text-sm text-blue-600 hover:underline"
                >
                    Lihat Semua
                </a>

            </div>


            <div class="space-y-4">

                @forelse($barangKeluarTerbaru ?? [] as $barangKeluar)

                    <div class="flex gap-4 border-b pb-4">

                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            📤
                        </div>


                        <div class="flex-1">

                            <p class="font-semibold">
                                {{ $barangKeluar->no_keluar }}
                            </p>


                            <p class="text-sm text-gray-500">

                                {{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d-m-Y') }}

                                @if($barangKeluar->tujuan)
                                    · {{ $barangKeluar->tujuan }}
                                @endif

                            </p>

                        </div>

                    </div>

                @empty

                    <p class="text-sm text-gray-500">
                        Belum ada data barang keluar.
                    </p>

                @endforelse

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- RINGKASAN STOK --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow-sm border p-6">

        <div class="flex justify-between items-center mb-5">

            <div>

                <h3 class="font-bold text-lg">
                    Ringkasan Warehouse
                </h3>

                <p class="text-sm text-gray-500">
                    Kondisi data warehouse saat ini
                </p>

            </div>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


            {{-- MATERIAL --}}
            <div class="border rounded-xl p-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        📦
                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
                            Jenis Material
                        </p>

                        <p class="text-xl font-bold">
                            {{ number_format($totalMaterial ?? 0) }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- STOCK --}}
            <div class="border rounded-xl p-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        📊
                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
                            Total Stok
                        </p>

                        <p class="text-xl font-bold text-green-600">
                            {{ number_format($totalStock ?? 0) }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- PICKING --}}
            <div class="border rounded-xl p-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        📋
                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
                            Picking List
                        </p>

                        <p class="text-xl font-bold text-blue-600">
                            {{ number_format($totalPickingList ?? 0) }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection