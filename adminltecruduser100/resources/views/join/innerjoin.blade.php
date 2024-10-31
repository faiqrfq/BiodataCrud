
@extends('adminlte::page')

@section('title', 'Data Siswa dan Kelas')

@section('content_header')
    <h1 class="m-0 text-dark font-weight-bold">Data Siswa & Kelas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded" style="background-color: #ffffff;">
                <div class="card-body p-4">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead class="bg-gradient" style="background: linear-gradient(90deg, #007bff, #6f42c1); color: white;">
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Nama Kelas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($siswas as $key => $siswa)
                            <tr>
                                <td class="align-middle">{{$key+1}}</td>
                                <td class="align-middle">{{$siswa->nama}}</td>
                                <td class="align-middle">{{$siswa->nama_kelas}}</td>
                            </tr>
                        @endforeach
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
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    </script>
@endpush