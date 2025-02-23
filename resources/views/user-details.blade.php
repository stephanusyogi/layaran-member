@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <!-- Account -->
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAccountSettings" action="{{ route('account_details.update', $user->user_id) }}" method="POST" autocomplete="off">
              @csrf
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="customField-1" class="form-label @if ($errors->has('customField-1')) text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                    text-success @endif">First Name</label>
                  <input
                    class="form-control @if ($errors->has('customField-1')) is-invalid text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                    is-valid text-success @endif"
                    type="text"
                    id="customField-1"
                    name="customField-1"
                    value="{{ old('customField-1', $user->first_name) }}"
                  />
                  @error('customField-1')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label for="customField-2" class="form-label @if ($errors->has('customField-2')) text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                    text-success @endif">Last Name</label>
                  <input class="form-control  @if ($errors->has('customField-2')) is-invalid text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                  is-valid text-success @endif" type="text" name="customField-2" id="customField-2" value="{{ old('customField-2', $user->last_name) }}" />
                  @error('customField-2')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label for="customField-3" class="form-label @if ($errors->has('customField-3')) text-danger @elseif(old('customField-3') && !$errors->has('customField-3'))
                    text-success @endif">E-mail</label>
                  <input    
                    class="form-control @if ($errors->has('customField-3')) is-invalid text-danger @elseif(old('customField-3') && !$errors->has('customField-3'))
                    is-valid text-success @endif"
                    type="text"
                    id="customField-3"
                    name="customField-3"
                    value="{{ old('customField-3', $user->email_address) }}"
                  />
                  @error('customField-3')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="customField-4 @if ($errors->has('customField-4')) text-danger @elseif(old('customField-4') && !$errors->has('customField-4'))
                    text-success @endif">Phone Number</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text  @if ($errors->has('customField-4')) border-danger text-danger @elseif(old('customField-4') && !$errors->has('customField-4'))
                      border-success text-success @endif">+ 62</span>
                    <input
                      type="text"
                      id="customField-4"
                      name="customField-4"
                      class="form-control @if ($errors->has('customField-4')) is-invalid text-danger @elseif(old('customField-4') && !$errors->has('customField-4'))
                      is-valid text-success @endif"
                      value="{{ old('customField-4',$user->phone_number) }}"
                    />
                  </div>
                  @error('customField-4')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label @if ($errors->has('customField-5')) text-danger @elseif(old('customField-5') && !$errors->has('customField-5'))
                      text-success @endif" for="customField-5">Profession (Optional)</label>
                    <select id="customField-5" name="customField-5" class="select2 form-select  @error('customField-5') is-invalid @enderror">
                      <option disabled>None</option>
                      <option value="Pelajar/Mahasiswa" {{ old('customField-5', $user->profession) == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                      <option value="Event Organizer" {{ old('customField-5', $user->profession) == 'Event Organizer' ? 'selected' : '' }}>Event Organizer</option>
                      <option value="Wedding Organizer" {{ old('customField-5', $user->profession) == 'Wedding Organizer' ? 'selected' : '' }}>Wedding Organizer</option>
                      <option value="IT Staff" {{ old('customField-5', $user->profession) == 'IT Staff' ? 'selected' : '' }}>IT Staff</option>
                      <option value="Admin" {{ old('customField-5', $user->profession) == 'Admin' ? 'selected' : '' }}>Admin</option>
                      <option value="Lainnya" {{ old('customField-5', $user->profession) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('customField-5')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label @if ($errors->has('customField-6')) text-danger @elseif(old('customField-6') && !$errors->has('customField-6'))
                    text-success @endif" for="customField-6">Gender</label>
                  <select id="customField-6" name="customField-6" class="select2 form-select @error('customField-6') is-invalid @enderror">
                    <option disabled>None</option>
                    <option value="Laki-Laki" {{ old('customField-6', $user->gender) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ old('customField-6', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                  @error('customField-6')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label @if ($errors->has('customField-7')) text-danger @elseif(old('customField-7') && !$errors->has('customField-7'))
                    text-success @endif" for="customField-7">Known Us From?</label>
                  <select id="customField-7" name="customField-7" class="select2 form-select @error('customField-7') is-invalid @enderror">
                    <option disabled>None</option>
                    <option value="Search Google" {{ old('customField-7', $user->knowing_from) == 'Search Google' ? 'selected' : '' }}>Search Google</option>
                    <option value="Instagram" {{ old('customField-7', $user->knowing_from) == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="Rekomendasi Teman" {{ old('customField-7', $user->knowing_from) == 'Rekomendasi Teman' ? 'selected' : '' }}>Rekomendasi Teman</option>
                    <option value="Website Layaran" {{ old('customField-7', $user->knowing_from) == 'Website Layaran' ? 'selected' : '' }}>Website Layaran</option>
                  </select>
                  @error('customField-7')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label @if ($errors->has('customField-8')) text-danger @elseif(old('customField-8') && !$errors->has('customField-8'))
                    text-success @endif" for="customField-8">Role</label>
                  <select id="customField-8" name="customField-8" class="select2 form-select @error('customField-8') is-invalid @enderror">
                    <option disabled>None</option>
                    <option value="admin" {{ old('customField-8', $user->role) == 'admin' ? 'selected' : '' }}>Is Administrator</option>
                    <option value="member" {{ old('customField-8', $user->role) == 'member' ? 'selected' : '' }}>Is Member</option>
                  </select>
                  @error('customField-8')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
        <div class="card">
          <h5 class="card-header">Delete Account</h5>
          <div class="card-body">
            <div class="mb-3 col-12 mb-0">
              <div class="alert alert-warning">
                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete this account?</h6>
                <p class="mb-0">Once you delete this account, there is no going back. Please be certain.</p>
              </div>
            </div>
            <form id="formAccountDeactivation" method="POST" action="{{ route('account_details.deactivate', $user->user_id) }}">
              @csrf
              <div class="mb-3">
                <div class="form-check">
                  <input
                    class="form-check-input @error('accountDeactivation') is-invalid @enderror"
                    type="checkbox"
                    name="accountDeactivation"
                    id="accountDeactivation"
                  />
                  <label class="form-check-label @if ($errors->has('accountDeactivation')) text-danger @elseif(old('accountDeactivation') && !$errors->has('accountDeactivation'))
                    text-success @endif" for="accountDeactivation"
                    >I confirm this account deactivation</label
                  >
                </div>
                @error('accountDeactivation')
                      <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("form#formAccountSettings").forEach(function(form) {
          form.addEventListener("submit", function(event) {
              event.preventDefault();
              
              Swal.fire({
                  title: 'Save Changes?',
                  text: 'Are you sure you want to update this account details?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, save changes',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
              }).then((result) => {
                  if (result.isConfirmed) {
                      form.submit();
                  }
              });
          });
      });

      document.querySelectorAll("form#formAccountDeactivation").forEach(function(form) {
          form.addEventListener("submit", function(event) {
              event.preventDefault();
              
              Swal.fire({
                  title: 'Deactivate Account?',
                  text: 'Once you deactivate this account, you will not be able to restore it. Are you sure you want to proceed?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, deactivate',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
              }).then((result) => {
                  if (result.isConfirmed) {
                      form.submit();
                  }
              });
          });
      });
  });
</script>
@endpush