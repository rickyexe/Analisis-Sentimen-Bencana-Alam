@extends('layouts.admin')

@section('title', 'User')

@section('css')
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1 class="display-5 ml-4 mt-4">User</h1>
        </div>
        <div class="row">
            <a href="{{url('/register')}}" class="btn btn-primary ml-4 mt-3 mb-3">Tambah User</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="user_table" style="text-align: center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($user as $keys => $value)
                            <tr>
                                <td>{{++$keys}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->email}}</td>
                                <td>
                                    <a href="{{url('user/edit/'.$value->id)}}" class="btn btn-primary">Edit User</a>
                                    <button type="button" delete-id="{{$value->id}}"
                                            style="color: white"
                                            class="btn btn-danger btn-hapus">Hapus User
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('#user_table').DataTable();
        });

        $('.btn-hapus').click(function (e) {

            var r = confirm("Apakah Anda yakin akan menghapus akun ini?");
            var id = $(this).attr('delete-id');

            if(r== true)
            {
                window.location.href = "{{ url('user/delete') }}" + '/' + id;
            } else{

            }
        })




    </script>
@endsection
