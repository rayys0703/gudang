<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barang Masuk') }}
        </h2>

        <div class="flex items-center gap-x-5">
            <a href="{{ route('barangmasuk.create') }}"
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
                <table id="barang-table" class="py-6 px-0 w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Barang</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Keterangan</th>
                            <th scope="col" class="px-6 py-3">Tanggal Masuk</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#barang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ config('app.api_url') }}/barangmasuk',
                    data: function(d) {
                        // d.search = $('input[name=search]').val();
                    },
                    headers: {
                        'Authorization': 'Bearer ' + '{{ session('token') }}'
                    },
                    error: function(xhr, error, thrown) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memuat data. Menampilkan data default.');
                        return {
                            data: [{
                                barang_masuk_id: 1,
                                nama_barang: 'Data Default',
                                jumlah: 0,
                                keterangan_barang: 'Data tidak tersedia',
                                tanggal: '-'
                            }]
                        };
                    }
                },
                columns: [{
                        data: 'barang_masuk_id',
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
                        data: 'nama_barang',
                        defaultContent: 'Data tidak tersedia'
                    },
                    {
                        data: 'jumlah',
                        defaultContent: '0'
                    },
                    {
                        data: 'keterangan_barang',
                    },
                    {
                        data: 'tanggal_barang',
                        defaultContent: '-'
                    },
                    {
                        data: 'barang_masuk_id',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="flex gap-x-2">
                                    <button type="button"
                                        class="flex text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                        onclick="showDetailModal(${data})">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                            stroke="white" stroke-width="2" fill="none" width="18"
                                            height="18">
                                            <g transform='translate(3.649800, 2.749900)'>
                                                <line x1='10.6555' y1='12.6999' x2='5.2555' y2='12.6999'>
                                                </line>
                                                <line x1='8.6106' y1='8.6886' x2='5.2546' y2='8.6886'>
                                                </line>
                                                <path
                                                    d='M16.51,5.55 L10.84,0.15 C10.11,0.05 9.29,0 8.39,0 C2.1,0 -1.95399252e-14,2.32 -1.95399252e-14,9.25 C-1.95399252e-14,16.19 2.1,18.5 8.39,18.5 C14.69,18.5 16.79,16.19 16.79,9.25 C16.79,7.83 16.7,6.6 16.51,5.55 Z'>
                                                </path>
                                                <path
                                                    d='M10.2844,0.0827 L10.2844,2.7437 C10.2844,4.6017 11.7904,6.1067 13.6484,6.1067 L16.5994,6.1067'>
                                                </path>
                                            </g>
                                        </svg>
                                    </button>
                                    <a href="/barangmasuk/create/${data}"
                                        class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                        type="button">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                            stroke="white" stroke-width="2" fill="none" width="18"
                                            height="18">
                                            <g transform='translate(2.300000, 2.300000)'>
                                                <line x1='9.73684179' y1='6.162632' x2='9.73684179' y2='13.3110531'>
                                                </line>
                                                <line x1='13.3146315' y1='9.73684179' x2='6.158842' y2='9.73684179'>
                                                </line>
                                                <path
                                                    d='M-3.55271368e-14,9.73684211 C-3.55271368e-14,2.43473684 2.43473684,2.13162821e-14 9.73684211,2.13162821e-14 C17.0389474,2.13162821e-14 19.4736842,2.43473684 19.4736842,9.73684211 C19.4736842,17.0389474 17.0389474,19.4736842 9.73684211,19.4736842 C2.43473684,19.4736842 -3.55271368e-14,17.0389474 -3.55271368e-14,9.73684211 Z'>
                                                </path>
                                            </g>
                                        </svg>
                                    </a>
                                    <a href="/barangmasuk/delete/${data}"
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
                                </div>
                            `;
                        }
                    }
                ],
                order: [
                    [5, 'desc']
                ]
            });

            function showDetailModal(id) {
                var table = $('#barang-table').DataTable();
                var data = table.row(function(idx, data, node) {
                    return data.barang_masuk_id === id;
                }).data();

                if (data) {
                    var modalContent = `
                        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">
                                            Detail Barang Masuk
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="grid grid-cols-10 gap-2">
                                            <div class="font-bold col-span-3">Nama Barang:</div>
                                            <div class="col-span-7">${data.nama_barang}</div>
                                            <div class="font-bold col-span-3">Jenis Barang:</div>
                                            <div class="col-span-7">${data.nama_jenis_barang}</div>
                                            <div class="font-bold col-span-3">Supplier:</div>
                                            <div class="col-span-7">${data.nama_supplier}</div>
                                            <div class="font-bold col-span-3">Tanggal Masuk:</div>
                                            <div class="col-span-7">${data.tanggal_barang}</div>
                                            <div class="font-bold col-span-3">Keterangan:</div>
                                            <div class="col-span-7">${data.keterangan_barang || '-'}</div>
                                            <div class="font-bold col-span-3">Jumlah:</div>
                                            <div class="col-span-7">${data.jumlah || 0}</div>

                                            ${Array.isArray(JSON.parse(data.detail)) && JSON.parse(data.detail).length > 0 ? 
                                                JSON.parse(data.detail).map((detail, index) => `
                                                        <hr class="col-span-10 my-2">
                                                        <div class="font-bold col-span-3">Barang ${index + 1}</div>
                                                        <div class="col-span-7">${detail.serial_number} — <span style="color:${detail.warna_status_barang}">${detail.status_barang}</span></div>
                                                        <div class="col-span-3">Kelengkapan</div>
                                                        <div class="col-span-7">${detail.kelengkapan_barang || '—'}</div>
                                                    `).join('') : 
                                                ''
                                            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Remove existing modal if any
                    $('#detailModal').remove();

                    // Append new modal to body
                    $('body').append(modalContent);

                    // Show the modal
                    $('#detailModal').modal('show');
                }
            }

            // Expose the function to the global scope
            window.showDetailModal = showDetailModal;
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
                        fetch('/barangmasuk/delete-selected', {
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
