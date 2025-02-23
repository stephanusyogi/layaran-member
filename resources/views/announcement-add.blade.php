@extends('layouts.app')

@push('css')
  <style>
    .ck-editor__main > .ck-content{
      min-height: 300px!important;
    }
  </style>
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAnnouncement" action="{{ route('announcements.create') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                      <label for="customField-1" class="form-label @if ($errors->has('customField-1')) text-danger @elseif(old('customField-1') && !$errors->has('customField-1'))
                        text-success @endif">Title</label>
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
                        <label class="form-label" for="customField-2">Status</label>
                        <input type="hidden" name="customField-2" value="published">
                        <div class="form-check mt-1">
                          <input
                            type="checkbox"
                            class="form-check-input @error('customField-2') is-invalid @enderror"
                            id="customField-2"
                            name="customField-2"
                            value="draft"
                            {{ old('customField-2') == 'draft' ? 'checked' : '' }}
                          >
                          <label class="form-check-label" for="customField-2">Save as Draft</label>
                        </div>
                        @error('customField-2')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="customField-3" class="form-label @if ($errors->has('customField-3')) text-danger @elseif(old('customField-3') && !$errors->has('customField-3')) text-success @endif">
                          Description
                        </label>
                        <textarea
                          class="form-control @if ($errors->has('customField-3')) is-invalid text-danger @elseif(old('customField-3') && !$errors->has('customField-3')) is-valid text-success @endif"
                          id="customField-3"
                          name="customField-3"
                          rows="10"
                        >{{ old('customField-3') }}</textarea>
                        @error('customField-3')
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#customField-3'), {
      removePlugins: [ 'ImageUpload', 'ImageInsert', 'MediaEmbed', 'EasyImage' ],
      toolbar: [
        'heading', '|',
        'bold', 'italic', 'link', '|',
        'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|',
        'undo', 'redo'
      ]
    })
    .catch(error => {
      console.error('CKEditor initialization error:', error);
    });

</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("form#formAnnouncement").forEach(function(form) {
          form.addEventListener("submit", function(event) {
              event.preventDefault();
              
              Swal.fire({
                  title: 'Save Announcement?',
                  text: 'Are you sure you want to save this announcement?',
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