@extends('layouts.admin')
@section('header')
@stop
@section('content')
<link rel="stylesheet" href="{{asset('')}}/asset/dist/css/nested.css">
<style>
    .dd-handle {
        display: flex;
    }
    .dd-actions {
        float: right;
        display: flex;
        justify-content: end;
        width: 100%;
    }
    .dd-actions button{
        border: none;
        background: none;
    }
    button[data-action="collapse"] {
        color: #000;
    }
</style>

@if(Session::has('sukses'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fa fa-check"></i> Sukses !</h5>
    {{Session::get('sukses')}}
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Kategori </h3>
                <div class="float-right">
                    <button class="btn btn-success btn-md" id="btn-create"><i class="fa fa-plus"></i>
                        Tambah Kategori </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="table-kategori" class="table table-bordered nowrap table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Kategori </th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- Modal -->

<div class="modal fade" id="modal-kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="saveForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama" id="nama" value=""
                            placeholder="Masukkan nama">

                        <small class="help-block text-danger nama"></small>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="save" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>



@stop
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js" integrity="sha512-a3kqAaSAbp2ymx5/Kt3+GL+lnJ8lFrh2ax/norvlahyx59Ru/1dOwN1s9pbWEz1fRHbOd/gba80hkXxKPNe6fg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('')}}/js/nestedde.js"></script>
<script type="text/javascript">
    function refreshTable() {
        $('#table-kategori').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            ajax: "{{url('table')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                
                {
                    data: 'action',
                    name: 'action'
                },

            ]
        });
    }
 
    $(document).ready(function () {
        refreshTable();

        $("#btn-create").click(function () {
            $("#id").val("");
            $("#nama").val("");
            $("#save").text("Simpan")
            $(".modal-title").text("Tambah Kategori");
            $("#modal-kategori").modal("show");
        })  

        $("#saveForm").submit(function(e){
            e.preventDefault();
            let form=$(this)[0];
            let formData=new FormData(form);
            $.ajax({
                url : "{{url('create')}}",
                method:'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data :formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType:'JSON',
                beforeSend: function () {
                    loading();
                },
                success:function(data) {
                    matikanLoading();
                    if ($.isEmptyObject(data.errors)) {
                        $.each(data.success,function(key){
                            hapusvalidasi(key);
                        });
                            swal({
                                title: "Pesan!",
                                text: "Anda Telah Berhasil Menambahkan Kategori  !",
                                icon: "success",
                            });
                            form.reset();
                            $("#modal-kategori").modal('hide');
                            $('#table-kategori').DataTable().ajax.reload();
                    }
                    else{
                        $.each(data.errors, function (key, value) {
                            hapusvalidasi(key);
                            addValidasi(key,value);
                        });
                        swal({
                                title: "Pesan!",
                                text: "Mohon Isi Form Dengan Benar",
                                icon: "error",
                        });
                    }
                }
            });
        })

        $('body').on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            swal({
                    title: "Yakin?",
                    text: "Anda Yakin Ingin Ubah Data??",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willEdit) => {
                    if (willEdit) {
                        $("#id").val(id);
                        $("#nama").val($(this).data('nama'));
                        $("#save").text("Simpan")
                        $(".modal-title").text("Ubah Kategori ");
                        $("#modal-kategori").modal("show");
                    } else {
                        swal("Anda Membatalkan Ubah Data");
                    }
                });
        });

        $('body').on('click', '.btn-delete', function () {
            let hapus = $(this).data('id');
            swal({
                    title: "Yakin?",
                    text: "Anda Yakin Ingin Hapus Data??",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        let url = `{{url('delete')}}/` + hapus;
                        fetch(url).then(res => res.json()).then(_ => {
                            swal({
                                title: "Pesan!",
                                text: "Anda Telah Berhasil Hapus Data !",
                                icon: "success",
                            });
                            $("#table-kategori").DataTable().ajax.reload();
                        })
                    } else {
                        swal("Anda Membatalkan Hapus Data");
                    }
                });
        });
    });

</script>

@endsection
