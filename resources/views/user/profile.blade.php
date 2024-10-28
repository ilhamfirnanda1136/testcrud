@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ubah Profile</h3>
                </div>
                <form role="form" action="{{url('profile')}}" method="post" enctype="multipart/form-data"> 
                    <div class="card-body">
                        <div class="form-group">
                            @csrf
                            <label for="email">Email address</label>
                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" id="email" placeholder="Masukkan Email" value="{{Auth::user()->email}}">
                            @if($errors->has('email'))
                            <span class="help-block">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif "
                                name="name" id="name" value="{{Auth::user()->name}}" placeholder="Masukkan Nama Lengkap">
                            @if($errors->has('name'))
                            <small class="help-block text-danger">{{$errors->first('name')}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" name="username" value="{{Auth::user()->username}}" id="username" placeholder="Masukkan Username">
                            @if($errors->has('username'))
                            <span class="help-block">{{$errors->first('username')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control @if($errors->has('alamat')) is-invalid @endif" placeholder="Masukkan alamat">{{Auth::user()->alamat}}</textarea>
                            @if($errors->has('alamat'))
                            <small class="help-block text-danger">{{$errors->first('alamat')}}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="no_telp">Nomor Telepon</label>
                            <input type="number" class="form-control @if($errors->has('no_telp')) is-invalid @endif"
                                id="no_telp" name="no_telp" value="{{Auth::user()->no_telp}}"
                                placeholder="Masukkan Nomor Telepon">
                            @if($errors->has('no_telp'))
                            <small class="help-block text-danger">{{$errors->first('no_telp')}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="fotos">Foto</label>
                            <input type="file" class="form-control @if($errors->has('fotos')) is-invalid @endif" id="fotos" name="fotos" >
                            @if($errors->has('fotos'))
                            <span class="help-block">{{$errors->first('fotos')}}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <img src="{{isset($id) ? Auth::user()->getFoto() : asset('img/guest.png')}}" width="100" src="70" id="image">
                        </div>
                        <div class="form-group">
                            <label for="level">Pilih Level</label>
                            <select name="level" class="form-control" disabled>
                                <option value="1" {{Auth::user()->level == 1 ? 'selected' : ''}}>Admin</option>
                                <option value="2" {{Auth::user()->level == 2 ? 'selected' : ''}}>Kasir</option>
                                <option value="3" {{Auth::user()->level == 3 ? 'selected' : ''}}>Pramuniaga</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-12">
                            <button style="width: 100%" type="submit" class="btn btn-danger"><i class="fa fa-save"></i>
                                {{!isset($id) ? 'Simpan' : 'Update'}}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer')
<script>
$(document).ready(function(){
	$('#fotos').change(function(){
        bacaLink(this,$('#image'));
	});
});
</script>
@endsection
