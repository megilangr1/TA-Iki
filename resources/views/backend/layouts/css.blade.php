<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/toastr/toastr.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/ekko-lightbox/ekko-lightbox.css">

<style>
  .borad {
    border-radius: 0px !important;
  }

  .hr-title {
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid #918383;
  }

  .box-invalid {
    border: 1px solid #dc3545;
    color: #dc3545;
  }

  .input-group:not(.has-validation)>.form-control:not(:last-child) {
    border-top-right-radius: 4px !important;
    border-bottom-right-radius: 4px !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #2a2a2a !important;
    border: 1px solid #aaa !important;
    padding-left: 5px;
    padding-right: 5px;
  }

  .select2-container .select2-selection--single {
    height: 38px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px !important;
  }

  .invalid-border {
    border: 1px solid #dc3545 !important;
    border-radius: 0.3rem !important;
  }

  .nav-tabs {
    border-bottom: 1px solid #4a4a4a75 !important;
  }

  .nav-tabs .nav-link {
    border: 1px solid #0000001f !important;
    border-radius: 0px !important;
    background-color: #fff !important;
  }

  .small-nav-link {
    padding: 6px 10px !important;
    font-size: 15px !important;
  }

  div > nav > ul.pagination {
    margin-bottom: 0px !important;
  }
</style>

<script>
  function isNumberKey(evt)
  {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31  && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
</script>

<script type="text/javascript">
  function formatRupiah(evt){
    var angka = evt.target.value;
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return evt.target.value = rupiah;
  }
</script>

@livewireStyles

@yield('css')
@stack('css')