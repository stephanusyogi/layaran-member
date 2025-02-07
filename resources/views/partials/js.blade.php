<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('templates/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('templates/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('templates/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('templates/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('templates/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('templates/assets/js/main.js') }}"></script>

{{-- Datatables --}}
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

<!-- Page JS -->
@stack('script')

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      @if(session('success'))
          Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: "{{ session('success') }}",
              showConfirmButton: false,
              timer: 5000
          });
      @endif
      @if(session('error'))
          Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: "{{ session('error') }}",
              showConfirmButton: false,
              timer: 5000
          });
      @endif
  });
</script>
