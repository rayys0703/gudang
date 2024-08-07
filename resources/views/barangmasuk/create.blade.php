<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barang Masuk') }}
        </h2>
    </x-slot>

    {{-- 
    dibawah csrf
    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3 w-full"
                            role="alert">
                            <strong class="font-bold">Ups!</strong> Terjadi kesalahan:
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                     --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="flex flex-wrap" method="post" action="{{ route('barangmasuk.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3 w-full"
                            role="alert">
                            <strong class="font-bold">Ups!</strong> Terjadi kesalahan:
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="w-full">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="jenis_barang"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                                    Barang</label>
                                <select id="jenis_barang" name="jenis_barang_id"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Pilih jenis barang</option>
                                    @foreach ($jenis_barang as $d)
                                        <option value="{{ $d->id }}"
                                            {{ $d->id == $jenis_barang_id ? 'selected' : '' }}>
                                            {{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="barang"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barang</label>
                                <select id="barang" name="barang_id"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Pilih barang</option>
                                    @if (isset($barangMasuk))
                                        @foreach ($barangbyjenis as $d)
                                            <option value="{{ $d->id }}"
                                                {{ $d->id == $barangMasuk->barang_id ? 'selected' : '' }}>
                                                {{ $d->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="keterangan"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                                <input type="text" id="keterangan" name="keterangan"
                                    class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="tanggal"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                    Masuk</label>
                                <input type="date" id="tanggal" name="tanggal"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required />
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
                        <div class="mb-5">
                            <label for="quantity-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Barang:</label>
                            <div class="relative flex items-center max-w-[8rem]">
                                <button type="button" id="decrement-button"
                                    class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 1h16" />
                                    </svg>
                                </button>
                                <input type="text" id="quantity-input" data-input-counter data-input-counter-min="1"
                                    data-input-counter-max="100" aria-describedby="helper-text-explanation"
                                    class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="1" required />
                                <button type="button" id="increment-button"
                                    class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 1v16M1 9h16" />
                                    </svg>
                                </button>
                            </div>
                            <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Input
                                jumlah barang dengan minimal 1 dan maksimal 100.</p>
                        </div>

                        <div id="barang-container">
                            <hr class="mb-5">
                            <!-- Input Barang Template -->
                            <div class="barang-input-item" data-index="1">
                                <span class="block text-sm font-medium text-gray-900 mb-5">Barang 1</span>
                                <div class="mb-5">
                                    <label for="serial_number_1"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number</label>
                                    <input type="text" id="serial_number_1" name="serial_numbers[]"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="" required />
                                </div>
                                <div class="mb-5">
                                    <label for="status_barang_1"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Barang</label>
                                    <select id="status_barang_1" name="status_barangs[]"
                                        class="select2s bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected>Pilih kondisi barang</option>
                                        @foreach ($status_barang as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label for="kelengkapan_1"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan (Opsional)</label>
                                    <input type="text" id="kelengkapan_1" name="kelengkapans[]"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="" />
                                </div>
                                <button type="button" class="!hidden remove-barang-button text-red-600 hover:text-red-800">Hapus Barang</button>
                            </div>
                        </div>
                    </div>

                    <div class="w-full">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('barang-container');
            const quantityInput = document.getElementById('quantity-input');
            const incrementButton = document.getElementById('increment-button');
            const decrementButton = document.getElementById('decrement-button');
            let currentIndex = 1;
    
            function createBarangInput(index) {
                const newItem = document.createElement('div');
                newItem.classList.add('barang-input-item');
                newItem.setAttribute('data-index', index);
                newItem.innerHTML = `
                <hr class="mb-5">
                    <span class="block text-sm font-medium text-gray-900 mb-5">Barang ${index}</span>
                    <div class="mb-5">
                        <label for="serial_number_${index}"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number</label>
                        <input type="text" id="serial_number_${index}" name="serial_numbers[]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" required />
                    </div>
                    <div class="mb-5">
                        <label for="status_barang_${index}"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Barang</label>
                        <select id="status_barang_${index}" name="status_barangs[]"
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Pilih kondisi barang</option>
                            @foreach ($status_barang as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="kelengkapan_${index}"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan (Opsional)</label>
                        <input type="text" id="kelengkapan_${index}" name="kelengkapans[]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" />
                    </div>
                    <button type="button" class="!hidden remove-barang-button text-red-600 hover:text-red-800">Hapus Barang</button>
                `;
                return newItem;
            }
    
            function updateBarangInputs() {
                const quantity = parseInt(quantityInput.value, 10);
                const items = container.getElementsByClassName('barang-input-item');
                const itemCount = items.length;
    
                // Add new inputs if needed
                if (quantity > itemCount) {
                    for (let i = itemCount + 1; i <= quantity; i++) {
                        container.appendChild(createBarangInput(i));
                    }
                }
    
                // Remove extra inputs if needed
                if (quantity < itemCount) {
                    for (let i = itemCount; i > quantity; i--) {
                        container.removeChild(container.querySelector(`.barang-input-item[data-index="${i}"]`));
                    }
                }
            }
    
            incrementButton.addEventListener('click', function () {
                if (parseInt(quantityInput.value, 10) < parseInt(quantityInput.dataset.inputCounterMax, 10)) {
                    quantityInput.value = parseInt(quantityInput.value, 10) + 1;
                    updateBarangInputs();
                }
            });
    
            decrementButton.addEventListener('click', function () {
                if (parseInt(quantityInput.value, 10) > parseInt(quantityInput.dataset.inputCounterMin, 10)) {
                    quantityInput.value = parseInt(quantityInput.value, 10) - 1;
                    updateBarangInputs();
                }
            });
    
            container.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-barang-button')) {
                    const item = event.target.closest('.barang-input-item');
                    container.removeChild(item);
                    // Update the remaining items' indexes
                    Array.from(container.getElementsByClassName('barang-input-item')).forEach((elem, idx) => {
                        elem.setAttribute('data-index', idx + 1);
                        elem.querySelector('span').textContent = `Barang ${idx + 1}`;
                        elem.querySelector('input').id = `serial_number_${idx + 1}`;
                        elem.querySelector('select').id = `status_barang_${idx + 1}`;
                    });
                    quantityInput.value = container.getElementsByClassName('barang-input-item').length;
                }
            });
    
            // Initialize items based on the default quantity
            updateBarangInputs();
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('.select2').select2();

            const jenisBarangSelect = $('#jenis_barang');
            const barangSelect = $('#barang');

            jenisBarangSelect.on('select2:select', function(e) {
                const jenisBarangId = e.params.data.id;

                fetch(`/barangmasuk/get-by-jenis/${jenisBarangId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data barang:', data); // Debugging line
                        barangSelect.empty(); // Clear current options
                        barangSelect.append('<option selected>Pilih barang</option>');
                        data.forEach(barang => {
                            const option = new Option(barang.nama, barang.id, false, false);
                            barangSelect.append(option);
                        });
                        barangSelect.trigger('change'); // Notify Select2 of the new options
                    })
                    .catch(error => console.error('Error fetching barang:', error));
            });
        });
    </script>
</x-app-layout>
