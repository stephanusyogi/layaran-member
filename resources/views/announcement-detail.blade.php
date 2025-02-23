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
          <!-- Account -->
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAnnouncement" action="{{ route('announcements.update', $announcement->id) }}" method="POST" autocomplete="off">
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
                    value="{{ old('customField-1', $announcement->title) }}"
                  />
                  @error('customField-1')
                    <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label for="customField-2" class="form-label @if ($errors->has('customField-2')) text-danger @elseif(old('customField-2') && !$errors->has('customField-2')) text-success @endif">Status</label>
                  <select id="customField-2" name="customField-2" class="select2 form-select @error('customField-2') is-invalid @enderror">
                    <option disabled selected>Select status</option>
                    <option value="draft" {{ old('customField-2', $announcement->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('customField-2', $announcement->status) == 'published' ? 'selected' : '' }}>Published</option>
                  </select>
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
                  >{{ old('customField-3', $announcement->description) }}</textarea>
                  @error('customField-3')
                    <div class="form-text text-danger">{{ $message }}</div>
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
          <h5 class="card-header">Delete Announcement</h5>
          <div class="card-body">
            <div class="mb-3 col-12 mb-0">
              <div class="alert alert-warning">
                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete this announcement?</h6>
                <p class="mb-0">Once you delete this announcement, there is no going back. Please be certain.</p>
              </div>
            </div>
            <form id="formDeleteAnnouncement" method="POST" action="{{ route('announcements.delete', $announcement->id) }}">
              @csrf
              <div class="mb-3">
                <div class="form-check">
                  <input
                    class="form-check-input @error('announcementDelete') is-invalid @enderror"
                    type="checkbox"
                    name="announcementDelete"
                    id="announcementDelete"
                  />
                  <label class="form-check-label @if ($errors->has('announcementDelete')) text-danger @elseif(old('announcementDelete') && !$errors->has('announcementDelete'))
                    text-success @endif" for="announcementDelete"
                    >I confirm this action</label
                  >
                </div>
                @error('announcementDelete')
                      <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-danger deactivate-account">Delete</button>
            </form>
          </div>
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
                  title: 'Save Changes?',
                  text: 'Are you sure you want to update this announcement details?',
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
      document.querySelectorAll("form#formDeleteAnnouncement").forEach(function(form) {
          form.addEventListener("submit", function(event) {
              event.preventDefault();
              
              Swal.fire({
                  title: 'Delete Announcements?',
                  text: 'Once you delete, you will not be able to restore it. Are you sure you want to proceed?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, delete it',
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