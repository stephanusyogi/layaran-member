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

    <title>Register - Layaran Livechat</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('templates/assets/img/favicon/favicon.ico') }}" />

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

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
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
              <h4 class="mb-2">Adventure starts here 🚀</h4>
              <p class="mb-4">Make Your Event Unforgettable with Live Chat on the Big Screen!</p>

              <form id="formAuthentication" class="mb-3" action="{{ route('register.action') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="customField-1" class="form-label @if ($errors->has('customField-1')) text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                      text-success @endif">First Name</label>
                    <input type="text" class="form-control @if ($errors->has('customField-1')) is-invalid text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                    is-valid text-success @endif" id="customField-1" name="customField-1" placeholder="Enter your first name" value="{{ old('customField-1') }}"/>
                    @error('customField-1')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="customField-2" class="form-label @if ($errors->has('customField-2')) text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                      text-success @endif">Last Name (Optional)</label>
                    <input type="text" class="form-control @if ($errors->has('customField-2')) is-invalid text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                    is-valid text-success @endif" id="customField-2" name="customField-2" placeholder="Enter your last name" value="{{ old('customField-2') }}"/>
                    @error('customField-2')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="customField-3" class="form-label @if ($errors->has('customField-3')) text-danger @elseif(old('customField-3') && !$errors->has('customField-3'))
                      text-success @endif">Email</label>
                    <input type="text" class="form-control @if ($errors->has('customField-3')) is-invalid text-danger @elseif(old('customField-3') && !$errors->has('customField-3'))
                    is-valid text-success @endif" id="customField-3" name="customField-3" placeholder="Enter your email" value="{{ old('customField-3') }}"/>
                    @error('customField-3')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3 col-md-6 ">
                    <label for="customField-4" class="form-label @if ($errors->has('customField-4')) text-danger @elseif(old('customField-4') && !$errors->has('customField-4'))
                      text-success @endif">Phone Number</label>
                    <div class="input-group input-group-merge">
                      <span class="input-group-text @if ($errors->has('customField-4')) border-danger text-danger @elseif(old('customField-4') && !$errors->has('customField-4'))
                        border-success text-success @endif">+62</span>
                      <input type="text" class="form-control @if ($errors->has('customField-4')) is-invalid text-danger @elseif(old('customField-4') && !$errors->has('customField-4'))
                      is-valid text-success @endif" id="customField-4" name="customField-4" placeholder="Enter your phone number" value="{{ old('customField-4') }}"/>
                    </div>
                    @error('customField-4')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="customField-5" class="form-label @if ($errors->has('customField-5')) text-danger @elseif(old('customField-5') && !$errors->has('customField-5'))
                      text-success @endif">Profession (Optional)</label>
                    <select class="form-select @error('customField-5') is-invalid @enderror" id="customField-5" name="customField-5">
                      <option selected disabled>None</option>
                      <option value="Pelajar/Mahasiswa" {{ old('customField-5') == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                      <option value="Event Organizer" {{ old('customField-5') == 'Event Organizer' ? 'selected' : '' }}>Event Organizer</option>
                      <option value="Wedding Organizer" {{ old('customField-5') == 'Wedding Organizer' ? 'selected' : '' }}>Wedding Organizer</option>
                      <option value="IT Staff" {{ old('customField-5') == 'IT Staff' ? 'selected' : '' }}>IT Staff</option>
                      <option value="Admin" {{ old('customField-5') == 'Admin' ? 'selected' : '' }}>Admin</option>
                      <option value="Lainnya" {{ old('customField-5') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('customField-5')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="customField-6" class="form-label @if ($errors->has('customField-6')) text-danger @elseif(old('customField-6') && !$errors->has('customField-6'))
                      text-success @endif">Gender (Optional)</label>
                    <select class="form-select @error('customField-6') is-invalid @enderror" id="customField-6" name="customField-6">
                      <option selected disabled>None</option>
                      <option value="Laki-Laki" {{ old('customField-6') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                      <option value="Perempuan" {{ old('customField-6') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('customField-6')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="customField-7" class="form-label @if ($errors->has('customField-7')) text-danger @elseif(old('customField-7') && !$errors->has('customField-7'))
                      text-success @endif">Known Us From? (Optional)</label>
                    <select class="form-select  @error('customField-7') is-invalid @enderror" id="customField-7" name="customField-7">
                      <option selected disabled>None</option>
                      <option value="Search Google" {{ old('customField-7') == 'Search Google' ? 'selected' : '' }}>Search Google</option>
                      <option value="Instagram" {{ old('customField-7') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                      <option value="Rekomendasi Teman" {{ old('customField-7') == 'Rekomendasi Teman' ? 'selected' : '' }}>Rekomendasi Teman</option>
                      <option value="Website Layaran" {{ old('customField-7') == 'Website Layaran' ? 'selected' : '' }}>Website Layaran</option>
                    </select>
                    @error('customField-7')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mb-3 form-password-toggle col-md-6">
                    <label class="form-label @error('customField-8') is-invalid @enderror" for="customField-8">Password</label>
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="customField-8"
                        class="form-control @error('customField-8') is-invalid @enderror"
                        name="customField-8"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                      />
                      <span class="input-group-text cursor-pointer @error('customField-8') border-danger text-danger @enderror"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('customField-8')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3 form-password-toggle col-md-6">
                    <label class="form-label @error('customField-9') is-invalid @enderror" for="customField-9">Confirm Password</label>
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="customField-9"
                        class="form-control @error('customField-9') is-invalid @enderror"
                        name="customField-9"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                      />
                      <span class="input-group-text cursor-pointer @error('customField-8') border-danger text-danger @enderror "><i class="bx bx-hide"></i></span>
                    </div>
                    @error('customField-9')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <button class="btn btn-primary d-grid w-100">Sign up</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="javascript:void(0)">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
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
  </body>
</html>
