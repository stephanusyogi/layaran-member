@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold py-3 my-0"><span class="text-muted fw-light">Data Administrators /</span> All</h4>
            <a href="{{ route('administrators.add') }}" class="btn btn-primary"><i class="tf-icons bx bx-plus"></i> Create New</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="table_admin" class="table datatable-style">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Created At</th>
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
        $('#table_admin').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 20, 25, -1],
                [10, 20, 25, "50"]
            ],
            ajax: {
                url: "{{ route('administrators') }}",
                type: "get",
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    'orderable': false,
                    'searchable': false
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'email_address',
                    name: 'email_address'
                },
                
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                
                {
                    data: 'timestamp',
                    name: 'timestamp'
                },


                {
                    data: 'status_user',
                    name: 'status_user',
                },


                {
                    data: 'action',
                    name: 'action',
                },
            ]
        });
    </script>
@endpush