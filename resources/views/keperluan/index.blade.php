<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jenis Keperluan') }}
        </h2>

        <div class="flex items-center gap-x-5">
            <a href="{{ route('keperluan.create') }}"
                class="text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-2xl text-sm w-full sm:w-auto py-2 px-3 text-center">Tambah
                Data</a>

            <button id="delete-selected"
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm py-2 px-3 text-center hidden">
                Hapus Terpilih
            </button>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <table id="keperluan-table" class="py-6 px-0 w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Keperluan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Dua Tanggal?
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700"></tbody>
                    {{-- <tbody>
                        @foreach ($data as $d)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="w-4 px-6 py-4">
                                    <input type="checkbox" class="select-item flex justify-center items-center"
                                        value="{{ $d->id }}">
                                </td>
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <div class="ps-3 w-4 font-medium text-gray-900">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-base text-black gap-3 flex items-center">{{ $d->nama }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-base text-black gap-3 flex items-center">
                                        {{ $d->extend ? 'Iya' : 'Tidak' }}</div>
                                </td>
                                <td class="px-6 py-4 flex gap-x-2">
                                    <a href="/keperluan/edit/{{ $d->id }}"
                                        class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                        type="button">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                            stroke="white" stroke-width="2" fill="none" width="18"
                                            height="18">
                                            <g transform='translate(2.000000, 2.000000)'>
                                                <path
                                                    d='M10.0002,0.7501 C3.0632,0.7501 0.7502,3.0631 0.7502,10.0001 C0.7502,16.9371 3.0632,19.2501 10.0002,19.2501 C16.9372,19.2501 19.2502,16.9371 19.2502,10.0001'>
                                                </path>
                                                <path
                                                    d='M17.5285,2.3038 L17.5285,2.3038 C16.5355,1.4248 15.0185,1.5168 14.1395,2.5098 C14.1395,2.5098 9.7705,7.4448 8.2555,9.1578 C6.7385,10.8698 7.8505,13.2348 7.8505,13.2348 C7.8505,13.2348 10.3545,14.0278 11.8485,12.3398 C13.3435,10.6518 17.7345,5.6928 17.7345,5.6928 C18.6135,4.6998 18.5205,3.1828 17.5285,2.3038 Z'>
                                                </path>
                                                <line x1='13.009' y1='3.8008' x2='16.604' y2='6.9838'>
                                                </line>
                                            </g>
                                        </svg>
                                    </a>
                                    <a href="/keperluan/delete/{{ $d->id }}"
                                        class="flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                        type="button">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                            stroke="white" stroke-width="2" fill="none" width="18"
                                            height="18">
                                            <g transform='translate(3.500000, 2.000000)'>
                                                <path
                                                    d='M15.3891429,7.55409524 C15.3891429,15.5731429 16.5434286,19.1979048 8.77961905,19.1979048 C1.01485714,19.1979048 2.19295238,15.5731429 2.19295238,7.55409524'>
                                                </path>
                                                <line x1='16.8651429' y1='4.47980952' x2='0.714666667' y2='4.47980952'>
                                                </line>
                                                <path
                                                    d='M12.2148571,4.47980952 C12.2148571,4.47980952 12.7434286,0.714095238 8.78914286,0.714095238 C4.83580952,0.714095238 5.36438095,4.47980952 5.36438095,4.47980952'>
                                                </path>
                                            </g>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>

                <script>
                    $(document).ready(function() {
                        $('#keperluan-table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: '{{ config('app.api_url') }}/keperluan',
                                data: function(d) {
                                    // d.search = $('input[name=search]').val();
                                },
                                headers: {
                                    'Authorization': 'Bearer ' + '{{ session('token') }}'
                                }
                            },
                            columns: [{
                                    data: 'id',
                                    orderable: false,
                                    render: function(data, type, row) {
                                        return `<input type="checkbox" class="select-item flex justify-center items-center" value="${data}">`;
                                    }
                                },
                                {
                                    data: null,
                                    sortable: false,
                                    render: function(data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                    }
                                },
                                {
                                    data: 'nama'
                                },
                                {
                                    data: 'extend',
                                    render: function(data) {
                                        return data == 1 ? 'Iya' : 'Tidak';
                                    }
                                },
                                {
                                    data: 'id',
                                    orderable: false,
                                    render: function(data, type, row) {
                                        return `
                                                <div class="flex">
                                                    <a href="/keperluan/edit/${data}" class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center mr-2" type="button">
                                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white" stroke-width="2" fill="none" width="18" height="18"><g transform='translate(2.000000, 2.000000)'><path d='M10.0002,0.7501 C3.0632,0.7501 0.7502,3.0631 0.7502,10.0001 C0.7502,16.9371 3.0632,19.2501 10.0002,19.2501 C16.9372,19.2501 19.2502,16.9371 19.2502,10.0001'></path><path d='M17.5285,2.3038 L17.5285,2.3038 C16.5355,1.4248 15.0185,1.5168 14.1395,2.5098 C14.1395,2.5098 9.7705,7.4448 8.2555,9.1578 C6.7385,10.8698 7.8505,13.2348 7.8505,13.2348 C7.8505,13.2348 10.3545,14.0278 11.8485,12.3398 C13.3435,10.6518 17.7345,5.6928 17.7345,5.6928 C18.6135,4.6998 18.5205,3.1828 17.5285,2.3038 Z'></path><line x1='13.009' y1='3.8008' x2='16.604' y2='6.9838'></line></g></svg>
                                                    </a>
                                                    <a href="/keperluan/delete/${data}" class="flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center" type="button">
                                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white" stroke-width="2" fill="none" width="18" height="18"><g transform='translate(3.500000, 2.000000)'><path d='M15.3891429,7.55409524 C15.3891429,15.5731429 16.5434286,19.1979048 8.77961905,19.1979048 C1.01485714,19.1979048 2.19295238,15.5731429 2.19295238,7.55409524'></path><line x1='16.8651429' y1='4.47980952' x2='0.714666667' y2='4.47980952'></line><path d='M12.2148571,4.47980952 C12.2148571,4.47980952 12.7434286,0.714095238 8.78914286,0.714095238 C4.83580952,0.714095238 5.36438095,4.47980952 5.36438095,4.47980952'></path></g></svg>
                                                    </a>
                                                </div>
                                            `;
                                    }
                                }
                            ],
                            order: [
                                [2, 'asc']
                            ]
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
