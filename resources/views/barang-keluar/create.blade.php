<x-app-layout>

    <div class="py-8">

        <div class="max-w-6xl mx-auto px-6">

            {{-- HEADER --}}
            <div class="mb-6">

                <a
                    href="{{ route('barang-keluar.index') }}"
                    class="text-blue-600 hover:underline"
                >
                    ← Kembali ke Barang Keluar
                </a>

                <h2 class="text-2xl font-bold text-gray-800 mt-3">
                    Tambah Barang Keluar
                </h2>

                <p class="text-gray-500 mt-1">
                    Input material yang keluar dari warehouse
                </p>

            </div>


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-lg mb-6">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM --}}
            <form
                method="POST"
                action="{{ route('barang-keluar.store') }}"
            >

                @csrf


                {{-- INFORMASI TRANSAKSI --}}
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

                    <h3 class="text-lg font-bold text-gray-800 mb-5">
                        Informasi Barang Keluar
                    </h3>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        {{-- NO KELUAR --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No. Keluar
                            </label>

                            <input
                                type="text"
                                value="{{ 'BK-' . date('Y') . '-' . str_pad((\App\Models\BarangKeluar::count() + 1), 4, '0', STR_PAD_LEFT) }}"
                                class="w-full border-gray-300 rounded-lg bg-gray-50"
                                readonly
                            >

                        </div>


                        {{-- TANGGAL --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                value="{{ old('tanggal', date('Y-m-d')) }}"
                                required
                                class="w-full border-gray-300 rounded-lg"
                            >

                        </div>


                        {{-- TUJUAN --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tujuan / Pemakai
                            </label>

                            <input
                                type="text"
                                name="tujuan"
                                value="{{ old('tujuan') }}"
                                required
                                placeholder="Contoh: Maintenance"
                                class="w-full border-gray-300 rounded-lg"
                            >

                        </div>

                    </div>


                    {{-- KETERANGAN --}}
                    <div class="mt-5">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="3"
                            placeholder="Keterangan tambahan..."
                            class="w-full border-gray-300 rounded-lg"
                        >{{ old('keterangan') }}</textarea>

                    </div>

                </div>


                {{-- MATERIAL --}}
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

                    <div class="flex items-center justify-between mb-5">

                        <div>

                            <h3 class="text-lg font-bold text-gray-800">
                                Material Keluar
                            </h3>

                            <p class="text-sm text-gray-500">
                                Pilih material dan masukkan jumlah yang keluar
                            </p>

                        </div>


                        <button
                            type="button"
                            onclick="addMaterial()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            + Tambah Material
                        </button>

                    </div>


                    <div id="material-container">

                        {{-- BARIS MATERIAL --}}
                        <div class="material-row grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">

                            {{-- MATERIAL --}}
                            <div class="md:col-span-6">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Material
                                </label>

                                <select
                                    name="materials[0][material_id]"
                                    required
                                    class="material-select w-full border-gray-300 rounded-lg"
                                    onchange="updateStock(this)"
                                >

                                    <option value="">
                                        -- Pilih Material --
                                    </option>

                                    @foreach ($materials as $material)

                                        <option
                                            value="{{ $material->id }}"
                                            data-stock="{{ $material->qty_stock }}"
                                            data-uom="{{ $material->uom }}"
                                        >

                                            {{ $material->material_number }}
                                            -
                                            {{ $material->description }}

                                            (Stok:
                                            {{ $material->qty_stock }}
                                            {{ $material->uom }})

                                        </option>

                                    @endforeach

                                </select>

                                <p class="stock-info text-xs text-gray-500 mt-1"></p>

                            </div>


                            {{-- QTY --}}
                            <div class="md:col-span-3">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantity
                                </label>

                                <input
                                    type="number"
                                    name="materials[0][qty]"
                                    min="1"
                                    required
                                    class="qty-input w-full border-gray-300 rounded-lg"
                                    oninput="checkQty(this)"
                                >

                                <p class="qty-error text-xs text-red-600 mt-1"></p>

                            </div>


                            {{-- UOM --}}
                            <div class="md:col-span-2">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    UOM
                                </label>

                                <input
                                    type="text"
                                    name="materials[0][uom]"
                                    class="uom-input w-full border-gray-300 rounded-lg bg-gray-50"
                                    readonly
                                >

                            </div>


                            {{-- HAPUS --}}
                            <div class="md:col-span-1 flex items-end">

                                <button
                                    type="button"
                                    onclick="removeMaterial(this)"
                                    class="w-full px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200"
                                >
                                    ✕
                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('barang-keluar.index') }}"
                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700"
                    >
                        Simpan Barang Keluar
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- JAVASCRIPT --}}
    <script>

        let materialIndex = 1;


        function addMaterial()
        {
            const container = document.getElementById('material-container');

            const firstRow = document.querySelector('.material-row');

            const newRow = firstRow.cloneNode(true);


            // SELECT MATERIAL
            const select = newRow.querySelector('.material-select');

            select.name = `materials[${materialIndex}][material_id]`;

            select.value = '';


            // QUANTITY
            const qty = newRow.querySelector('.qty-input');

            qty.name = `materials[${materialIndex}][qty]`;

            qty.value = '';

            qty.max = '';


            // UOM
            const uom = newRow.querySelector('.uom-input');

            uom.name = `materials[${materialIndex}][uom]`;

            uom.value = '';


            // STOCK INFO
            newRow.querySelector('.stock-info').innerText = '';


            // ERROR QTY
            newRow.querySelector('.qty-error').innerText = '';


            container.appendChild(newRow);

            materialIndex++;
        }


        function removeMaterial(button)
        {
            const rows = document.querySelectorAll('.material-row');

            if (rows.length > 1) {

                button.closest('.material-row').remove();

            }
        }


        function updateStock(select)
        {
            const option = select.options[select.selectedIndex];

            const stock = parseInt(option.dataset.stock || 0);

            const uom = option.dataset.uom || '';

            const row = select.closest('.material-row');


            // Tampilkan stok
            row.querySelector('.stock-info').innerText =
                `Stok tersedia: ${stock} ${uom}`;


            // Isi UOM
            row.querySelector('.uom-input').value = uom;


            // Set maksimal quantity
            const qty = row.querySelector('.qty-input');

            qty.max = stock;

            qty.value = '';


            // Reset error
            row.querySelector('.qty-error').innerText = '';
        }


        function checkQty(input)
        {
            const row = input.closest('.material-row');

            const select = row.querySelector('.material-select');

            const option = select.options[select.selectedIndex];

            const stock = parseInt(option.dataset.stock || 0);

            const qty = parseInt(input.value || 0);

            const error = row.querySelector('.qty-error');


            if (qty > stock) {

                error.innerText =
                    `Qty melebihi stok. Stok tersedia: ${stock}`;

                input.setCustomValidity(
                    'Quantity melebihi stok tersedia.'
                );

            } else {

                error.innerText = '';

                input.setCustomValidity('');
            }
        }

    </script>

</x-app-layout>