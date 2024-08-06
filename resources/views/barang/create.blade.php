<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="" method="post" action="{{ route('barang.store') }}" enctype="multipart/form-data">
                    @csrf
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
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang</label>
                        <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Botol Plastik" required />
                      </div>
                      <div class="mb-5">
                        <label for="jenis_barang" class="block mb-2 text-sm font-medium text-gray-900">Jenis Barang</label>
                        <select id="jenis_barang" name="jenis_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                          <option selected>Pilih jenis barang</option>
                          @foreach($jenis_barang as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="mb-5">
                        <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900">Supplier</label>
                        <select id="supplier" name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                          <option selected>Pilih supplier</option>
                          @foreach($supplier as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      {{-- <div class="mb-5">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                          <option selected>Pilih kondisi barang</option>
                          <option value="Baik">Baik</option>
                          <option value="Rusak">Rusak</option>
                        </select>
                      </div> --}}
                      <div class="mb-5">
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500">
                      </div>

                      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                  
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
