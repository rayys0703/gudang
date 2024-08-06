<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="" method="post" action="/barang/update/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
                        <strong class="font-bold">Ups!</strong> Terjadi kesalahan:
                        <ul class="mt-3 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                
                      <div class="mb-5">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                        <input type="text" id="nama" name="nama" value="{{ $data->nama }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Abdul Dudul" required />
                      </div>
                      <div class="mb-5">
                        <label for="jenis_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Barang</label>
                        <select id="jenis_barang" name="jenis_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                          <option selected>Pilih jenis barang</option>
                          @foreach($jenis_barang as $d)
                            <option @if ($data->jenis_barang_id == $d->id) selected @endif value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="mb-5">
                        <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900">Supplier</label>
                        <select id="supplier" name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                          <option selected>Pilih supplier</option>
                          @foreach($supplier as $d)
                            <option @if ($data->supplier_id == $d->id) selected @endif value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      {{-- <div class="mb-5">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                          <option selected>Pilih kondisi barang</option>
                          <option @if ($data->status == "Baik") selected @endif value="Baik">Baik</option>
                          <option @if ($data->status == "Rusak") selected @endif value="Rusak">Rusak</option>
                        </select>
                      </div> --}}
                      <div class="mb-5">
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" value="{{ $data->keterangan }}" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      </div>

                      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                  
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
