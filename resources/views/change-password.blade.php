@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Change My Password</h4>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formPassword" action="{{ route('account_details.change-password-action', auth()->user()->user_id) }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="customField-1" class="form-label @if ($errors->has('customField-1')) text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                                    text-success @endif">Current Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                        class="form-control @if ($errors->has('customField-1')) is-invalid text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                                        is-valid text-success @endif"
                                        type="password"
                                        id="customField-1"
                                        name="customField-1"
                                        aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer @error('customField-1') border-danger text-danger @enderror"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('customField-1')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="customField-2" class="form-label @if ($errors->has('customField-2')) text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                                    text-success @endif">Create Your New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                        class="form-control @if ($errors->has('customField-2')) is-invalid text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                                        is-valid text-success @endif"
                                        type="password"
                                        id="customField-2"
                                        name="customField-2"
                                        aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer @error('customField-2') border-danger text-danger @enderror"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('customField-2')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="customField-3" class="form-label @if ($errors->has('customField-3')) text-danger @elseif(old('customField-3') && !$errors->has('customField-3'))
                                    text-success @endif">Confirm Your New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                        class="form-control @if ($errors->has('customField-3')) is-invalid text-danger @elseif(old('customField-3') && !$errors->has('customField-3'))
                                        is-valid text-success @endif"
                                        type="text"
                                        id="customField-3"
                                        name="customField-3"
                                        aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer @error('customField-3') border-danger text-danger @enderror"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('customField-3')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                              <button type="submit" class="btn btn-primary me-2">Change Account Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function initPasswordToggle() {
            const togglers = document.querySelectorAll('#formPassword .input-group-text i');

            if (togglers.length > 0) {
                togglers.forEach(icon => {
                    icon.addEventListener('click', e => {
                        e.preventDefault();
                        
                        const formPasswordToggleInput = icon.closest('.input-group').querySelector('input');
                        const formPasswordToggleIcon = icon;

                        if (formPasswordToggleInput.getAttribute('type') === 'password') {
                            formPasswordToggleInput.setAttribute('type', 'text');
                            formPasswordToggleIcon.classList.replace('bx-hide', 'bx-show');
                        } else {
                            formPasswordToggleInput.setAttribute('type', 'password');
                            formPasswordToggleIcon.classList.replace('bx-show', 'bx-hide');
                        }
                    });
                });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            initPasswordToggle();
            
            document.querySelectorAll("form#formPassword").forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    
                    Swal.fire({
                        title: 'Change Account Password?',
                        text: 'Are you sure you want to change your account password?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, change my password',
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
