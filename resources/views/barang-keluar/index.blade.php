<x-app-layout>

    <div class="min-h-screen bg-gray-100 p-6">

        <div class="mx-auto max-w-7xl">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Barang Keluar
                    </h1>

                    <p class="text-gray-500">
                        Pengelolaan material yang keluar dari warehouse
                    </p>
                </div>

                <a
                    href="{{ route('barang-keluar.create') }}"
                    class="rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700"
                >
                    + Tambah Barang Keluar
                </a>

            </div>


            {{-- SUCCESS --}}
            @if (session('success'))

                <div class="mb-5 rounded-lg bg-green-100 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- FILTER FORM --}}
            <form method="GET" action="{{ route('barang-keluar.index') }}"
                class="mb-6 rounded-xl border border-gray-300 bg-white p-5">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Dari Tanggal
                        </label>

                        <input
                            type="date"
                            name="dari_tanggal"
                            value="{{ request('dari_tanggal') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Sampai Tanggal
                        </label>

                        <input
                            type="date"
                            name="sampai_tanggal"
                            value="{{ request('sampai_tanggal') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Tujuan
                        </label>

                        <input
                            type="text"
                            name="tujuan"
                            value="{{ request('tujuan') }}"
                            placeholder="Cari tujuan..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2"
                        >
                    </div>

                </div>

                <div class="mt-4 flex gap-2">

                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-slate-800 px-4 py-2 font-semibold text-white hover:bg-slate-700"
                    >
                        Cari
                    </button>

                    <a
                        href="{{ route('barang-keluar.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2 font-semibold text-gray-700"
                    >
                        Reset
                    </a>

                </div>

            </form>


            {{-- TABLE --}}
            <div class="overflow-hidden rounded-xl border border-gray-300 bg-white shadow-sm">

                <div class="border-b px-5 py-4">

                    <h2 class="text-lg font-bold text-slate-900">
                        Daftar Barang Keluar
                    </h2>

                    <p class="text-sm text-gray-500">
                        Data pengeluaran material warehouse
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-slate-900 text-white">

                            <tr>

                                <th class="px-4 py-4 text-left">
                                    No
                                </th>

                                <th class="px-4 py-4 text-left">
                                    No. Keluar
                                </th>

                                <th class="px-4 py-4 text-left">
                                    Tanggal
                                </th>

                                <th class="px-4 py-4 text-left">
                                    Tujuan
                                </th>

                                <th class="px-4 py-4 text-center">
                                    Total Item
                                </th>

                                <th class="px-4 py-4 text-center">
                                    Total Qty
                                </th>

                                <th class="px-4 py-4 text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($barangKeluars as $index => $barangKeluar)

                                <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-4">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-4 py-4 font-semibold">
                                        {{ $barangKeluar->no_keluar }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $barangKeluar->tujuan }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        {{ $barangKeluar->details->count() }}
                                    </td>

                                    <td class="px-4 py-4 text-center font-semibold">
                                        {{ $barangKeluar->details->sum('qty') }}
                                    </td>

                                    <td class="px-4 py-4">

                                        <div class="flex justify-center gap-2">

                                            {{-- DETAIL --}}
                                            <a
                                                href="{{ route('barang-keluar.show', $barangKeluar) }}"
                                                class="rounded-md bg-gray-700 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800"
                                            >
                                                Detail
                                            </a>


                                            {{-- PRINT --}}
                                            <a
                                                href="{{ route('barang-keluar.print', $barangKeluar) }}"
                                                target="_blank"
                                                class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                                            >
                                                🖨 Print
                                            </a>


                                            {{-- HAPUS --}}
                                            <form
                                                action="{{ route('barang-keluar.destroy', $barangKeluar) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus barang keluar ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-4 py-10 text-center text-gray-500"
                                    >
                                        Belum ada data barang keluar.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>