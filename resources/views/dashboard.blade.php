<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 gap-y-3 flex flex-col">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-lg">
                    Halo, <b>{{ session('user')['name'] }}</b>!     
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-lg">
                    Data Supplier: {{ $total_supplier }}    
                </div>
                <div class="p-6 text-gray-900 text-lg">
                    Data Customer: {{ $total_customer }}    
                </div>
                <div class="p-6 text-gray-900 text-lg">
                    Data Barang: {{ $total_barang }}    
                </div>
                <div class="p-6 text-gray-900 text-lg">
                    Data Barang Masuk: {{ $total_barang_masuk }}    
                </div>
                <div class="p-6 text-gray-900 text-lg">
                    Data Barang Keluar: {{ $total_barang_keluar }}    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
