@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@push('css')
    <style>
        .invoice-status-success {
            background-color: #d4edda;
            color: #155724;
            padding: 0.25em 0.5em;
            border-radius: 3px;
            font-weight: 600;
            display: inline-block;
            font-size: 90%;
            height: max-content;
        }

        .invoice-status-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 0.25em 0.5em;
            border-radius: 3px;
            font-weight: 600;
            display: inline-block;
            font-size: 90%;
            height: max-content;
        }

        .invoice-status-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.25em 0.5em;
            border-radius: 3px;
            font-weight: 600;
            display: inline-block;
            font-size: 90%;
            height: max-content;
        }

        .invoice-status-secondary {
            background-color: #e2e3e5;
            color: #383d41;
            padding: 0.25em 0.5em;
            border-radius: 3px;
            font-weight: 600;
            display: inline-block;
            font-size: 90%;
            height: max-content;
        }

        .invoice-status-info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 0.25em 0.5em;
            border-radius: 3px;
            font-weight: 600;
            display: inline-block;
            font-size: 90%;
            height: max-content;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card border mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <div>
                                    <div class="d-flex gap-3 align-items-center mb-2">
                                        <h2 class="mb-0">Invoice #{{ $data->invoice_id }}</h2>
                                        @if ($data->status === 'paid')
                                            <span class="invoice-status-success">Paid</span>
                                        @elseif ($data->status === 'pending')
                                            <span class="invoice-status-info">Pending</span>
                                        @elseif ($data->status === 'danger')
                                            <span class="invoice-status-danger">Overdue</span>
                                        @elseif ($data->status === 'unpaid')
                                            <span class="invoice-status-warning">Unpaid</span>
                                        @else
                                            <span class="invoice-status-secondary">Cancelled</span>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-3">
                                        <a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#modalUpload"><i class="bx bx-upload"></i>&nbsp;<small>Upload Proof of Payment</small></a>
                                        <a href="#" class="text-secondary"><i class="bx bx-download"></i>&nbsp;<small>Download</small></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 row my-2">
                                <div class="col-sm-6 col-md-12 row">
                                    <div class="col-md-6">
                                        <h6>Invoice Date</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ Carbon::parse($data->created_at)->format('l, F jS, Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-12 row">
                                    <div class="col-md-6">
                                        <h6>Payment Method</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p>BCA 0113296060 a.n STEPHANUS PRADIPTA YOGI SETIAWAN</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-4 order-1 order-md-2 my-2 d-flex flex-column justify-content-between align-items-center">
                                <h6>Invoiced To</h6>
                                <address>
                                    {{ auth()->user()->first_name }}{{ auth()->user()->last_name ? ' ' . auth()->user()->last_name : '' }}<br>
                                    {{ auth()->user()->email_address }}
                                </address>
                            </div>
                            <div class="col-12 col-md-8 order-2 order-md-1 my-2">
                                <h6>Invoice Items</h6>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Package Layaran Livechat - {{ strtoupper($data->plan->title) }} 
                                                ({{ Carbon::parse($data->created_at)->format('l, F jS, Y') }} - 
                                                 {{ Carbon::parse($data->due_date)->format('l, F jS, Y') }}) *
                                            </td>
                                            <td>Rp. {{ number_format($data->amount, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="{{ route('billings.uploadProof', $data->invoice_id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Proof of Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                        <label for="customField-1" class="form-label">Select file to upload</label>
                        <input class="form-control" type="file" id="customField-1" name="customField-1" required>
                    </div>
                    <div id="previewContainer" style="display: none; margin-bottom: 1rem; text-align:center;">
                        <img id="imagePreview" src="" alt="Image Preview" style="width: 50%; height: auto;">
                      </div>
                    <small class="text-muted">
                        Allowed file types: jpg, jpeg, png. Max file size: 2MB.
                    </small>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('customField-1').addEventListener('change', function(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2097152;

            function hideModalAndShowAlert(title, text) {
                const modalElement = document.getElementById('modalUpload');
                let modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (!modalInstance) {
                modalInstance = new bootstrap.Modal(modalElement);
                }
                modalInstance.hide();
                setTimeout(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: false,
                    showConfirmButton: false,
                });
                }, 500);
            }

            
            if (file) {
                if (!allowedTypes.includes(file.type)) {
                hideModalAndShowAlert('Invalid File Type', 'Please upload an image file (jpg, jpeg, png) only.');
                fileInput.value = '';
                document.getElementById('previewContainer').style.display = 'none';
                return;
                }

                if (file.size > maxSize) {
                hideModalAndShowAlert('File Too Large', 'The selected file exceeds the maximum allowed size of 2MB.');
                fileInput.value = '';
                document.getElementById('previewContainer').style.display = 'none';
                return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                document.getElementById('previewContainer').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }

        });

    </script>

    @if($errors->any())
        <script>
            let errorMsg = "";
            @foreach($errors->all() as $error)
                errorMsg += "{{ $error }}\n";
            @endforeach
            Swal.fire({
                toast: true,
                position: 'top-end',
                title: 'Validation Error!',
                text: errorMsg,
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
            });
        </script>
    @endif
@endpush