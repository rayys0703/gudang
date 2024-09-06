<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Barang') }}
        </h2>
        
        <div class="flex items-center gap-x-5">
            <a href="{{ route('statusbarang.create') }}" class="text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-2xl text-sm w-full sm:w-auto py-2 px-3 text-center">Tambah Data</a>

            <button id="delete-selected"
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm py-2 px-3 text-center hidden">
                Hapus Terpilih
            </button>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <table id="statusbarang-table" class="py-6 px-0 w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status Barang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700"></tbody>
                    </table>

                    <script>
                        $(document).ready(function() {
                            $('#statusbarang-table').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: '{{ config('app.api_url') }}/statusbarang',
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
                                        data: 'nama',
                                        render: function(data, type, row) {
                                            return `<div class="flex items-center"><span class="w-4 h-4 rounded-full border inline-block mr-2" style="background-color:${row.warna || '#000000'}"></span>${data}</div>`;
                                        }
                                    },
                                    {
                                        data: 'id',
                                        orderable: false,
                                        render: function(data, type, row) {
                                            return `
                                                        <div class="flex">
                                                            <a href="/statusbarang/edit/${data}" class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center mr-2" type="button">
                                                                <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white" stroke-width="2" fill="none" width="18" height="18"><g transform='translate(2.000000, 2.000000)'><path d='M10.0002,0.7501 C3.0632,0.7501 0.7502,3.0631 0.7502,10.0001 C0.7502,16.9371 3.0632,19.2501 10.0002,19.2501 C16.9372,19.2501 19.2502,16.9371 19.2502,10.0001'></path><path d='M17.5285,2.3038 L17.5285,2.3038 C16.5355,1.4248 15.0185,1.5168 14.1395,2.5098 C14.1395,2.5098 9.7705,7.4448 8.2555,9.1578 C6.7385,10.8698 7.8505,13.2348 7.8505,13.2348 C7.8505,13.2348 10.3545,14.0278 11.8485,12.3398 C13.3435,10.6518 17.7345,5.6928 17.7345,5.6928 C18.6135,4.6998 18.5205,3.1828 17.5285,2.3038 Z'></path><line x1='13.009' y1='3.8008' x2='16.604' y2='6.9838'></line></g></svg>
                                                            </a>
                                                            <a href="/statusbarang/delete/${data}" class="flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center" type="button">
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
    
                    <script>
                        $(document).ready(function() {
                            // Handle select-all checkbox
                            $(document).on('change', '#select-all', function() {
                                const isChecked = $(this).is(':checked');
                                $('.select-item').prop('checked', isChecked);
                                toggleDeleteButton();
                            });
    
                            // Handle individual checkboxes
                            $(document).on('change', '.select-item', function() {
                                toggleDeleteButton();
                            });
    
                            // Function to toggle the delete button based on selection
                            function toggleDeleteButton() {
                                const selected = $('.select-item:checked').length;
                                const deleteButton = $('#delete-selected');
                                if (selected > 0) {
                                    deleteButton.removeClass('hidden');
                                } else {
                                    deleteButton.addClass('hidden');
                                }
                            }
    
                            // Handle delete selected button click
                            $(document).on('click', '#delete-selected', function() {
                                const selected = [];
                                $('.select-item:checked').each(function() {
                                    selected.push($(this).val());
                                });
    
                                if (selected.length > 0) {
                                    if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                                        fetch('/statusbarang/delete-selected', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                ids: selected
                                            })
                                        }).then(response => {
                                            if (response.ok) {
                                                location.reload();
                                            } else {
                                                alert('Gagal menghapus data.');
                                            }
                                        });
                                    }
                                } else {
                                    alert('Tidak ada data yang dipilih.');
                                }
                            });
                        });
                    </script>
            </div>
        </div>
    </div>
</x-app-layout>
