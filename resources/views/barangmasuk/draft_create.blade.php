<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="" method="post" action="{{ route('barangmasuk.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3"
                            role="alert">
                            <strong class="font-bold">Ups!</strong> Terjadi kesalahan:
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- <div class="mb-5">
                      <label for="bm_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Barang Masuk</label>
                      <input type="text" id="bm_kode" name="bm_kode" value="{{ $bm_kode_value }}" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" readonly />
                  </div> -->
                    <div class="mb-5">
                        <label for="jenis_barang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Barang</label>
                        <select id="jenis_barang" name="jenis_barang_id"
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Pilih jenis barang</option>
                            @foreach ($jenis_barang as $d)
                                <option value="{{ $d->id }}" {{ $d->id == $jenis_barang_id ? 'selected' : '' }}>
                                    {{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="barang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barang</label>
                        <select id="barang" name="barang_id"
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Pilih barang</option>
                            @if (isset($barangMasuk))
                                @foreach ($barangbyjenis as $d)
                                    <option value="{{ $d->id }}"
                                        {{ $d->id == $barangMasuk->barang_id ? 'selected' : '' }}>{{ $d->nama }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    {{-- <div class="mb-5">
                        <label for="supplier"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier</label>
                        <select id="supplier" name="supplier_id"
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Pilih supplier</option>
                            @foreach ($supplier as $d)
                                @if (isset($barangMasuk))
                                    <option value="{{ $d->id }}"
                                        {{ $d->id == $barangMasuk->supplier_id ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @else
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div> --}}
                    <!-- <div class="mb-5">
                      <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                      <input type="number" id="jumlah" name="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                  </div> -->
                    {{-- <div class="mb-5">
                        <label for="status_barang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Barang</label>
                        <select id="status_barang" name="status_barang_id"
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Pilih kondisi barang</option>
                            @foreach ($status_barang as $d)
                                @if (isset($barangMasuk))
                                    <option value="{{ $d->id }}"
                                        {{ $d->id == $barangMasuk->status_barang_id ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @else
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="serial_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number</label>
                        <input type="text" id="serial_number" name="serial_number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" required />
                    </div> --}}
                    <div class="mb-5">
                        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
                        <label for="quantity-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Barang:</label>
                        <div class="relative flex items-center max-w-[8rem]">
                            <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                </svg>
                            </button>
                            <input type="text" id="quantity-input" data-input-counter data-input-counter-min="1" data-input-counter-max="50" aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" value="1" required />
                            <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                </svg>
                            </button>
                        </div>
                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Input jumlah minimal 1 maksimal 50.</p>
                    </div>
                    <div class="mb-5">
                        <label for="keterangan"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan"
                            class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="tanggal"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Masuk</label>
                        <input type="date" id="tanggal" name="tanggal"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required />
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                </form>
            </div>
        </div>
    </div>
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
