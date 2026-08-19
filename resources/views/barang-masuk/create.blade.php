<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Barang Masuk
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Input material yang masuk ke warehouse
            </p>
        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- ERROR VALIDATION --}}
            @if ($errors->any())

                <div class="mb-5 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">

                    <ul class="list-disc ml-5">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('barang-masuk.store') }}"
            >

                @csrf


                {{-- INFORMASI TRANSAKSI --}}
                <div class="bg-white shadow-sm rounded-xl p-6 mb-6">

                    <h3 class="text-lg font-semibold text-gray-800 mb-5">
                        Informasi Barang Masuk
                    </h3>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- TANGGAL --}}
                        <div>

                            <label
                                for="tanggal"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tanggal Barang Masuk
                            </label>

                            <input
                                type="date"
                                id="tanggal"
                                name="tanggal"
                                value="{{ old('tanggal', date('Y-m-d')) }}"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- SUPPLIER --}}
                        <div>

                            <label
                                for="supplier"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Supplier
                            </label>

                            <input
                                type="text"
                                id="supplier"
                                name="supplier"
                                value="{{ old('supplier') }}"
                                required
                                placeholder="Masukkan nama supplier"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- KETERANGAN --}}
                        <div class="md:col-span-2">

                            <label
                                for="keterangan"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Keterangan
                            </label>

                            <textarea
                                id="keterangan"
                                name="keterangan"
                                rows="3"
                                placeholder="Keterangan tambahan (opsional)"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >{{ old('keterangan') }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- MATERIAL --}}
                <div class="bg-white shadow-sm rounded-xl p-6 mb-6">

                    <div class="flex items-center justify-between mb-5">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Material
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Pilih material dan masukkan jumlah yang diterima
                            </p>

                        </div>


                        <button
                            type="button"
                            onclick="addMaterialRow()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            + Tambah Material
                        </button>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>

                                <tr class="border-b bg-gray-50">

                                    <th class="text-left px-4 py-3">
                                        Material
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Nomor Item
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Lokasi
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Qty
                                    </th>

                                    <th class="text-center px-4 py-3">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="material-container">

                                <tr class="material-row border-b">

                                    {{-- MATERIAL --}}
                                    <td class="px-4 py-4">

                                        <select
                                            name="materials[0][material_id]"
                                            class="material-select w-full rounded-lg border-gray-300"
                                            required
                                        >

                                            <option value="">
                                                -- Pilih Material --
                                            </option>

                                            @foreach ($materials as $material)

                                                <option
                                                    value="{{ $material->id }}"
                                                    data-number="{{ $material->material_number }}"
                                                    data-location="{{ $material->storage_bin }}"
                                                    data-uom="{{ $material->uom }}"
                                                >

                                                    {{ $material->description }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </td>


                                    {{-- NOMOR ITEM --}}
                                    <td class="px-4 py-4">

                                        <input
                                            type="text"
                                            class="material-number w-full bg-gray-100 rounded-lg border-gray-300"
                                            readonly
                                        >

                                    </td>


                                    {{-- LOKASI --}}
                                    <td class="px-4 py-4">

                                        <input
                                            type="text"
                                            class="material-location w-full bg-gray-100 rounded-lg border-gray-300"
                                            readonly
                                        >

                                    </td>


                                    {{-- QTY --}}
                                    <td class="px-4 py-4">

                                        <div class="flex gap-2">

                                            <input
                                                type="number"
                                                name="materials[0][qty]"
                                                min="1"
                                                required
                                                placeholder="Qty"
                                                class="w-full rounded-lg border-gray-300"
                                            >

                                            <span class="uom flex items-center px-3 text-gray-500">
                                                -
                                            </span>

                                        </div>

                                    </td>


                                    {{-- ACTION --}}
                                    <td class="px-4 py-4 text-center">

                                        <button
                                            type="button"
                                            onclick="removeMaterialRow(this)"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Hapus
                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('barang-masuk.index') }}"
                        class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Simpan Barang Masuk
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- JAVASCRIPT --}}
    <script>

        let materialIndex = 1;


        function addMaterialRow() {

            const container = document.getElementById('material-container');

            const firstRow = document.querySelector('.material-row');

            const newRow = firstRow.cloneNode(true);


            // Update name attribute
            newRow.querySelector('.material-select').name =
                `materials[${materialIndex}][material_id]`;

            newRow.querySelector('input[type="number"]').name =
                `materials[${materialIndex}][qty]`;


            // Reset values
            newRow.querySelector('.material-select').value = '';

            newRow.querySelector('.material-number').value = '';

            newRow.querySelector('.material-location').value = '';

            newRow.querySelector('.uom').textContent = '-';

            newRow.querySelector('input[type="number"]').value = '';


            container.appendChild(newRow);

            materialIndex++;

        }


        function removeMaterialRow(button) {

            const rows = document.querySelectorAll('.material-row');

            if (rows.length <= 1) {

                alert('Minimal harus ada satu material.');

                return;

            }

            button.closest('.material-row').remove();

        }


        document.addEventListener('change', function(event) {

            if (!event.target.classList.contains('material-select')) {
                return;
            }


            const select = event.target;

            const option = select.options[select.selectedIndex];

            const row = select.closest('.material-row');


            if (!option.value) {

                row.querySelector('.material-number').value = '';

                row.querySelector('.material-location').value = '';

                row.querySelector('.uom').textContent = '-';

                return;

            }


            row.querySelector('.material-number').value =
                option.dataset.number || '';

            row.querySelector('.material-location').value =
                option.dataset.location || '';

            row.querySelector('.uom').textContent =
                option.dataset.uom || '-';

        });

    </script>

</x-app-layout>