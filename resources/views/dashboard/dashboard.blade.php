@extends('layouts.app')

@section('title', 'Dashboard')

@push('stylesheets')
    <link href="{{ asset('assets/vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="container-fluid px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0">
            <li class="breadcrumb-item active"><span>Dashboard</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-user"></i>
                        Admin
                    </div>
                    <div class="fs-6 fw-semibold mb-3">₹ 1000.00</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-group"></i>
                        Super Agent
                    </div>
                    <div class="fs-6 fw-semibold mb-3">₹ 700.00</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-group"></i>
                        Agent
                    </div>
                    <div class="fs-6 fw-semibold mb-3">₹ 500.00</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-group"></i>
                        Winner
                    </div>
                    <div class="fs-6 fw-semibold mb-3">₹ 400.00</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tags"></i>
                        Super
                    </div>
                    <div class="fs-6 fw-semibold mb-3">10</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tags"></i>
                        Box
                    </div>
                    <div class="fs-6 fw-semibold mb-3">10</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tags"></i>
                        AB
                    </div>
                    <div class="fs-6 fw-semibold mb-3">10</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tags"></i>
                        BC
                    </div>
                    <div class="fs-6 fw-semibold mb-3">50</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tags"></i>
                        AC
                    </div>
                    <div class="fs-6 fw-semibold mb-3">10</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tag"></i>
                        A
                    </div>
                    <div class="fs-6 fw-semibold mb-3">10</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tag"></i>
                        B
                    </div>
                    <div class="fs-6 fw-semibold mb-3">10</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4">
                        <i class="icon icon-xl me-2 cil-tag"></i>
                        C
                    </div>
                    <div class="fs-6 fw-semibold mb-3">50</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
        <div>
            <h4 class="card-title mb-0">Traffic</h4>
            <div class="small text-body-secondary">October 2025 - April 2026</div>
        </div>
        <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
            <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
            <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off">
            <label class="btn btn-outline-secondary">Day</label>
            <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off" checked="">
            <label class="btn btn-outline-secondary active">Month</label>
            <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off">
            <label class="btn btn-outline-secondary">Year</label>
            </div>
            <button class="btn btn-primary" type="button">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="var(--ci-primary-color, currentcolor)" d="M272 434.744V209.176h-32v225.568l-51.882-51.882-22.628 22.627L256 496l90.51-90.511-22.628-22.627z" class="ci-primary" />
                <path fill="var(--ci-primary-color, currentcolor)" d="M400 161.176c0-79.4-64.6-144-144-144s-144 64.6-144 144a96 96 0 0 0 0 192h80v-32h-80a64 64 0 0 1 0-128h32v-32a112 112 0 0 1 224 0v32h32a64 64 0 0 1 0 128h-80v32h80a96 96 0 0 0 0-192" class="ci-primary" />
            </svg>
            </button>
        </div>
        </div>
        <div class="c-chart-wrapper" style="height: 300px; margin-top: 40px">
        <canvas class="chart" id="main-chart" height="300"></canvas>
        </div>
    </div>
    <div class="card-footer">

        <div class="row g-4 mb-2 text-center">
            <div class="col">
                <div class="text-body-secondary">Admin</div>
                <div class="fw-semibold text-truncate">29.703 Users (40%)</div>
                <div class="progress progress-thin mt-2">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col">
                <div class="text-body-secondary">Super Agent</div>
                <div class="fw-semibold text-truncate">24.093 Users (20%)</div>
                <div class="progress progress-thin mt-2">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col">
                <div class="text-body-secondary">Agent</div>
                <div class="fw-semibold text-truncate">78.706 Views (60%)</div>
                <div class="progress progress-thin mt-2">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col">
                <div class="text-body-secondary">Winner</div>
                <div class="fw-semibold text-truncate">22.123 Users (80%)</div>
                <div class="progress progress-thin mt-2">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card{
        cursor: default;
    }
</style>

@endsection

@push('scripts')
    <script src="{{ asset('assets/vendors/chart.js/js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('assets/vendors/@coreui/utils/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endpush
