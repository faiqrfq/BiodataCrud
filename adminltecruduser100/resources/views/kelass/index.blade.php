@extends('adminlte::page')

@section('title', 'Daftar Kelas')

@section('content_header')
<div class="container-fluid bg-white shadow-sm py-4 px-4 mb-4 rounded">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-primary font-weight-bold">Daftar Kelas</h1>
        <a href="{{route('kelass.create')}}" class="btn btn-primary px-4 d-flex align-items-center">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Kelas
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="classTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" width="80px">No.</th>
                                <th>Nama Kelas</th>
                                <th class="text-center" width="200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelass as $key => $kelas)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-graduation-cap text-primary mr-2"></i>
                                        <span>{{$kelas->nama}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('kelass.show', $kelas->id) }}" 
                                           class="btn btn-info btn-sm mr-2" 
                                           data-toggle="tooltip" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{route('kelass.edit', $kelas)}}" 
                                           class="btn btn-warning btn-sm mr-2"
                                           data-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm delete-btn"
                                                data-toggle="tooltip" 
                                                title="Hapus"
                                                data-url="{{ route('kelass.destroy', $kelas) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kelas ini?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
@stop

@push('css')
<style>
    .table thead th {
        border-top: none;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    .btn-sm {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075)!important;
    }
</style>
@endpush

@push('js')
<form action="" id="delete-form" method="post" style="display:none;">
    @method('delete')
    @csrf
</form>

<script>

$(document).ready(function() {
    // Listener untuk tombol hapus
    $('.delete-btn').on('click', function() {
        let deleteUrl = $(this).data('url');  // Ambil URL dari tombol hapus
        $('#deleteModal').modal('show');  // Tampilkan modal konfirmasi

        // Set URL pada form delete dan submit ketika tombol konfirmasi diklik
        $('#confirmDelete').off('click').on('click', function() {
            $('#delete-form').attr('action', deleteUrl);  // Set URL ke form
            $('#delete-form').submit();  // Submit form
        });
    });
});

$(document).ready(function() {
    // Inisialisasi DataTable dengan konfigurasi yang lebih modern
    $('#classTable').DataTable({
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    // Inisialisasi tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Handle konfirmasi delete dengan modal
    let deleteUrl = '';
    
    $('.delete-btn').on('click', function() {
        deleteUrl = $(this).data('url');  // Ambil URL dari tombol hapus
        $('#deleteModal').modal('show');  // Tampilkan modal konfirmasi
    });

    $('#confirmDelete').on('click', function() {
        $("#delete-form").attr('action', deleteUrl);  // Set URL ke form
        $("#delete-form").submit();  // Submit form
    });

    // Animasi hover pada baris tabel
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('bg-light transition-all duration-300');
        },
        function() {
            $(this).removeClass('bg-light');
        }
    );
});
</script>
@endpush
