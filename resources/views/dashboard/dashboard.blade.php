@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')

    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
        </nav>
        <div class="input-group input-group-sm" style="width:auto;">
            <input type="text" class="date-range form-control" id="daterange" name="daterange" value="" />
            <span class="input-group-text"><i class="icon cil-calendar"></i></span>
        </div>
    </div>

@endsection

@section('content')

    <div class="row g-4 mb-4">
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-dollar"></i>
                            Collection
                        </div>
                        <div class="fs-6 fw-semibold mb-3 collection-amount">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-user"></i>
                            Admin
                        </div>
                        <div class="fs-6 fw-semibold mb-3 admin-amount">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-group"></i>
                            Super Agent
                        </div>
                        <div class="fs-6 fw-semibold mb-3 super-agent-amount">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-group"></i>
                            Agent
                        </div>
                        <div class="fs-6 fw-semibold mb-3 agent-amount">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-group"></i>
                            Winner
                        </div>
                        <div class="fs-6 fw-semibold mb-3 winner-amount">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

    <div class="row g-4 mb-4">
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tags"></i>
                            Super
                        </div>
                        <div class="fs-6 fw-semibold mb-3 super-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tags"></i>
                            Box
                        </div>
                        <div class="fs-6 fw-semibold mb-3 box-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tags"></i>
                            AB
                        </div>
                        <div class="fs-6 fw-semibold mb-3 ab-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tags"></i>
                            BC
                        </div>
                        <div class="fs-6 fw-semibold mb-3 bc-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
         <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tags"></i>
                            AC
                        </div>
                        <div class="fs-6 fw-semibold mb-3 ac-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tag"></i>
                            A
                        </div>
                        <div class="fs-6 fw-semibold mb-3 a-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tag"></i>
                            B
                        </div>
                        <div class="fs-6 fw-semibold mb-3 b-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tag"></i>
                            C
                        </div>
                        <div class="fs-6 fw-semibold mb-3 c-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
         <div class="col">
            <div class="card text-white bg-primary shadow">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4">
                            <i class="icon icon-xl me-2 cil-tag"></i>
                            Total Number
                        </div>
                        <div class="fs-6 fw-semibold mb-3 total-count">
                            <div class="spinner-grow spinner-grow-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="mb-3">
                    <h4 class="card-title mb-0">Graph Reports</h4>
                    <div class="small text-body-secondary filter-dates"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8" style="height:300px">
                    <canvas class="chart" id="barChart"></canvas>
                </div>
                <div class="col-md-4" style="height:300px">
                    <canvas class="chart" id="pieChart"></canvas>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row g-4 mb-2 text-center">
                <div class="col">
                    <div class="text-body-secondary">Total</div>
                    <div class="fw-semibold text-truncate total-amount"></div>

                </div>
                <div class="col">
                    <div class="text-body-secondary">Admin</div>
                    <div class="fw-semibold text-truncate admin-total"></div>
                </div>
                <div class="col">
                    <div class="text-body-secondary">Super Agent</div>
                    <div class="fw-semibold text-truncate super-agent-total"></div>
                </div>
                <div class="col">
                    <div class="text-body-secondary">Agent</div>
                    <div class="fw-semibold text-truncate agent-total"></div>
                </div>
                <div class="col">
                    <div class="text-body-secondary">Winner</div>
                    <div class="fw-semibold text-truncate winner-total"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            cursor: default;
        }
        .date-range{
            cursor: pointer;
        }
    </style>

@endsection

@push('scripts')

    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
    <script>
        let barChartInstance = null;
        let pieChartInstance = null;

        $(document).ready(function () {

            $('#daterange').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                dashboardData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });

            const today = new Date();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const yyyy = today.getFullYear();
            const current = `${mm}/${dd}/${yyyy}`;
            $('#daterange').val(`${current} - ${current}`);

            dashboardData(current, current);
            dashboardTotalData();
        });

        function dashboardData(startDate, endDate) {
            startDate = moment(startDate);
            endDate = moment(endDate);
            $('.filter-dates').text(`${startDate.format('DD-MMMM-YYYY').toLowerCase()} - ${endDate.format('DD-MMMM-YYYY').toLowerCase()}`);
            $.ajax({
                url: "{{ route('dashboard.details') }}",
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    startDate: startDate.format('YYYY-MM-DD'),
                    endDate: endDate.format('YYYY-MM-DD')
                },
                beforeSend: function () {

                },
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $('.collection-amount').text(`₹ ${response.collection}`);
                        $('.admin-amount').text(`₹ ${response.admin}`);
                        $('.super-agent-amount').text(`₹ ${response.sa_commission}`);
                        $('.agent-amount').text(`₹ ${response.a_commission}`);
                        $('.winner-amount').text(`₹ ${response.winner}`);

                        $('.a-count').text(`${response.a_total}`);
                        $('.b-count').text(`${response.b_total}`);
                        $('.c-count').text(`${response.c_total}`);
                        $('.ab-count').text(`${response.ab_total}`);
                        $('.bc-count').text(`${response.bc_total}`);
                        $('.ac-count').text(`${response.ac_total}`);
                        $('.box-count').text(`${response.box_total}`);
                        $('.super-count').text(`${response.super_total}`);
                        $('.total-count').text(`${response.total_count}`);

                        // 'A', 'B', 'C', 'AB', 'BC', 'AC', 'BOX', 'SUPER'
                        barChart([response.a_total,
                        response.b_total,
                        response.c_total,
                        response.ab_total,
                        response.bc_total,
                        response.ac_total,
                        response.box_total,
                        response.super_total]);

                        // 'Admin', 'Super Agent', 'Agent', 'Winner'
                        pieChart([
                            Math.max(0, Number(response.admin || 0)),
                            Math.max(0, Number(response.sa_commission || 0)),
                            Math.max(0, Number(response.a_commission || 0)),
                            Math.max(0, Number(response.winner || 0))
                        ]);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseJSON?.message ?? "Something went wrong.");
                },
                complete: function () {

                }
            });
        }

        function dashboardTotalData() {

            $.ajax({
                url: "{{ route('dashboard.details') }}",
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    startDate: null,
                    endDate: null
                },
                beforeSend: function () {

                },
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $('.total-amount').text(`₹ ${response.collection}`);
                        $('.admin-total').text(`₹ ${response.admin}`);
                        $('.super-agent-total').text(`₹ ${response.sa_commission}`);
                        $('.agent-total').text(`₹ ${response.a_commission}`);
                        $('.winner-total').text(`₹ ${response.winner}`);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseJSON?.message ?? "Something went wrong.");
                },
                complete: function () {

                }
            });
        }





        function barChart(data) {
            const ctxBar = document.getElementById('barChart');
            if (barChartInstance) {
                barChartInstance.destroy();
            }
            barChartInstance = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['A', 'B', 'C', 'AB', 'BC', 'AC', 'BOX', 'SUPER'],
                    datasets: [{
                        label: 'Mode',
                        data: data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function pieChart(data) {
            const ctxPie = document.getElementById('pieChart');
            if (pieChartInstance) {
                pieChartInstance.destroy();
            }
            pieChartInstance = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Admin', 'Super Agent', 'Agent', 'Winner'],
                    datasets: [{
                        label: '₹',
                        data: data,
                        borderWidth: 1,
                        backgroundColor: ['#CB4335', '#1F618D', '#F1C40F', '#27AE60'],
                    }]
                }
            });
        }

    </script>
@endpush
