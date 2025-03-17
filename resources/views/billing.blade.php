@extends('layouts.app')

@push('css')
    <style>
        #table_billings > tbody > tr > td > p {
            margin-bottom: 0px!important;
        }
        #table_billings > tbody > tr {
            transition: background-color 0.1s ease;
        }

        #table_billings > tbody > tr:hover {
            cursor: pointer;
            background-color: rgb(227, 227, 227);
        }

        td.dt-type-numeric{
            text-align: center!important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body border">
                        <div class="table-responsive text-nowrap">
                            <table id="table_billings" class="table datatable-style">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
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
        $('#table_billings').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 20, 25, -1],
                [10, 20, 25, "50"]
            ],
            ajax: {
                url: "{{ route('billings') }}",
                type: "get",
            },
            columns: [
                { data: 'invoice_id', name: 'invoice_id', className: 'text-center' },
                { data: 'invoice_date', name: 'invoice_date', className: 'text-center' },
                { data: 'due_date', name: 'due_date', className: 'text-center' },
                { data: 'total_billing', name: 'total_billing', className: 'text-center' },
                { data: 'status_billing', name: 'status_billing', className: 'text-center' },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-href', data.action_link);
            },
        });

        $('#table_billings tbody').on('click', 'tr', function () {
            var href = $(this).data('href');
            if (href) {
                window.location = href;
            }
        });
    </script>
@endpush