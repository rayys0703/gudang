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
        document.addEventListener('DOMContentLoaded', function() {
            window.showDetailModal = function(id, namaBarang, namaJenisBarang, namaSupplier, tanggalBarang,
                keteranganBarang, jumlah) {
                // Check if modal already exists
                const existingModal = document.getElementById('detailModal');
                if (existingModal) {
                    existingModal.remove();
                }

                fetch(`{{ config('app.api_url') }}/barangmasuk/${id}`, {
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + '{{ session('token') }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Periksa apakah data adalah array
                        if (!Array.isArray(data)) {
                            console.error('Data yang diterima tidak sesuai dengan format yang diharapkan:',
                                data);
                            alert('Terjadi kesalahan saat memuat detail barang.');
                            return;
                        }

                        const detailData = data; // Data yang diterima sudah dalam format array
                        const detailContent = detailData.map((detail, index) => `
                        <hr class="col-span-10 my-2">
                        <div class="font-bold col-span-3">Barang ${index + 1}</div>
                        <div class="col-span-7">${detail.serial_number} — <span style="color:${detail.warna_status_barang}">${detail.status_barang}</span></div>
                        <div class="font-bold col-span-3">Kelengkapan</div>
                        <div class="col-span-7">${detail.kelengkapan_barang || '—'}</div>
                    `).join('');

                        const modalContent = `
                        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Barang Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="grid grid-cols-10 gap-2">
                                            <div class="font-bold col-span-3">Nama Barang:</div>
                                            <div class="col-span-7">${namaBarang || '—'}</div>
                                            <div class="font-bold col-span-3">Jenis Barang:</div>
                                            <div class="col-span-7">${namaJenisBarang || '—'}</div>
                                            <div class="font-bold col-span-3">Supplier:</div>
                                            <div class="col-span-7">${namaSupplier || '—'}</div>
                                            <div class="font-bold col-span-3">Tanggal Masuk:</div>
                                            <div class="col-span-7">${tanggalBarang || '—'}</div>
                                            <div class="font-bold col-span-3">Keterangan:</div>
                                            <div class="col-span-7">${keteranganBarang || '-'}</div>
                                            <div class="font-bold col-span-3">Jumlah:</div>
                                            <div class="col-span-7">${jumlah || 0}</div>
                                            ${detailContent}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                        // Append new modal to body
                        document.body.insertAdjacentHTML('beforeend', modalContent);

                        // Show the modal
                        new bootstrap.Modal(document.getElementById('detailModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching detail data:', error);
                        alert('Terjadi kesalahan saat memuat detail barang.');
                    });
            }

            const table = new DataTable('#barang-table', {
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ config('app.api_url') }}/barangmasuk',
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
                        data: 'nama_barang',
                        name: 'barang.nama',
                        defaultContent: 'Data tidak tersedia'
                    },
                    {
                        data: 'jumlah',
                        name: 'barang_masuk.jumlah',
                        searchable: false,
                        defaultContent: '0'
                    },
                    {
                        data: 'keterangan_barang',
                        name: 'barang.keterangan',
                        defaultContent: '-'
                    },
                    {
                        data: 'tanggal_barang',
                        searchable: false,
                        defaultContent: '-'
                    },
                    {
                        data: 'id',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="flex gap-x-2">
                                    <button type="button" class="flex text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center" onclick="showDetailModal(${data || ''}, '${row.nama_barang || ''}', '${row.nama_jenis_barang || ''}', '${row.nama_supplier || ''}', '${row.tanggal_barang || ''}', '${row.keterangan_barang || ''}', ${row.jumlah || ''})">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white" stroke-width="2" fill="none" width="18" height="18">
                                            <g transform='translate(3.649800, 2.749900)'>
                                                <line x1='10.6555' y1='12.6999' x2='5.2555' y2='12.6999'></line>
                                                <line x1='8.6106' y1='8.6886' x2='5.2546' y2='8.6886'></line>
                                                <path d='M16.51,5.55 L10.84,0.15 C10.11,0.05 9.29,0 8.39,0 C2.1,0 -1.95399252e-14,2.32 -1.95399252e-14,9.25 C-1.95399252e-14,16.19 2.1,18.5 8.39,18.5 C14.69,18.5 16.79,16.19 16.79,9.25 C16.79,7.83 16.7,6.6 16.51,5.55 Z'></path>
                                                <path d='M10.2844,0.0827 L10.2844,2.7437 C10.2844,4.6017 11.7904,6.1067 13.6484,6.1067 L16.5994,6.1067'></path>
                                            </g>
                                        </svg>
                                    </button>
                                    <a href="/barangmasuk/create/${data}" class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center" type="button">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white" stroke-width="2" fill="none" width="18" height="18">
                                            <g transform='translate(2.300000, 2.300000)'>
                                                <line x1='9.73684179' y1='6.162632' x2='9.73684179' y2='13.3110531'></line>
                                                <line x1='13.3146315' y1='9.73684179' x2='6.158842' y2='9.73684179'></line>
                                                <path d='M-3.55271368e-14,9.73684211 C-3.55271368e-14,2.43473684 2.43473684,2.13162821e-14 9.73684211,2.13162821e-14 C17.0389474,2.13162821e-14 19.4736842,2.43473684 19.4736842,9.73684211 C19.4736842,17.0389474 17.0389474,19.4736842 9.73684211,19.4736842 C2.43473684,19.4736842 -3.55271368e-14,17.0389474 -3.55271368e-14,9.73684211 Z'></path>
                                            </g>
                                        </svg>
                                    </a>
                                    <a href="/barangmasuk/delete/${data}" class="flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center">
                                        <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white" stroke-width="2" fill="none" width="18" height="18">
                                            <path d='M2.5,6 L21.5,6 M2.5,6 L4,20 C4,21.1045695 4.8954305,22 6,22 L18,22 C19.1045695,22 20,21.1045695 20,20 L21.5,6 M5,6 L5.5,4.5 C5.5,3.67157288 6.17157288,3 7,3 L17,3 C17.8284271,3 18.5,3.67157288 18.5,4.5 L19,6'></path>
                                        </svg>
                                    </a>
                                </div>
                            `;
                        }
                    }
                ],
            });
        });
    </script>


    </div>
    </div>
    </div>
</x-app-layout>
