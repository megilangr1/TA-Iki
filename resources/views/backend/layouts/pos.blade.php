<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ env('APP_NAME') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
  
  @livewireStyles

  @yield('css')
  @stack('css')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
      <a href="{{ route("backend.main") }}" class="navbar-brand">
        <img src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link">Sistem Informasi - Point of Sales</a>
          </li>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        {{ $slot ?? '' }}
      </div>
    </div>
  </div>
  
  <aside class="control-sidebar control-sidebar-dark">
    <div class="row pt-4 px-4">
      <div class="col-12 text-center">
        <h5 class="text-light">Hi, {{ auth()->user()->name }}</h5>
      </div>
      <div class="col-12 pt-3">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" alt="User profile picture">
        </div>
      </div>
      <div class="col-12 text-center pt-3">
        <h6 class="text-light">
          <span id="clock"></span>
        </h6>
      </div>
      <div class="col-12 pt-3">
        <a class="btn btn-block btn-outline-secondary btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <span class="fa fa-sign-out-alt"></span> &ensp; 
          Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>

      </div>
    </div>
  </aside>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>

@livewireScripts
<script>
  Livewire.on('success', data => {
    toastr.success(data, "Berhasil");
  });

  Livewire.on('info', data => {
    toastr.info(data, "Pemberitahuan");
  });

  Livewire.on('warning', data => {
    toastr.warning(data, "Peringatan !");
  });

  Livewire.on('error', data => {
    toastr.error(data, "Kesalahan !!");
  });
</script>



@yield('script')
@stack('script')
</body>
</html>
