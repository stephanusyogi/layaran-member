@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAdd" action="{{ route('administrators.create') }}" method="POST" autocomplete="off">
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
                    value="{{ old('customField-1') }}"
                  />
                  @error('customField-1')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="customField-2" class="form-label @if ($errors->has('customField-2')) text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                      text-success @endif">Last Name</label>
                    <input class="form-control  @if ($errors->has('customField-2')) is-invalid text-danger @elseif(old('customField-2') && !$errors->has('customField-2'))
                    is-valid text-success @endif" type="text" name="customField-2" id="customField-2" value="{{ old('customField-2') }}" />
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
                      value="{{ old('customField-3') }}"
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
                        value="{{ old('customField-4') }}"
                      />
                    </div>
                    @error('customField-4')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("form#formAdd").forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    
                    Swal.fire({
                        title: 'Create New Admin?',
                        text: 'Are you sure you want to create new admin?',
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
        });
    </script>
@endpush