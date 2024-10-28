<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistem Informasi Sewa Lapangan</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{asset('')}}/asset/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('')}}/asset/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="{{asset('')}}lte/preloader.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('assetlanding')}}/css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="#page-top">
                <img src="{{asset('img/dortmund-logo.png')}}" alt="" width="80px">
                Sport Kahuripan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{url('home')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('home')}}">Lapangan</a></li>
                    @if(Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{url('member')}}">Member</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('pembayaran')}}">Pembayaran</a></li>
                    <li class="nav-item"><a class="nav-link akun-klik" href="#!">Akun</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->

    <!-- Content section 1-->
    @yield('content')
    <!-- Footer-->
    <footer class="py-5 bg-black">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <div class="div-loading">
        <div id="loader" style="display: none;"></div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{asset('assetlanding')}}/js/scripts.js"></script>
    <!-- jQuery -->
    <script src="{{asset('')}}/asset/plugins/jquery/jquery.min.js"></script>
    <script src="{{asset('js/helper.js')}}"></script>
    <script src="{{asset('asset/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script type="text/javascript">
        function logout(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        }

    </script>
    @if(Auth::check())
    <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-modal="true"
        role="dialog" style="display: none; padding-left: 0px;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilModalLabel">Profil Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        fdprocessedid="qgvg16"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4 my-5">
                                @php
                                $url = asset('img/profile/'.Auth::user()->foto_profile);
                                if(!Auth::user()->foto_profile) {
                                $url = asset('img/guest.png');
                                }
                                @endphp
                                <img src="{{$url}}" alt="Foto Profil" class="img-fluid ">
                            </div>
                            <div class="col-8">
                                <h5 class="mb-3">{{Auth::user()->name}}</h5>
                                <p>{{Auth::user()->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan'}}</p>
                                <p>{{Auth::user()->email}}</p>
                                <p>{{Auth::user()->no_handphone}}</p>
                                <p>{{Auth::user()->alamat}}</p>
                                <a href="#" onclick="logout(event)" class="btn btn-danger">Logout</a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal"
                                    class="btn btn-inti">Edit Profil</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel"
        aria-hidden="true">
        <div class="modal-dialog edit modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('update.profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="">
                    <div class="modal-body">
                        <div class="row justify-content-center align-items-center">
                            <div class="mb-3">
                                <img src="{{$url}}" alt="Foto Profil" style="width:100px" class="img-fluid ">
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control"
                                        id="exampleInputPassword1" value="{{Auth::user()->name}}">
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="1" {{Auth::user()->jenis_kelamin == 1 ? 'selected' : ''}}>
                                            Laki-laki</option>
                                        <option value="0" {{Auth::user()->jenis_kelamin == 0 ? 'selected' : ''}}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">No Telp</label>
                                    <input type="number" name="no_handphone" class="form-control" id="exampleInputPassword1"
                                        value="{{Auth::user()->no_handphone}}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">alamat</label>
                                <input type="text" name="alamat" class="form-control" id="exampleInputPassword1"
                                    value="{{Auth::user()->alamat}}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Foto : </label>
                                <input type="file" name="foto_profile" class="form-control" id="exampleInputPassword1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-inti" name="simpan" id="simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    <script>
        $(document).ready(function () {
            $(".btn-close").click(function () {
                $("#profilModal").modal("hide")
            })
            $(".akun-klik").click(function () {
                $("#profilModal").modal("show")
            })
        })
    </script>
    @yield('footer')
</body>
</html>
