<x-app-layout>

    <div class="min-h-screen bg-gray-100">

        <div class="mx-auto max-w-6xl px-6 py-7">

            {{-- HEADER --}}
            <div class="mb-6 flex items-start justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Barang Masuk
                    </h1>

                    <p class="text-gray-500">
                        Data penerimaan material warehouse
                    </p>
                </div>

                <a href="{{ route('barang-masuk.create') }}"
                   class="rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">

                    + Tambah Barang Masuk

                </a>

            </div>


            {{-- FILTER --}}
            <div class="mb-5 rounded-xl border border-gray-300 bg-white p-4">

                <form method="GET"
                      action="{{ route('barang-masuk.index') }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                        {{-- DARI TANGGAL --}}
                        <div>
                            <label class="mb-1 block text-sm text-gray-700">
                                Dari Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                value="{{ request('tanggal_mulai') }}"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>


                        {{-- SAMPAI TANGGAL --}}
                        <div>
                            <label class="mb-1 block text-sm text-gray-700">
                                Sampai Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                value="{{ request('tanggal_selesai') }}"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>


                        {{-- SUPPLIER --}}
                        <div>
                            <label class="mb-1 block text-sm text-gray-700">
                                Supplier
                            </label>

                            <input
                                type="text"
                                name="supplier"
                                value="{{ request('supplier') }}"
                                placeholder="Cari supplier..."
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>


                    {{-- BUTTON --}}
                    <div class="mt-4 flex gap-2">

                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-slate-800 px-4 py-2.5 font-semibold text-white hover:bg-slate-900">
                            Cari
                        </button>

                        <a
                            href="{{ route('barang-masuk.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-semibold text-gray-700 hover:bg-gray-100">
                            Reset
                        </a>

                    </div>

                </form>

            </div>


            {{-- DAFTAR BARANG MASUK --}}
            <div class="overflow-hidden rounded-xl border border-gray-300 bg-white">

                <div class="flex items-center justify-between border-b px-5 py-4">

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Daftar Barang Masuk
                        </h2>

                        <p class="text-sm text-gray-500">
                            Data penerimaan material warehouse
                        </p>
                    </div>

                </div>


                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-900 text-white">

                            <tr>

                                <th class="px-4 py-4 text-left text-sm">
                                    No
                                </th>

                                <th class="px-4 py-4 text-left text-sm">
                                    No. Masuk
                                </th>

                                <th class="px-4 py-4 text-left text-sm">
                                    Tanggal
                                </th>

                                <th class="px-4 py-4 text-left text-sm">
                                    Supplier
                                </th>

                                <th class="px-4 py-4 text-center text-sm">
                                    Total Item
                                </th>

                                <th class="px-4 py-4 text-center text-sm">
                                    Total Qty
                                </th>

                                <th class="px-4 py-4 text-center text-sm">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($barangMasuks as $index => $barangMasuk)

                                <tr class="border-b hover:bg-gray-50">

                                    {{-- NO --}}
                                    <td class="px-4 py-4">
                                        {{ $index + 1 }}
                                    </td>


                                    {{-- NO MASUK --}}
                                    <td class="px-4 py-4 font-semibold">
                                        {{ $barangMasuk->no_masuk }}
                                    </td>


                                    {{-- TANGGAL --}}
                                    <td class="px-4 py-4">
                                        {{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d/m/Y') }}
                                    </td>


                                    {{-- SUPPLIER --}}
                                    <td class="px-4 py-4">
                                        {{ $barangMasuk->supplier }}
                                    </td>


                                    {{-- TOTAL ITEM --}}
                                    <td class="px-4 py-4 text-center">
                                        {{ $barangMasuk->details->count() }}
                                    </td>


                                    {{-- TOTAL QTY --}}
                                    <td class="px-4 py-4 text-center font-semibold">
                                        {{ $barangMasuk->details->sum('qty') }}
                                    </td>


                                    {{-- ACTION --}}
                                    <td class="px-4 py-4">

                                        <div class="flex justify-center gap-2">

                                            {{-- PRINT --}}
                                            <a
                                                href="{{ route('barang-masuk.print', $barangMasuk) }}"
                                                target="_blank"
                                                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">

                                                🖨 Print

                                            </a>


                                            {{-- HAPUS --}}
                                            <form
                                                action="{{ route('barang-masuk.destroy', $barangMasuk) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus barang masuk ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">

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
                                        class="px-4 py-10 text-center text-gray-500">

                                        Belum ada data barang masuk.

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