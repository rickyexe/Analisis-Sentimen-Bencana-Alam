@extends('layouts.admin')

@section('title','Edit User')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1 class="display-5 ml-4 mt-4">Edit User</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="{{url('user/update/'.$user->id)}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4" style="margin-left: 35%">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





@endsection

@section('script')

    <script type="text/javascript">


        $(document).ready(function () {

            $('.btn-reset').click(function (e) {

                var r = confirm("Apakah anda yakin ingin reset password akun ini?");
                var id = $(this).attr('reset-id');

                if(r== true)
                {
                    window.location.href = "{{ url('manajemenpengguna/resetpassword') }}" + '/' + id;
                } else{

                }
            })

        })


    </script>




@endsection
