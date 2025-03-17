@extends('layouts.app')

@push('css')
    <style>
        .row > [class*='col-'] {
            display: flex;
            flex-direction: column;
        }

        .card-plan, .card-cycle {
            flex: 1;
            transition: box-shadow 0.3s ease;
        }

        .card-plan:hover, .card-cycle:hover {
            box-shadow: 0 0 15px rgba(13, 131, 253, 0.5);
            color: #0d83fd!important;
            cursor: pointer;
        }

        .card-plan:hover h4 ,.card-cycle:hover h4 {
            color: #0d83fd !important;
        }

        .features-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .features-list li {
            margin-bottom: 5px;
        }

        .hidden {
            display: none;
        }

        .hidden-checkbox-plan {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .hidden-checkbox-plan:checked + .card-body {
            box-shadow: 0 0 15px rgba(13, 131, 253, 0.5);
            border-radius: 10px;
            color: #0d83fd !important;
        }
        .hidden-checkbox-plan:checked + .card-body h4{
            color: #0d83fd !important;
        }

        .hidden-checkbox-cycle {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .hidden-checkbox-cycle:checked + .card-body {
            background: #e5f1ff;
            border-radius: 10px;
        }
        .summary-right{
            text-align: right;
        }


    </style>
@endpush


@section('content')
    <form id="formMembership" action="{{ route('billings.order') }}" method="POST" autocomplete="off">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y" id="plans-container">
            <div class="row">
                @error('plan')
                    <div class="col-md-12">
                        <div class="alert alert-danger mt-3" role="alert">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('cycle')
                    <div class="col-md-12">
                        <div class="alert alert-danger mt-3" role="alert">
                            {{ $message }}
                        </div>
                    </div>
                @enderror

                @foreach($plans as $plan)
                    <div class="col-md-4">
                        <div class="card card-plan" data-plan="{{ $plan->name }}">
                            <input type="checkbox" name="customField-1" value="{{ $plan->id }}" class="hidden-checkbox-plan" data-plan="{{ $plan->name }}"/>
                            <div class="card-body">
                                <h4>{{ $plan->title }}</h4>
                                <ul class="features-list">
                                    @foreach(json_decode($plan->features, true) as $feature)
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="container-xxl flex-grow-1 container-p-y hidden" id="billing-cycle-container">
            <div id="billing-cycle">
                @foreach($plans as $plan)
                    <div id="{{ $plan->name }}-billing-cycle" class="billing-details hidden">
                        <div class="d-flex align-items-center mb-3" style="gap: 1rem">
                            <h4 class="my-0">Order Package - {{ strtoupper($plan->name) }}</h4>
                            <button class="btn btn-secondary btn-sm back-btn" type="button">Back</button>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($plan->billingCycles as $cycle)
                                                <div class="col-md-3">
                                                    <div class="card card-cycle">
                                                        <input type="checkbox" name="customField-2" value="{{ $cycle->cycle }}" class="hidden-checkbox-cycle" data-price="{{ $cycle->price }}"/>
                                                        <div class="card-body text-center">
                                                            <p class="my-0">{{ ucwords(str_replace('_', ' ', $cycle->cycle)) }}</p>
                                                            <h4 class="my-0">Rp. {{ number_format($cycle->price, 0, ',', '.') }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <h5>Informasi Pemesan :</h5>
                                        <p class="my-0">{{ auth()->user()->first_name .' '. auth()->user()->last_name }}</p>
                                        <p class="my-0">{{ auth()->user()->email_address }}</p>
                                    </div>
                                </div>
                                <div class="alert alert-secondary mt-3" role="alert">
                                    Click "<strong>Order Now</strong>" and attach proof of your payment. Don't worry, you can cancel your order at any time.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body {{ $plan->name }}-summary">
                                        <h4>Summary</h4>
                                        <hr>
                                        <table class="w-100">
                                            <tr>
                                                <td>Detail</td>
                                                <td class="summary-right">1 Item</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Package Layaran Livechat - {{ strtoupper($plan->name) }}</td>
                                            </tr>
                                            <tr>
                                                <td><span class="summary-cycle">-</span></td>
                                                <td class="summary-right"><span class="summary-price">Rp. -</span></td>
                                            </tr>
                                        </table>
                                        <hr>
                                        <h1 class="mt-2 mb-5"><span class="summary-total">Rp. -</span></h1>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info w-100">Order Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const plansContainer = document.getElementById('plans-container');
            const billingCycleContainer = document.getElementById('billing-cycle-container');
            const backBtns = document.getElementsByClassName('back-btn');

            document.querySelectorAll('.card-plan').forEach(card => {
                card.addEventListener('click', function () {
                    document.querySelectorAll('.hidden-checkbox-plan').forEach(checkbox => {
                        checkbox.checked = false;
                    });

                    const checkbox = card.querySelector('.hidden-checkbox-plan');
                    if (checkbox) {
                        checkbox.checked = true;
                    }

                    const plan = card.getAttribute('data-plan');
                    
                    document.querySelectorAll('.billing-details').forEach(el => {
                        el.classList.add('hidden');
                    });
                    
                    const detailsToShow = document.getElementById(`${plan}-billing-cycle`);
                    if (detailsToShow) {
                        detailsToShow.classList.remove('hidden');
                    }
                
                    document.querySelectorAll('.hidden-checkbox-cycle').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    const summaryDiv = document.querySelector(`.${plan}-summary`);
                    if (summaryDiv) {
                        summaryDiv.querySelector('.summary-cycle').textContent = '-';
                        summaryDiv.querySelector('.summary-price').textContent = 'Rp. -';
                        summaryDiv.querySelector('.summary-total').textContent = 'Rp. -';
                    }
                    
                    plansContainer.classList.add('hidden');
                    billingCycleContainer.classList.remove('hidden');
                });
            });

            Array.from(backBtns).forEach(btn => {
                btn.addEventListener('click', function () {
                    billingCycleContainer.classList.add('hidden');
                    plansContainer.classList.remove('hidden');
                });
            });

            document.querySelectorAll('.card-cycle').forEach(card => {
                card.addEventListener('click', function () {
                    document.querySelectorAll('.hidden-checkbox-cycle').forEach(checkbox => {
                        checkbox.checked = false;
                    });

                    const checkbox = card.querySelector('.hidden-checkbox-cycle');
                    if (checkbox) {
                        checkbox.checked = true;
                        const price = checkbox.getAttribute('data-price');
                        const cycleText = card.querySelector('p').textContent;
                        
                        const currentPlan = document.querySelector('.hidden-checkbox-plan:checked').getAttribute('data-plan');
                        const currentSummaryDiv = document.querySelector(`.${currentPlan}-summary`);
                        
                        if (currentSummaryDiv) {
                            currentSummaryDiv.querySelector('.summary-cycle').textContent = cycleText;
                            currentSummaryDiv.querySelector('.summary-price').textContent = `Rp. ${parseInt(price).toLocaleString('id-ID')}`;
                            currentSummaryDiv.querySelector('.summary-total').textContent = `Rp. ${parseInt(price).toLocaleString('id-ID')}`;
                        }
                    }
                });
            });

            document.querySelectorAll("form#formMembership").forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    
                    Swal.fire({
                        title: 'Confirm Live Chat Order?',
                        text: 'Please confirm that you wish to proceed with the live chat order. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm Order',
                        cancelButtonText: 'Cancel Request',
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