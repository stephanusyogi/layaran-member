@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold py-3 my-0"><span class="text-muted fw-light">Data Announcements /</span> All</h4>
            <a href="{{ route('announcements.add') }}" class="btn btn-primary"><i class="tf-icons bx bx-plus"></i> Create New</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="table_announcements" class="table datatable-style">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Published At</th>
                                        <th>Published / Draft</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#table_announcements').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 20, 25, -1],
                [10, 20, 25, "50"]
            ],
            ajax: {
                url: "{{ route('announcements') }}",
                type: "get",
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    'orderable': false,
                    'searchable': false
                },

                {
                    data: 'title',
                    name: 'title'
                },
                
                {
                    data: 'published_at_render',
                    name: 'published_at_render'
                },
                
                {
                    data: 'publish_draft_status',
                    name: 'publish_draft_status'
                },


                {
                    data: 'author_name',
                    name: 'author_name',
                },


                {
                    data: 'status_item',
                    name: 'status_item',
                },


                {
                    data: 'action',
                    name: 'action',
                },
            ]
        });
    </script>
@endpush