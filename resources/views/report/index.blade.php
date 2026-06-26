@extends('layouts.app')

@section('title', 'Report')

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
            <button class="nav-link active" id="sales-tab" data-coreui-toggle="tab" data-coreui-target="#sales"
                type="button" role="tab" aria-controls="home" aria-selected="true">Sales Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="winning-tab" data-coreui-toggle="tab" data-coreui-target="#winning" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Winning Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="number-wise-tab" data-coreui-toggle="tab" data-coreui-target="#number-wise"
                type="button" role="tab" aria-controls="number-wise" aria-selected="false">Number Wise Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="account-tab" data-coreui-toggle="tab" data-coreui-target="#account" type="button"
                role="tab" aria-controls="account" aria-selected="false">A/c Summary Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="net-pay-tab" data-coreui-toggle="tab" data-coreui-target="#net-pay" type="button"
                role="tab" aria-controls="net-pay" aria-selected="false">Net Pay Report</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active bg-white border border-top-0" id="sales" role="tabpanel"
            aria-labelledby="sales-tab" tabindex="0">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
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
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Ticket Number">
                                <label for="floatingInput">Ticket Numer</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">From Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">To Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingSelect">Group</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Mode</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Super Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate
                                Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="winning" role="tabpanel" aria-labelledby="winning-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
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
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Ticket Number">
                                <label for="floatingInput">Ticket Numer</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">From Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">To Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingSelect">Group</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Mode</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Super Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate
                                Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="number-wise" role="tabpanel"
            aria-labelledby="number-wise-tab" tabindex="2">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
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
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Ticket Number">
                                <label for="floatingInput">Ticket Numer</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">From Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">To Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingSelect">Group</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Mode</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Super Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate
                                Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="account" role="tabpanel" aria-labelledby="account-tab"
            tabindex="3">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
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
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Ticket Number">
                                <label for="floatingInput">Ticket Numer</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">From Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">To Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingSelect">Group</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Mode</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Super Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate
                                Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="net-pay" role="tabpanel" aria-labelledby="net-pay-tab"
            tabindex="4">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
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
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Ticket Number">
                                <label for="floatingInput">Ticket Numer</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">From Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">To Date</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingSelect">Group</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Mode</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Super Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingInput">Agent</label>
                            </div>
                        </div>
                        <div class="col-md-3 cols-ms-12">
                            <button class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate
                                Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
