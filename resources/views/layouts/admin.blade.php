<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Administrasi Baznaz</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"> 
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="{{asset('')}}/lte/fontawesome2.min.css">
  <link rel="stylesheet" href="{{asset('')}}/asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="{{asset('')}}/asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
  <link rel="stylesheet" href="{{asset('')}}/asset/dist/css/adminlte.min.css">
  <link rel="shortcut icon" href="{{asset('')}}/lte/logo_baznas_mobile.png" type="image/x-icon">

  <link rel="stylesheet" href="{{asset('')}}/asset/dist/css/preloader.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .select2-container {
      width: 100% !important;
      max-width: 100%;
    }

   .select2-container .select2-selection__rendered {
      line-height: 34px; /* Same as the form-control height */
    }

    .select2-container .select2-selection__arrow {
      height: 34px; /* Same as the form-control height */
    }

    .select2-container .select2-selection--single {
      height: 36px; /* Adjust the height as needed */
    }
    [class*=sidebar-dark-] {
        background-color: #135C29 !important;
    }
    [class*=sidebar-dark-] .sidebar a {
        color: #fff;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini ">
<!-- Site wrapper -->
<div class="wrapper ">

    @include('layouts.include.header')
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      @include('layouts.include.sidebar')
    <!-- Brand Logo -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header"></section>
    <section class="content">
        @yield('content')
    </section>
  </div>
  <!-- /.content-wrapper -->

  
   <!--Loading Bar-->
   <div class="div-loading">
    <div id="loader" style="display: none;"></div>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('')}}/asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('')}}/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('')}}/asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('')}}asset/dist/js/demo.js"></script>
<script src="{{asset('')}}js/autoNumeric.js"></script>

<script src="{{asset('asset/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('js/helper.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('footer')
</body>
</html>
