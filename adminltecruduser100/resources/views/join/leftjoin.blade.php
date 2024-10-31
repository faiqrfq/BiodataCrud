@extends('adminlte::page')

@section('title', 'Data Kelas')

@section('content_header')
    <h1 class="m-0 text-dark font-weight-bold">Data Kelas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded" style="background-color: #ffffff;">
                <div class="card-body p-4">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead class="bg-gradient" style="background: linear-gradient(90deg, #007bff, #6f42c1); color: white;">
                            <tr>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th>ID Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Nama Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($kelass->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada kelas yang ditemukan</td>
                            </tr>
                        @else
                            @foreach($kelass as $key => $kelas)
                                <tr>
                                    <td class="align-middle text-center">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $kelas->id }}</td>
                                    <td class="align-middle font-weight-bold">{{ $kelas->nama_kelas }}</td>
                                    <td class="align-middle">{{ $kelas->nama_siswa ?? 'Belum ada siswa' }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <form action="" id="delete-form" method="post" style="display:none;">
        @method('delete')
        @csrf
    </form>
    <script>
        $('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data?')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    </script>
@endpush