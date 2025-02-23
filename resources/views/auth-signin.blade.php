<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('templates/assets') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login - Layaran Livechat</title>

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

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('templates/assets/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('templates/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('templates/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner" style="max-width: 500px">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-0">
                <a href="javascript:void(0)" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img style="width: 90px" src="{{ asset('assets/images/logo-1.png') }}" alt="logo-layaran">
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Welcome to Layaran! 👋</h4>
              <p class="mb-4">Please sign-in to your account and start the adventure</p>

              <form class="mb-3" action="{{ route('login.action') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                  <label for="customField-1" class="form-label  @if ($errors->has('customField-1')) text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                    text-success @endif">Email</label>
                  <input
                    type="text"
                    class="form-control @if ($errors->has('customField-1')) is-invalid text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                    is-valid text-success @endif"
                    id="customField-1"
                    name="customField-1"
                    value="{{ old('customField-1') }}"
                    placeholder="Enter your registered email"
                    autofocus
                  />
                  @error('customField-1')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label @error('customField-2') is-invalid @enderror" for="customField-2">Password</label>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalForgotPassword">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="customField-2"
                      class="form-control @error('customField-2') is-invalid @enderror"
                      name="customField-2"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer @error('customField-2') border-danger text-danger @enderror"><i class="bx bx-hide"></i></span>
                  </div>
                  @error('customField-2')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>

              <p class="text-center">
                <span>New on our platform?</span>
                <a href="{{ route('register') }}">
                  <span>Create an account</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>
    
    {{-- Modal --}}
    <div class="modal fade" id="modalForgotPassword" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Forgot Your Password ?</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-center">
            <p class="mb-3">
              If you've forgotten your password, please contact our support team for assistance. 
              Click the link below to reach us via WhatsApp.
            </p>
            <a href="#" class="btn btn-primary">
              Contact Support
            </a>
          </div>                    
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('templates/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('templates/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('templates/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('templates/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('templates/assets/js/main.js') }}"></script>

    <!-- Page JS -->

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
                  title: "{!! session('success') !!}",
                  showConfirmButton: false,
                  timer: 5000
              });
          @endif
          @if(session('error'))
              Swal.fire({
                  toast: true,
                  position: 'top-end',
                  icon: 'error',
                  title: "{!! session('error') !!}",
                  showConfirmButton: false,
                  timer: 5000
              });
          @endif
      });
      </script>
  </body>
</html>
