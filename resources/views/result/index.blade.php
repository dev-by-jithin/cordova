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

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="fw-bold mb-0">Results</h5>
                </div>
                <div class="card-body pb-2">
                    <div class="row g-2 g-md-auto">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
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
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
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
                            <button class="btn btn-primary h-100 w-100"><i class="icon cil-search me-1"></i> Search</button>
                        </div>
                    </div>

                    <div class="row mt-5 justify-content-center">
                        <div class="col-md-2">
                            <div class="card shadow border-primary">
                                <div class="card-body text-center">
                                    <h2 class="card-title">1</h2>
                                    <h5 class="card-subtitle my-2 text-body-secondary">748</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card shadow border-primary">
                                <div class="card-body text-center">
                                    <h2 class="card-title ">2</h2>
                                    <h5 class="card-subtitle my-2 text-body-secondary">289</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card shadow border-primary">
                                <div class="card-body text-center">
                                    <h2 class="card-title ">3</h2>
                                    <h5 class="card-subtitle my-2 text-body-secondary">008</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card shadow border-primary">
                                <div class="card-body text-center">
                                    <h2 class="card-title ">4</h2>
                                    <h5 class="card-subtitle my-2 text-body-secondary">157</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card shadow border-primary">
                                <div class="card-body text-center">
                                    <h2 class="card-title ">5</h2>
                                    <h5 class="card-subtitle my-2 text-body-secondary">335</h5>
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
        <!-- /.col-->
    </div>

@endsection
