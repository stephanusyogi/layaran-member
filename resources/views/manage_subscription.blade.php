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

        .card-cycle-active{
            background: #e5f1ff;
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

    </style>
@endpush


@section('content')
    {{-- Plan --}}
    <div class="container-xxl flex-grow-1 container-p-y" id="plans-container">
        <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-plan" data-plan="basic">
                                <div class="card-body">
                                    <h4>Basic Plan</h4>
                                    <ul class="features-list">
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Maximum of 2 Events
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            5.000 Messages
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Customizable message bubble colors, fonts, and sizes
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            IP & Email Tracking
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Up to 100 MB storage
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-plan" data-plan="standard">
                                <div class="card-body">
                                    <h4>Standard Plan</h4>
                                    <ul class="features-list">
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Maximum of 4 Events
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            25.000 Messages
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Full Customization (Bubble & Background)
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Send Image Attachments (up to 10 MB / file)
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            IP & Email Tracking
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Up to 300 MB storage
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-plan" data-plan="premium">
                                <div class="card-body">
                                    <h4>Premium Plan</h4>
                                    <ul class="features-list">
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Maximum of 6 Events
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            100.000 Messages
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Full Customization (Bubble & Background)
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Animations Effect Features
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Chats Themes
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Send Image Attachments (up to 15 MB / file)
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            IP & Email Tracking
                                        </li>
                                        <li>
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            Up to 1 GB storage
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    {{-- Billing Cycle --}}
    <div class="container-xxl flex-grow-1 container-p-y hidden" id="billing-cycle-container">
        <div id="billing-cycle">
            <div id="basic-billing-cycle" class="billing-details hidden">
                <div class="d-flex align-items-center mb-3" style="gap: 1rem">
                    <h4 class="my-0">Order Package - STANDARD</h4>
                    <button class="btn btn-secondary btn-sm back-btn">Back</button>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-cycle">
                                            <div class="card-body text-center">
                                                <p class="my-0">Every 1 Week</p>
                                                <h4 class="my-0">Rp. 25.000</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-cycle">
                                            <div class="card-body text-center">
                                                <p class="my-0">Every 2 Weeks</p>
                                                <h4 class="my-0">Rp. 50.000</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-cycle">
                                            <div class="card-body text-center">
                                                <p class="my-0">Every 1 Month</p>
                                                <h4 class="my-0">Rp. 100.000</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-cycle card-cycle-active">
                                            <div class="card-body text-center">
                                                <p class="my-0">Every 3 Months</p>
                                                <h4 class="my-0">Rp. 300.000</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h5>Informasi Pemesan :</h5>
                                <p>{{ auth()->user()->first_name .' '.auth()->user()->last_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>Summary</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="standard-billing-cycle" class="billing-details hidden">
                <h4>Standard Plan Billing Cycle</h4>
                <p>Details about the Standard Plan billing cycle.</p>
            </div>
            <div id="premium-billing-cycle" class="billing-details hidden">
                <h4>Premium Plan Billing Cycle</h4>
                <p>Details about the Premium Plan billing cycle.</p>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const plansContainer = document.getElementById('plans-container');
            const billingCycleContainer = document.getElementById('billing-cycle-container');
            const backBtns = document.getElementsByClassName('back-btn');

            document.querySelectorAll('.card-plan').forEach(card => {
                card.addEventListener('click', function () {
                    const plan = card.getAttribute('data-plan');

                    document.querySelectorAll('.billing-details').forEach(el => {
                        el.classList.add('hidden');
                    });

                    const detailsToShow = document.getElementById(`${plan}-billing-cycle`);
                    if (detailsToShow) {
                        detailsToShow.classList.remove('hidden');
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
        });
    </script>
@endpush