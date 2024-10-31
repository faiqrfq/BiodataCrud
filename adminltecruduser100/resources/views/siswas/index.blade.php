@extends('adminlte::page')

@section('title', 'Daftar Siswa')

@section('content_header')
<div class="container-fluid bg-gradient-primary shadow py-4 px-4 mb-4 rounded">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-white font-weight-bold">Daftar Siswa</h1>
        <a href="{{ route('siswas.create') }}" class="btn btn-light px-4 font-weight-bold">
            <i class="fas fa-user-plus mr-2"></i> Tambah Siswa
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover" id="siswaTable">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th width="70">No</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Tanggal Lahir</th>
                                <th>Kelas</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($siswas as $key => $siswa)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-2">
                                            <span class="initials">{{ substr($siswa->nama, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <span class="d-block font-weight-bold">{{ $siswa->nama }}</span>
                                            <small class="text-muted">Siswa Aktif</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-primary">{{ $siswa->nis }}</span></td>
                                <td><i class="far fa-calendar-alt text-info mr-1"></i> {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-graduation-cap text-success mr-2"></i>
                                        {{ $siswa->kelas->nama ?? 'Belum ada kelas' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('siswas.show', $siswa->id) }}" class="btn btn-outline-info btn-sm mr-1" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('siswas.edit', $siswa) }}" class="btn btn-outline-warning btn-sm mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn" data-url="{{ route('siswas.destroy', $siswa) }}" title="Hapus">
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
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data siswa ini?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Form delete -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@stop

@push('css')
<style>
    .card {
        border-radius: 0.75rem;
    }

    .table thead th {
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.1em;
    }

    .table tbody tr:hover {
        background-color: #f1f5f9;
        transition: 0.2s;
    }

    .btn-outline-info, .btn-outline-warning, .btn-outline-danger {
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover {
        color: white;
        background-color: #17a2b8;
    }

    .btn-outline-warning:hover {
        color: white;
        background-color: #ffc107;
    }

    .btn-outline-danger:hover {
        color: white;
        background-color: #dc3545;
    }

    .avatar-circle {
        width: 45px;
        height: 45px;
        background: linear-gradient(45deg, #4299e1, #48bb78);
        border-radius: 50%;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-primary {
        background-color: #6c757d;
        color: #fff;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    $('.delete-btn').on('click', function() {
        let deleteUrl = $(this).data('url');
        $('#deleteModal').modal('show');
        $('#confirmDelete').off('click').on('click', function() {
            $('#delete-form').attr('action', deleteUrl);
            $('#delete-form').submit();
        });
    });

    $('#siswaTable').DataTable({
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
        }
    });
});
</script>
@endpush
