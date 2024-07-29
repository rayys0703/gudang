<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="" method="post" action="{{ route('statusbarang.store') }}" enctype="multipart/form-data">
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
                
                    <div class="flex gap-x-3 mb-5">
                        <div class="w-full">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Status Barang</label>
                            <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Baik" required />
                          </div>
    
                          <div class="w-[15%]">
                            <label for="warna" class="block text-sm font-medium mb-2 opacity-0">Warna</label>
                            <input type="color" id="warna" value="#00FF00" name="warna" class="p-1 h-10 w-full block bg-gray-50 border border-gray-300 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700" title="Pilih warna kondisi barang">
                          </div>
                    </div>

                      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                  
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
