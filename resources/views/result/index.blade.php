@extends('layouts.app')

@section('title', 'Result')

@section('breadcrumb')
    <!-- <div class="container-fluid px-4">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb my-0">
                                                <li class="breadcrumb-item active"><span>Dashboard</span></li>
                                            </ol>
                                        </nav>
                                    </div> -->
@endsection

@section('content')

    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="result-tab" data-coreui-toggle="tab" data-coreui-target="#result"
                type="button" role="tab" aria-controls="home" aria-selected="true">Result Publish</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-coreui-toggle="tab" data-coreui-target="#history" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Result History</button>
        </li>
    </ul>
    <div class="tab-content mb-2" id="myTabContent">

        <div class="tab-pane fade show active bg-white border border-top-0" id="result" role="tabpanel"
            aria-labelledby="result-tab" tabindex="0">
            <div class="card border border-0 rounded-0">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="history" role="tabpanel" aria-labelledby="history-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <div class="card-body pb-2">
                        <div class="row g-2 g-md-auto">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        <option selected>All</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <label for="floatingSelect">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        <option selected>All</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <label for="floatingSelect">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Date</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary h-100 w-100"><i class="icon cil-search me-1"></i>
                                    Search</button>
                            </div>
                        </div>

                        <div class="row mt-5 justify-content-center">
                            <div class="col-md-2">
                                <div class="card shadow border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="card-title fw-bold">1</h2>
                                        <h5 class="card-subtitle my-2 text-body-secondary fw-semibold">748</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card shadow border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="card-title fw-bold">2</h2>
                                        <h5 class="card-subtitle my-2 text-body-secondary fw-semibold">289</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card shadow border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="card-title fw-bold">3</h2>
                                        <h5 class="card-subtitle my-2 text-body-secondary fw-semibold">008</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card shadow border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="card-title fw-bold">4</h2>
                                        <h5 class="card-subtitle my-2 text-body-secondary fw-semibold">157</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card shadow border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="card-title fw-bold">5</h2>
                                        <h5 class="card-subtitle my-2 text-body-secondary fw-semibold">335</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <table class="table table-bordered border-primary">
                                    <tbody class="text-center">
                                        <tr>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                        </tr>
                                        <tr>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                        </tr>
                                        <tr>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                        </tr>
                                        <tr>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                        </tr>
                                        <tr>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                            <td>007</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>




    <style>
        .card.shadow.border-primary:hover {
            background: var(--cui-primary);
            color: white !important;
            cursor: default;
        }

        .card.shadow.border-primary {
            transition: all 400ms ease-in;
        }
    </style>
@endsection
