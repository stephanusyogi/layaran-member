@extends('layouts.app')

@push('css')
  <style>
   .announcement-table-container {
        max-height: 25rem;
        overflow-y: auto;
    }

    .announcement-table thead {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1000;
    }
 
  </style>  
@endpush

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Welcome {{ auth()->user()->first_name }}! 🎉</h5>
                <p class="mb-4">
                  Bring your event to life! Let your audience send messages, shoutouts, and requests that appear instantly on the big screen.
                </p>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="{{ asset('templates/assets/img/illustrations/man-with-laptop-light.png') }}"
                  height="140"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 mb-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <div class="rounded p-2 border text-black d-flex align-items-center justify-content-center">
                      <i class="bx bx-chat text-success"></i>
                    </div>
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Messages</span>
                <h3 class="card-title mb-2">20.000</h3>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <div class="rounded p-2 border text-black d-flex align-items-center justify-content-center">
                      <i class="bx bx-calendar text-info"></i>
                    </div>
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Events</span>
                <h3 class="card-title text-nowrap mb-1">4</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Announcement -->
      <div class="col-12 col-lg-8 order-3 order-md-3 order-lg-2 mb-4">
        <div class="card">
          <div class="row row-bordered g-0">
            <div class="col-md-12">
              <div class="px-2">
                <div class="announcement-table-container text-nowrap">
                  <table class="table announcement-table">
                    <thead>
                      <tr>
                        <th><h5 class="m-0">Announcement</h5></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($announcements as $item)
                        <tr>
                          <td>
                            <strong>{{ $item->isNew ? '🔥NEW🔥' : '' }}  {{ strtoupper(Str::limit($item->title, 30, '...')) }}</strong>
                            <br>
                            <small>{{ \Carbon\Carbon::parse($item->published_at)->format('l, F d Y') }}</small>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu m-0">
                                <a class="dropdown-item btn-detail" data-id="{{ $item->id }}" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> See Details</a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              {{-- Modal Detail Announcement --}}
              <div class="modal fade" id="detailAnnounceModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <div>
                        <h5 class="modal-title" id="modalCenterAnnouncement"></h5>
                        <small><strong>Published:</strong> <span id="announcementDate"></span></small>
                      </div>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <p id="announcementDescription"></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Announcement -->
      <div class="col-12 col-md-8 col-lg-4 order-2 order-md-2">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <div class="text-center">
                <button
                  class="btn btn-sm btn-outline-primary"
                  type="button">
                  Clear Storage
                </button>
              </div>
            </div>
            <div id="growthChart"></div>
            <div class="text-center fw-semibold pt-3 mb-2">Max Current Storage: 300 MB</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script src="{{ asset('templates/assets/js/dashboards-analytics.js') }}"></script>

  <script>
    $('.btn-detail').on('click', function() {
        let id = $(this).attr('data-id');
        $.ajax({
            url: "{{ route('announcements.details', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                let title = (data.isNew ? "🔥NEW🔥 " : "") + data.title; 

                $("#modalCenterAnnouncement").text(title);
                $("#announcementDescription").text(data.description);
                $("#announcementDate").text(data.published_at);

                $("#detailAnnounceModal").modal("show");
            },

        });
    });

  </script>
@endpush