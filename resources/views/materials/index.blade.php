@extends('layouts.warehouse')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-slate-900 rounded-xl px-6 py-5 text-white">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold">
                    Master Material
                </h1>

                <p class="mt-1 text-sm text-gray-300">
                    Pengelolaan data material warehouse
                </p>
            </div>

            <a
                href="{{ route('materials.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold hover:bg-blue-700 transition"
            >
                + Tambah Material
            </a>

        </div>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="rounded-lg bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- CONTENT --}}
    <div class="rounded-xl bg-white p-5 shadow-sm border">

        {{-- SEARCH --}}
        <form
            method="GET"
            action="{{ route('materials.index') }}"
            class="mb-5 flex gap-3"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari material / description / lokasi..."
                class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            >

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition"
            >
                Cari
            </button>

            @if(request('search'))

                <a
                    href="{{ route('materials.index') }}"
                    class="rounded-lg bg-gray-200 px-5 py-2 text-gray-700 hover:bg-gray-300 transition"
                >
                    Reset
                </a>

            @endif

        </form>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-900 text-white">

                    <tr>

                        <th class="px-4 py-3">
                            No
                        </th>

                        <th class="px-4 py-3">
                            Material Number
                        </th>

                        <th class="px-4 py-3">
                            Description
                        </th>

                        <th class="px-4 py-3">
                            Qty (Stock)
                        </th>

                        <th class="px-4 py-3">
                            UOM
                        </th>

                        <th class="px-4 py-3">
                            Storage Bin
                        </th>

                        <th class="px-4 py-3 text-center">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($materials as $material)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-4 py-3">
                                {{ $materials->firstItem() + $loop->index }}
                            </td>

                            <td class="px-4 py-3 font-semibold">
                                {{ $material->material_number }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $material->description }}
                            </td>

                            <td class="px-4 py-3 font-bold">
                                {{ number_format($material->qty_stock) }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $material->uom }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $material->storage_bin }}
                            </td>

                            <td class="px-4 py-3">

                                <div class="flex justify-center gap-2">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('materials.edit', $material) }}"
                                        class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 transition"
                                    >
                                        Edit
                                    </a>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('materials.destroy', $material) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus material ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700 transition"
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
                                Belum ada data material.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="mt-5">
            {{ $materials->links() }}
        </div>

    </div>

</div>

@endsection