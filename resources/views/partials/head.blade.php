
<meta charset="utf-8" />
<meta
  name="viewport"
  content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
/>

<title>Member Area - Layaran Livechat</title>

<meta name="description" content="" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo-1.png') }}" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('templates/assets/vendor/fonts/boxicons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('templates/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('templates/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('templates/assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ asset('templates/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

{{-- Datatables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<style>
  div.dt-container select.dt-input{
    margin-right: 5px;
  }
  div.dt-container .dt-paging .dt-paging-button:hover{
    border: 1px solid #696cff!important;
    background: #696cff!important;
    color: #fff!important;
  }
  div.dt-container .dt-paging .dt-paging-button.current:hover{
    color: #fff!important;
  }
  .datatable-style thead th {
      text-align: center !important;
  }
  td.dt-type-numeric{
    text-align: left!important;
  }
  body.swal2-toast-shown .swal2-container{
    width: 500px!important;
  }
</style>

<!-- Page CSS -->
@stack('css')

<!-- Helpers -->
<script src="{{ asset('templates/assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('templates/assets/js/config.js') }}"></script>