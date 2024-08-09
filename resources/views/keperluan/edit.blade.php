<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jenis Keperluan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="" method="post" action="/keperluan/update/{{ $data->id }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

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

                    <div class="mb-5">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            Keperluan</label>
                        <input type="text" id="nama" name="nama" value="{{ $data->nama }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Baik" required />
                    </div>

                    <div class="flex items-center mb-5">
                        <input id="extend" type="checkbox" name="extend" value="{{ $data->extend }}" @if ($data->extend == 1) checked @endif class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="extend" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Terapkan dua tanggal</label>
                    </div>
                    <script>
                        function lakukan() {
                            var checkbox = document.getElementById('extend');
                            var tanggalInputs = document.getElementById('tanggalInputs');
                            var namaTanggalAwal = document.getElementById('nama_tanggal_awal');
                            var namaTanggalAkhir = document.getElementById('nama_tanggal_akhir');

                            checkbox.value = checkbox.checked ? '1' : '0';
                            tanggalInputs.style.display = checkbox.checked ? 'block' : 'none';
                            namaTanggalAwal.required = checkbox.checked;
                            namaTanggalAkhir.required = checkbox.checked;
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            var extendCheckbox = document.getElementById('extend');
                            if (extendCheckbox) {
                                extendCheckbox.addEventListener('change', lakukan);
                                lakukan();
                            }
                        });               
                    </script>
                    
                    <div id="tanggalInputs" style="display: none;">

                        <div class="grid md:grid-cols-3 md:gap-3">
                            <div class="relative z-0 w-full mb-5 group md:col-span-2">
                                <label for="nama_tanggal_awal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Tanggal Awal</label>
                                <input type="text" id="nama_tanggal_awal" name="nama_tanggal_awal" value="{{ $data->nama_tanggal_awal }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tanggal Permintaan" />
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="tanggal_awal" class="block opacity-0 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Awal</label>
                                <input type="date" id="tanggal_awal"
                                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    value="{{ date('Y-m-d') }}" disabled />
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3 md:gap-3">
                            <div class="relative z-0 w-full mb-5 group md:col-span-2">
                                <label for="nama_tanggal_akhir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Tanggal Akhir</label>
                                <input type="text" id="nama_tanggal_akhir" name="nama_tanggal_akhir" value="{{ $data->nama_tanggal_akhir }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tanggal Pengembalian" />
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="tanggal_awal" class="block opacity-0 mb-2 text-sm font-medium text-gray-900">Tanggal Permintaan</label>
                                <input type="date" id="tanggal_awal"
                                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    value="{{ date('Y-m-d', strtotime('+7 days')) }}" disabled />
                            </div>
                        </div>

                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
