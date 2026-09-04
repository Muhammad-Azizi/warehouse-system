<x-app-layout>

    <div class="min-h-screen bg-gray-100 p-6">

        <div class="mx-auto max-w-4xl">

            <div class="mb-5">
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Material
                </h1>

                <p class="text-gray-500">
                    Perbarui data material warehouse.
                </p>
            </div>

            <div class="rounded-xl bg-white p-6 shadow">

                <form action="{{ route('materials.update', $material->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- MATERIAL NUMBER --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Material Number
                            </label>

                            <input
                                type="text"
                                name="material_number"
                                value="{{ old('material_number', $material->material_number) }}"
                                class="w-full rounded-lg border-gray-300"
                            >

                            @error('material_number')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- DESCRIPTION --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Description
                            </label>

                            <input
                                type="text"
                                name="description"
                                value="{{ old('description', $material->description) }}"
                                class="w-full rounded-lg border-gray-300"
                            >

                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- QTY STOCK --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Quantity / Stock
                            </label>

                            <input
                                type="number"
                                name="qty_stock"
                                value="{{ old('qty_stock', $material->qty_stock) }}"
                                min="0"
                                class="w-full rounded-lg border-gray-300"
                            >

                            @error('qty_stock')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- UOM --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                UOM
                            </label>

                            <select
                                name="uom"
                                class="w-full rounded-lg border-gray-300">

                                <option value="">Pilih UOM</option>

                                <option value="PC"
                                    {{ old('uom', $material->uom) == 'PC' ? 'selected' : '' }}>
                                    PC
                                </option>

                                <option value="M"
                                    {{ old('uom', $material->uom) == 'M' ? 'selected' : '' }}>
                                    M
                                </option>

                                <option value="KG"
                                    {{ old('uom', $material->uom) == 'KG' ? 'selected' : '' }}>
                                    KG
                                </option>

                                <option value="UNIT"
                                    {{ old('uom', $material->uom) == 'UNIT' ? 'selected' : '' }}>
                                    UNIT
                                </option>

                                <option value="SET"
                                    {{ old('uom', $material->uom) == 'SET' ? 'selected' : '' }}>
                                    SET
                                </option>

                            </select>

                            @error('uom')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- STORAGE BIN --}}
                        <div class="md:col-span-2">

                            <label class="mb-2 block text-sm font-medium">
                                Storage Bin / Lokasi
                            </label>

                            <input
                                type="text"
                                name="storage_bin"
                                value="{{ old('storage_bin', $material->storage_bin) }}"
                                class="w-full rounded-lg border-gray-300"
                            >

                            @error('storage_bin')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="mt-6 flex justify-end gap-3">

                        <a
                            href="{{ route('materials.index') }}"
                            class="rounded-lg bg-gray-200 px-5 py-2 text-gray-700">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2 font-semibold text-white hover:bg-blue-700">
                            Update Material
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>