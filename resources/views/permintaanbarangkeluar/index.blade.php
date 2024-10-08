<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permintaan Barang Keluar') }}
        </h2>

        <div class="flex items-center gap-x-5">
            <form action="{{ route('permintaanbarangkeluar.index') }}" method="GET"
                class="flex items-center max-w-sm mx-auto">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" id="simple-search" name="search" value="{{ request('search') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Cari..." required />
                </div>
                <button type="submit"
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-800 rounded-2xl border border-gray-700 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>

            <a href="{{ route('permintaanbarangkeluar.create') }}"
                class="text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-2xl text-sm w-full sm:w-auto py-2 px-3 text-center">Buat
                Permintaan</a>

            <button id="delete-selected"
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm py-2 px-3 text-center hidden">
                Hapus Terpilih
            </button>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (!$data->isEmpty())
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-white">
                            <tr>
                                {{-- <th scope="col" class="px-6 py-3">
                                    <input type="checkbox" id="select-all">
                                </th> --}}
                                <th scope="col" class="px-6 py-3 flex justify-center items-center">No</th>
                                <th scope="col" class="px-6 py-3">Penerima</th>
                                <th scope="col" class="px-6 py-3">Keperluan</th>
                                {{-- <th scope="col" class="px-6 py-3">Keterangan</th> --}}
                                <th scope="col" class="px-6 py-3">Jumlah</th>
                                <th scope="col" class="px-6 py-3">Tanggal Permintaan</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr class="bg-white border-b hover:bg-gray-50 text-base text-black">
                                    {{-- <td class="w-4 px-6 py-4">
                                        <input type="checkbox" class="select-item flex justify-center items-center" value="{{ $d->id }}">
                                    </td> --}}
                                    <td class="px-6 py-4 flex justify-center items-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $d->nama_customer }}</td>
                                    <td class="px-6 py-4">{{ $d->nama_keperluan }}</td>
                                    <td class="px-6 py-4">{{ $d->jumlah }}</td>
                                    <td class="px-6 py-4">{{ $d->tanggal_awal }}</td>
                                    <td class="px-6 py-4">
                                        @if ($d->status == 'Ditolak')
                                            <span class="text-red-600">{{ $d->status }}</span>
                                        @elseif ($d->status == 'Belum Disetujui')
                                            <span class="text-yellow-600">{{ $d->status }}</span>
                                        @elseif ($d->status == 'Disetujui')
                                            <span class="text-green-600">{{ $d->status }}</span>
                                        @else
                                            {{ $d->status }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex gap-x-2">
                                        <button type="button"
                                            class="flex text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $d->id }}">
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

                                        {{-- @if ($d->status == 'Belum Disetujui')
                                            <button onclick="showStatusChangeAlert({{ $d->id }})"
                                                class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                                type="button">
                                                <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke="white"
                                                    stroke-width="2" fill="none" width="18" height="18">
                                                    <g transform='translate(2.000000, 2.000000)'>
                                                        <path d='M10.0002,0.7501 C3.0632,0.7501 0.7502,3.0631 0.7502,10.0001 C0.7502,16.9371 3.0632,19.2501 10.0002,19.2501 C16.9372,19.2501 19.2502,16.9371 19.2502,10.0001'></path>
                                                        <path d='M17.5285,2.3038 L17.5285,2.3038 C16.5355,1.4248 15.0185,1.5168 14.1395,2.5098 C14.1395,2.5098 9.7705,7.4448 8.2555,9.1578 C6.7385,10.8698 7.8505,13.2348 7.8505,13.2348 C7.8505,13.2348 10.3545,14.0278 11.8485,12.3398 C13.3435,10.6518 17.7345,5.6928 17.7345,5.6928 C18.6135,4.6998 18.5205,3.1828 17.5285,2.3038 Z'></path>
                                                        <line x1='13.009' y1='3.8008' x2='16.604' y2='6.9838'></line>
                                                    </g>
                                                </svg>
                                            </button>
                                        @endif --}}

                                        <a href="/permintaanbarangkeluar/delete/{{ $d->id }}"
                                            class="!hidden text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm px-3 py-1.5 text-center"
                                            type="button">
                                            <svg class='line' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                                stroke="white" stroke-width="2" fill="none" width="18"
                                                height="18">
                                                <g transform='translate(3.500000, 2.000000)'>
                                                    <path
                                                        d='M15.3891429,7.55409524 C15.3891429,15.5731429 16.5434286,19.1979048 8.77961905,19.1979048 C1.01485714,19.1979048 2.19295238,15.5731429 2.19295238,7.55409524'>
                                                    </path>
                                                    <line x1='16.8651429' y1='4.47980952' x2='0.714666667'
                                                        y2='4.47980952'></line>
                                                    <path
                                                        d='M12.2148571,4.47980952 C12.2148571,4.47980952 12.7434286,0.714095238 8.78914286,0.714095238 C4.83580952,0.714095238 5.36438095,4.47980952 5.36438095,4.47980952'>
                                                    </path>
                                                </g>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="detailModal{{ $d->id }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $d->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $d->id }}">
                                                    Detail Permintaan Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="grid grid-cols-10 gap-2">
                                                    <div class="font-bold col-span-3">Penerima:</div>
                                                    <div class="col-span-7">{{ $d->nama_customer }}</div>
                                                    <div class="font-bold col-span-3">Keperluan:</div>
                                                    <div class="col-span-7">{{ $d->nama_keperluan }}</div>
                                                    <hr class="col-span-10 my-2">
                                                    <div class="font-bold col-span-10">Tanggal</div>
                                                    <div class="font-bold col-span-3 ms-3">{{ $d->nama_tanggal_awal }}:</div>
                                                    <div class="col-span-7">{{ $d->tanggal_awal }}</div>
                                                    @if ($d->extend)
                                                        <div class="font-bold col-span-3 ms-3">{{ $d->nama_tanggal_akhir }}:</div>
                                                        <div class="col-span-7">{{ $d->tanggal_akhir }}</div>
                                                    @endif
                                                    <hr class="col-span-10 my-2">
                                                    <div class="font-bold col-span-3">Keterangan:</div>
                                                    <div class="col-span-7">{{ $d->keterangan }}</div>
                                                    <div class="font-bold col-span-3">Jumlah:</div>
                                                    <div class="col-span-7">{{ $d->jumlah }}</div>
                                                    <div class="font-bold col-span-3">Status:</div>
                                                    <div class="col-span-7">
                                                        @if ($d->status == 'Ditolak')
                                                            <span class="text-red-600">{{ $d->status }}</span>
                                                        @elseif ($d->status == 'Belum Disetujui')
                                                            <span class="text-yellow-600">{{ $d->status }}</span>
                                                        @elseif ($d->status == 'Disetujui')
                                                            <span class="text-green-600">{{ $d->status }}</span>
                                                        @else
                                                            {{ $d->status }}
                                                        @endif
                                                    </div>

                                                    <!-- Detail permintaan -->
                                                    @foreach ($d->detail as $index => $detail)
                                                        <hr class="col-span-10 my-2">
                                                        <div class="col-span-1 flex items-center justify-center">
                                                            <div class="font-bold">{{ $index + 1 }}</div>
                                                        </div>
                                                        <div class="col-span-9 grid grid-cols-10">
                                                            <div class="font-bold col-span-3">Barang / SN</div>
                                                            <div class="col-span-7">{{ $detail->nama_barang }} —
                                                                {{ $detail->serial_number }}</div>
                                                            <div class="font-bold col-span-3">Jenis Barang</div>
                                                            <div class="col-span-7">{{ $detail->nama_jenis_barang }}
                                                            </div>
                                                            <div class="font-bold col-span-3">Supplier</div>
                                                            <div class="col-span-7">{{ $detail->nama_supplier }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer gap-x-3">
                                                @if ($d->status == 'Belum Disetujui')
                                                    <button type="button" class="btn btn-success"
                                                        onclick="updateStatus({{ $d->id }}, 'Disetujui')"
                                                        data-bs-dismiss="modal">Setujui</button>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="updateStatus({{ $d->id }}, 'Ditolak')"
                                                        data-bs-dismiss="modal">Tolak</button>
                                                @endif
                                                <button type="button" class="!hidden btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                        <script>
                            /*function showStatusChangeAlert(id) {
                                                                                                                                Swal.fire({
                                                                                                                                    title: 'Ubah Status',
                                                                                                                                    text: "Pilih status untuk permintaan barang ini:",
                                                                                                                                    icon: 'warning',
                                                                                                                                    showCancelButton: true,
                                                                                                                                    showDenyButton: true,
                                                                                                                                    confirmButtonColor: '#3085d6',
                                                                                                                                    cancelButtonColor: '#808080',
                                                                                                                                    denyButtonColor: '#d33',
                                                                                                                                    confirmButtonText: 'Setujui',
                                                                                                                                    denyButtonText: 'Tolak',
                                                                                                                                    cancelButtonText: 'Batal'
                                                                                                                                }).then((result) => {
                                                                                                                                    if (result.isConfirmed) {
                                                                                                                                        updateStatus(id, 'Disetujui');
                                                                                                                                    } else if (result.isDenied) {
                                                                                                                                        updateStatus(id, 'Ditolak');
                                                                                                                                    }
                                                                                                                                });
                                                                                                                            }*/

                            function updateStatus(id, status) {
                                fetch('/permintaanbarangkeluar/update-status', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            id: id,
                                            status: status
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Gagal!', data.message, 'error');
                                        }
                                    });
                            }
                        </script>
                    </table>

                    {{-- <script>
                        document.getElementById('select-all').addEventListener('change', function(e) {
                            const checkboxes = document.querySelectorAll('.select-item');
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = e.target.checked;
                            });
                            toggleDeleteButton();
                        });

                        document.querySelectorAll('.select-item').forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                toggleDeleteButton();
                            });
                        });

                        function toggleDeleteButton() {
                            const selected = document.querySelectorAll('.select-item:checked').length;
                            const deleteButton = document.getElementById('delete-selected');
                            if (selected > 0) {
                                deleteButton.classList.remove('hidden');
                            } else {
                                deleteButton.classList.add('hidden');
                            }
                        }

                        document.getElementById('delete-selected').addEventListener('click', function() {
                            const selected = [];
                            document.querySelectorAll('.select-item:checked').forEach(checkbox => {
                                selected.push(checkbox.value);
                            });

                            if (selected.length > 0) {
                                if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                                    fetch('/permintaanbarangkeluar/delete-selected', {
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
                    </script> --}}

                    <div class="py-3 px-5">
                        {{ $data->links() }}
                    </div>
                @else
                    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                        <div class="mx-auto max-w-screen-sm text-center">
                            <h1
                                class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-primary-600 dark:text-primary-500">
                                404</h1>
                            <p
                                class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">
                                Data tidak ditemukan.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
