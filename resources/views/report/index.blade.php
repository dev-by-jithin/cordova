@extends('layouts.app')

@section('title', 'Report')

@section('breadcrumb')

@endsection

@section('content')

    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="sales-tab" data-coreui-toggle="tab" data-coreui-target="#sales"
                type="button" role="tab" aria-controls="home" aria-selected="true">Sales Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="winning-tab" data-coreui-toggle="tab" data-coreui-target="#winning" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Winning Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="number-wise-tab" data-coreui-toggle="tab" data-coreui-target="#number-wise"
                type="button" role="tab" aria-controls="number-wise" aria-selected="false">Number Wise Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="account-tab" data-coreui-toggle="tab" data-coreui-target="#account" type="button"
                role="tab" aria-controls="account" aria-selected="false">A/c Summary Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="net-pay-tab" data-coreui-toggle="tab" data-coreui-target="#net-pay" type="button"
                role="tab" aria-controls="net-pay" aria-selected="false">Net Pay Report</button>
        </li>
    </ul>
    <div class="tab-content mb-2" id="myTabContent">

        <div class="tab-pane fade show active bg-white border border-top-0" id="sales" role="tabpanel"
            aria-labelledby="sales-tab" tabindex="0">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.sales.summary') }}" method="GET" id="sales_summary" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticket_id">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="ticket_number" placeholder="Ticket Number">
                                    <label for="ticketNumber">Ticket Numer</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="from_date" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="to_date" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="group_id">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="mode_id">
                                        <option value="" selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent-id" name="agent_id">
                                        <option value="" selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="winning" role="tabpanel" aria-labelledby="winning-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.winning.summary') }}" method="GET" id="winning_summary" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticket_id">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="ticket_number" placeholder="Ticket Number">
                                    <label for="ticketNumber">Ticket Numer</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="from_date" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="to_date" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="group_id">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="mode_id">
                                        <option value="" selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent-id" name="agent_id">
                                        <option value="" selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="number-wise" role="tabpanel"
            aria-labelledby="number-wise-tab" tabindex="2">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.number.wise') }}" method="GET" id="number_report" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticket_id">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="ticket_number" placeholder="Ticket Number">
                                    <label for="ticketNumber">Ticket Numer</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="date" placeholder="">
                                    <label for="date">Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="group_id">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="mode_id">
                                        <option value="" selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent-id" name="agent_id">
                                        <option value="" selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="account" role="tabpanel" aria-labelledby="account-tab"
            tabindex="3">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.account.summary') }}" method="GET" id="account_summary" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticket_id">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="from_date" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="to_date" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="group_id">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="mode_id">
                                        <option value="" selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent-id" name="agent_id">
                                        <option value="" selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="net-pay" role="tabpanel" aria-labelledby="net-pay-tab"
            tabindex="4">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.net.pay') }}" method="GET" id="net_pay" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticket_id">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="from_date" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="to_date" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="group_id">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="mode_id">
                                        <option value="" selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent-id" name="agent_id">
                                        <option value="" selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="salesSummary" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="staticBackdropLabel">Sales Summary</h5>
            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="salesUsers" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Sales Users</h5>
            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="salesUsersBack()">Back</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="salesReport" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Sales Report</h5>
            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="salesReportBack()">Back</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="winningSummary" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="staticBackdropLabel">Winning Summary</h5>
            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="winningUsers" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Winning Users</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="winningUsersBack()">Back</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="winningReport" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Winning Report</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="result">

                </div>
                <table class="table table-sm table-bordered mt-2 report-table d-none text-center">
                    <thead class="table-primary">
                    <tr>
                        <th>Bill</th>
                        <th>SA</th>
                        <th>A</th>
                        <th>Ticket</th>
                        <th>Number</th>
                        <th>P</th>
                        <th>Count</th>
                        <th>Super</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="winningReportBack()">Back</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="numberReport" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Number Report</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-primary">
                    <tr>
                        <th colspan="3">Total Count: <span id="count">0</span></th>
                        <th class="text-center">
                            <button id="downloadPdf" class="btn btn-sm btn-light"> <i class="bi bi-filetype-pdf"></i> </button>
                        </th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Ticket</th>
                        <th>Number</th>
                        <th>Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="accountSummary" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Account Summary</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating">
                    <select class="form-select" id="dates">
                    </select>
                    <label for="dates">Dates</label>
                </div>

                <table class="table table-sm table-bordered text-center d-none mt-2 mb-0 total-table">
                    <thead class="table-primary">
                        <tr>
                        <td>Sales</td>
                        <td>Winnings</td>
                        <td>Balance</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered text-center d-none mt-2 mb-0 caption-top users-table">
                    <caption class="fw-semibold fs-5">Users</caption>
                    <thead class="table-primary">
                        <tr>
                        <td>Users</td>
                        <td>Sales</td>
                        <td>Winnings</td>
                        <td>Balance</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="netPay" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Net Pay</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating">
                    <select class="form-select" id="netDates">
                    </select>
                    <label for="dates">Dates</label>
                </div>

                <table class="table table-sm table-bordered text-center d-none mt-2 mb-0 total-table">
                    <thead class="table-primary">
                        <tr>
                        <td>Sales</td>
                        <td>Winnings</td>
                        <td>Balance</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered text-center d-none mt-2 mb-0 caption-top users-table">
                    <caption class="fw-semibold fs-5">Users</caption>
                    <thead class="table-primary">
                        <tr>
                        <td>Users</td>
                        <td>Sales</td>
                        <td>Winnings</td>
                        <td>Balance</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <script>

    $(document).ready(function(){
        $('input[type="date"]').each(function () {
            this.valueAsDate = new Date();
        });
    });

    $(document).on('change', '.super-agent', function () {

        const superAgent = $(this);
        const superAgentId = superAgent.val();

        const form = superAgent.closest('form');
        const agentSelect = form.find('.agent-id');

        let option = `<option value="" selected>Agent</option>`;

        // Clear agents immediately
        agentSelect.html(option);

        if (superAgentId === '') {
            return;
        }

        $.ajax({
            url: "{{ route('user.agents') }}",
            method: "GET",
            data: {
                superAgentId: superAgentId
            },

            beforeSend: function () {
                agentSelect.prop('disabled', true);
            },

            success: function (response) {

                if (response.status && response.data.length > 0) {

                    $.each(response.data, function (index, agent) {

                        option += `
                            <option value="${agent.id}">
                                ${agent.username}
                            </option>
                        `;
                    });

                    agentSelect.html(option);
                }
            },

            error: function (xhr) {

                console.error(
                    xhr.responseJSON?.message || 'Something went wrong'
                );
            },

            complete: function () {
                agentSelect.prop('disabled', false);
            }
        });
    });

    $('#sales_summary').on('submit', function (e) {

        e.preventDefault();

        const $form = $(this);
        const ticketId = $form.find('[name="ticket_id"]').val();
        const ticketNumber = $form.find('[name="ticket_number"]').val();
        const fromDate = $form.find('[name="from_date"]').val();
        const toDate = $form.find('[name="to_date"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: {
                ticketId,
                ticketNumber,
                fromDate,
                toDate,
                groupId,
                modeId,
                superAgentId,
                agentId
            },
            beforeSend: function () {
                $form.find('button[type="submit"]').prop('disabled', true);
            },
            success: function (response) {

                let dates = '';
                let totalCount = 0;
                let totalAmount = 0;

                if (response.status) {

                    $.each(response.data, function (index, result) {

                        totalCount += Number(result.total_count || 0);
                        totalAmount += parseFloat(result.total_amount || 0);

                        dates += ` <div class="card shadow-sm mt-2">
                                    <div class="card-body text-center">
                                    <div class="fw-bold mb-1">${result.sale_date}</div>
                                        <div class="mb-1"> Sales Amount : ₹ ${parseFloat(result.total_amount || 0).toFixed(2)} </div>
                                        <div class="mb-1"> Count : ${result.total_count} </div>
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm shadow mt-1 view-sales-users"
                                            data-ticket-id="${ticketId || ''}"
                                            data-ticket-number="${ticketNumber || ''}"
                                            data-group-id="${groupId || ''}"
                                            data-mode-id="${modeId || ''}"
                                            data-super-agent-id="${superAgentId || ''}"
                                            data-agent-id="${agentId || ''}"
                                            data-sale-date="${result.sale_date}">
                                            View Details
                                        </button>
                                    </div>
                                </div> `;
                    });

                    $('#salesSummary .modal-body').html(` <div class="card shadow-sm">
                                        <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                            <div class="fw-bold">Total Count</div> ${totalCount}
                                            </div>
                                            <div class="col">
                                            <div class="fw-bold">Total Amount</div> ₹ ${totalAmount.toFixed(2)}
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    ${dates}`
                                    );
                    $('#salesSummary').modal('show');
                }

            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.view-sales-users', function () {

        const ticketId = $(this).data('ticket-id');
        const ticketNumber = $(this).data('ticket-number');
        const groupId = $(this).data('group-id');
        const modeId = $(this).data('mode-id');
        const superAgentId = $(this).data('super-agent-id');
        const agentId = $(this).data('agent-id');
        const saleDate = $(this).data('sale-date');

        $.ajax({
            url: "{{ route('report.sales.users') }}",
            method: "GET",
            data: {
                ticketId, ticketNumber, groupId, modeId, superAgentId, agentId, saleDate
            },
            beforeSend: function () {
                $(this).prop('disabled', true);
            },
            success: function (response) {
                let dates = '';
                let totalCount = 0;
                let totalAmount = 0;

                if (response.status) {

                    $.each(response.data, function (index, result) {

                        totalCount += Number(result.total_count || 0);
                        totalAmount += parseFloat(result.total_amount || 0);

                        dates += ` <div class="card shadow-sm mt-2">
                                    <div class="card-body text-center">
                                    <div class="fw-bold mb-1">${result.agent.username}</div>
                                        <div class="mb-1"> Sales Amount : ₹ ${parseFloat(result.total_amount || 0).toFixed(2)} </div>
                                        <div class="mb-1"> Count : ${result.total_count} </div>
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm shadow mt-1 view-sales-report"
                                            data-ticket-id="${ticketId || ''}"
                                            data-ticket-number="${ticketNumber || ''}"
                                            data-group-id="${groupId || ''}"
                                            data-mode-id="${modeId || ''}"
                                            data-agent-id="${result.agent_id || ''}"
                                            data-sale-date="${saleDate}">
                                            View Details
                                        </button>
                                    </div>
                                </div> `;
                    });

                    $('#salesUsers .modal-body').html(` <div class="card shadow-sm">
                                            <div class="card-body pt-2">
                                            <div class="fw-bold text-center mb-2">${saleDate}</div>
                                            <div class="row text-center">
                                                <div class="col border-end">
                                                <div class="fw-bold">Total Count</div> ${totalCount}
                                                </div>
                                                <div class="col">
                                                <div class="fw-bold">Total Amount</div> ₹ ${totalAmount.toFixed(2)}
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        ${dates}`
                                        );
                    $('#salesSummary').modal('hide');
                    $('#salesUsers').modal('show');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $(this).prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.view-sales-report', function () {

        const ticketId = $(this).data('ticket-id');
        const ticketNumber = $(this).data('ticket-number');
        const groupId = $(this).data('group-id');
        const modeId = $(this).data('mode-id');
        const agentId = $(this).data('agent-id');
        const saleDate = $(this).data('sale-date');

        $.ajax({
            url: "{{ route('report.sales.report') }}",
            method: "GET",
            data: {
                ticketId, ticketNumber, groupId, modeId, agentId, saleDate
            },
            beforeSend: function () {
                $(this).prop('disabled', true);
            },
            success: function (response) {
                let table = '';
                let allCount = 0;
                let allAmount = 0;
                let agentName = '';

                if (response.status) {

                    console.log(response.data);

                    $.each(response.data, function (index, result) {

                    let totalCount = 0;
                    let totalAmount = 0;
                    let tr = '';
                    agentName = result.agent;

                    $.each(result.numbers, function(index, number){
                        totalCount += Number(number.count || 0);
                        totalAmount += parseFloat(number.a_rate || 0);
                        tr += `<tr>
                                <td>${result.ticket}  ${number.mode.name}</td>
                                <td>${number.number}</td>
                                <td>${number.count}</td>
                                <td>${number.a_rate}</td>
                            </tr>`;
                    });

                    allCount += Number(totalCount || 0);
                    allAmount += parseFloat(totalAmount || 0);

                    table += `<table class="table table-sm table-borderless mt-2 mb-0">
                                <thead class="table-primary">
                                    <tr>
                                    <td class="text-left">Bill: <span class="fw-semibold">#${result.bill_id}</span></td>
                                    <td class="text-center fw-semibold">${result.ticket}</td>
                                    <td class="text-end fw-semibold">${result.create_date}</td>
                                    </tr>
                                    <tr>
                                    <td class="text-left fw-semibold">₹ ${totalAmount.toFixed(2)}</td>
                                    <td class="text-center">Qty: <span class="fw-semibold">${totalCount}</span></td>
                                    <td class="text-end fw-semibold">${result.create_time}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                            <th>Ticket</th>
                                            <th>Number</th>
                                            <th>Count</th>
                                            <th>Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${tr}
                                        </tbody>
                                    </table>
                                </tbody>
                            </table>`;
                    });

                    $('#salesReport .modal-body').html(`<div class="card">
                                        <div class="card-body px-1">
                                        <div class="row text-center">
                                            <div class="col-6 border-end">
                                            <div>Date:<strong>${saleDate}</strong></div>
                                            <div>Agent:<strong>${agentName}</strong></div>
                                            </div>
                                            <div class="col-6">
                                            <div>Amount: <strong>₹ ${allAmount.toFixed(2)}</strong></div>
                                            <div>Count:<strong>${allCount}</strong></div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    ${table}`);

                    $('#salesUsers').modal('hide');
                    $('#salesReport').modal('show');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $(this).prop('disabled', false);
            }
        });
    });

    function salesUsersBack()
    {
        $('#salesUsers').modal('hide');
        $('#salesSummary').modal('show');
    }

    function salesReportBack()
    {
        $('#salesReport').modal('hide');
        $('#salesUsers').modal('show');
    }

    $('#winning_summary').on('submit', function (e) {

        e.preventDefault();

        const $form = $(this);
        const ticketId = $form.find('[name="ticket_id"]').val();
        const ticketNumber = $form.find('[name="ticket_number"]').val();
        const fromDate = $form.find('[name="from_date"]').val();
        const toDate = $form.find('[name="to_date"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: {
                ticketId,
                ticketNumber,
                fromDate,
                toDate,
                groupId,
                modeId,
                superAgentId,
                agentId
            },
            beforeSend: function () {
                $form.find('button[type="submit"]').prop('disabled', true);
            },
            success: function (response) {
                if (response.status) {

                    const winningPrize = parseFloat(response.data.winning_prize || 0);
                    const agentPrize = parseFloat(response.data.agent_prize || 0);
                    const winningCount = Number(response.data.winning_count || 0);
                    const total = winningPrize + agentPrize;

                    $('#winningSummary .modal-body').html(`<div class="card">
                              <div class="card-body">
                                <div class="fw-bold text-center">${fromDate} To ${toDate}</div>
                                <div class="row gy-2 mt-3">
                                  <div class="col-6">Total count </div> <div class="col-6">: ${winningCount}</div>
                                  <div class="col-6">Total Amount </div> <div class="col-6">: ₹ ${winningPrize.toFixed(2)}</div>
                                  <div class="col-6">Total Super </div> <div class="col-6">: ₹ ${agentPrize.toFixed(2)}</div>
                                  <div class="col-6">Grand Total </div> <div class="col-6">: ₹ ${total.toFixed(2)}</div>
                                </div>
                                <div class="mt-3 text-center">
                                  <button
                                            type="button"
                                            class="btn btn-primary btn-sm shadow mt-1 view-winning-users"
                                            data-ticket-id="${ticketId || ''}"
                                            data-ticket-number="${ticketNumber || ''}"
                                            data-from-date="${fromDate || ''}"
                                            data-to-date="${toDate || ''}"
                                            data-group-id="${groupId || ''}"
                                            data-mode-id="${modeId || ''}"
                                            data-super-agent-id="${superAgentId || ''}"
                                            data-agent-id="${agentId || ''}">
                                            View Details
                                        </button>
                                </div>
                              </div>
                            </div>`
                            );

                    $('#winningSummary').modal('show');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.view-winning-users', function () {

        const ticketId = $(this).data('ticket-id');
        const ticketNumber = $(this).data('ticket-number');
        const fromDate = $(this).data('from-date');
        const toDate = $(this).data('to-date');
        const groupId = $(this).data('group-id');
        const modeId = $(this).data('mode-id');
        const superAgentId = $(this).data('super-agent-id');
        const agentId = $(this).data('agent-id');

        $.ajax({
            url: "{{ route('report.winning.users') }}",
            method: "GET",
            data: {
                ticketId, ticketNumber, fromDate, toDate, groupId, modeId, superAgentId, agentId
            },
            beforeSend: function () {
                $(this).prop('disabled', true);
            },
            success: function (response) {

                let agents = '';
                let totalCount = 0;
                let totalAmount = 0;

                if (response.status) {

                    $.each(response.data, function (index, result) {

                        totalCount += Number(result.winning_count || 0);
                        totalAmount += parseFloat(result.winning_prize || 0) + parseFloat(result.agent_prize || 0);

                        agents += `<div class="card text-center mt-2">
                                    <div class="card-body">
                                    <div class="fs-5 text-primary fw-bold mb-1">${result.agent.username}</div>
                                    <div class="mb-1">Count : <span class="fw-semibold">${result.winning_count}</span></div>
                                    <div class="mb-1">Prize : <span class="fw-semibold">₹ ${parseFloat(result.winning_prize || 0).toFixed(2)}</span></div>
                                    <div class="mb-1">Super : <span class="fw-semibold">₹ ${parseFloat(result.agent_prize || 0).toFixed(2)}</span></div>
                                    <button
                                                type="button"
                                                class="btn btn-primary btn-sm shadow mt-1 view-winning-report"
                                                data-ticket-id="${ticketId || ''}"
                                                data-ticket-number="${ticketNumber || ''}"
                                                data-from-date="${fromDate || ''}"
                                                data-to-date="${toDate || ''}"
                                                data-group-id="${groupId || ''}"
                                                data-mode-id="${modeId || ''}"
                                                data-agent-id="${result.agent_id || ''}">
                                                View Details
                                            </button>
                                    </div>
                                </div>`;
                    });

                    $('#winningUsers .modal-body').html(` <div class="card text-center">
                                        <div class="card-body">
                                        <div class="mb-2"><span class="fw-semibold">${fromDate}</span> &nbsp; To &nbsp;<span class="fw-semibold">${toDate}</span></div>
                                        <div class="row">
                                            <div class="col border-end">
                                            <div class="fw-bold">Total Count</div>
                                            ${totalCount}
                                            </div>
                                            <div class="col">
                                            <div class="fw-bold">Total Amount</div>
                                            ₹ ${totalAmount.toFixed(2)}
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    ${agents}`
                                    );
                    $('#winningSummary').modal('hide');
                    $('#winningUsers').modal('show');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $(this).prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.view-winning-report', function () {

        const ticketId = $(this).data('ticket-id');
        const ticketNumber = $(this).data('ticket-number');
        const fromDate = $(this).data('from-date');
        const toDate = $(this).data('to-date');
        const groupId = $(this).data('group-id');
        const modeId = $(this).data('mode-id');
        const agentId = $(this).data('agent-id');


        $.ajax({
            url: "{{ route('report.winning.report') }}",
            method: "GET",
            data: {
                ticketId, ticketNumber, fromDate, toDate, groupId, modeId, agentId
            },
            beforeSend: function () {
                $(this).prop('disabled', true);
            },
            success: function (response) {

                if (response.status) {

                    let winningAmount = 0;
                    let agentAmount = 0;
                    let total = 0;
                    let tr = '';

                    $.each(response.data, function (index, result) {
                        winningAmount += parseFloat(result.winner_prize || 0);
                        agentAmount += parseFloat(result.a_prize_commission || 0);
                        total = winningAmount + agentAmount;
                        tr += `<tr>
                                <td class="text-nowrap">#${result.bill_id}</td>
                                <td class="text-nowrap">${result.super_agent.username}</td>
                                <td class="text-nowrap">${result.agent.username}</td>
                            <td class="text-nowrap">${result.ticket.short_name} ${result.mode.name} </td>
                            <td class="text-nowrap">${result.number}</td>
                            <td>${result.prize_position}</td>
                            <td>${result.count}</td>
                            <td class="text-nowrap">${result.a_prize_commission}</td>
                            <td class="text-nowrap">${result.winner_prize}</td>
                            </tr>`;
                    });

                    $('#winningReport .modal-body .result').html(`<div class="card">
                                        <div class="card-body">
                                        <div>Total Amount: ₹ ${winningAmount.toFixed(2)}</div>
                                        <div>Total Super: ₹ ${agentAmount.toFixed(2)}</div>
                                        <div class="fw-bold">Grand Total:  ₹ ${total.toFixed(2)}</div>
                                        </div>
                                    </div>`);
                    $('#winningReport table tbody').html(tr);
                    $('#winningReport table').removeClass('d-none');

                    $('#winningUsers').modal('hide');
                    $('#winningReport').modal('show');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $(this).prop('disabled', false);
            }
        });
    });

    function winningUsersBack()
    {
        $('#winningUsers').modal('hide');
        $('#winningSummary').modal('show');
    }

    function winningReportBack()
    {
        $('#winningReport').modal('hide');
        $('#winningUsers').modal('show');
    }

    $('#number_report').on('submit', function (e) {

        e.preventDefault();

        const $form = $(this);
        const ticketId = $form.find('[name="ticket_id"]').val();
        const ticketNumber = $form.find('[name="ticket_number"]').val();
        const resultDate = $form.find('[name="date"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: {
                ticketId,
                ticketNumber,
                resultDate,
                groupId,
                modeId,
                superAgentId,
                agentId
            },
            beforeSend: function () {
                $form.find('button[type="submit"]').prop('disabled', true);
            },
            success: function (response) {
                if (response.status) {

                    let tr = '';
                    let totalCount = 0;

                    if (response.data.length > 0) {

                        let tr = '';
                        let totalCount = 0;
                        $.each(response.data, function (index, result) {
                            totalCount += Number(result.count || 0);
                            tr += ` <tr>
                                    <td>${index + 1}</td>
                                    <td> ${result.ticket_name} ${result.mode_name} </td>
                                    <td>${result.number}</td>
                                    <td>${result.count}</td>
                                </tr> `;
                        });

                        $('#numberReport table #count').text(totalCount);
                        $('#numberReport table tbody').html(tr);
                        $('#numberReport table #downloadPdf')
                        .attr('data-ticket-id', ticketId)
                        .attr('data-ticket-number', ticketNumber)
                        .attr('data-result-date', resultDate)
                        .attr('data-group-id', groupId)
                        .attr('data-mode-id', modeId)
                        .attr('data-super-agent-id', superAgentId)
                        .attr('data-agent-id', agentId);

                        $('#numberReport').modal('show');
                    }
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function () {
                $form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '#downloadPdf', function () {

        const ticketId = $(this).data('ticket-id');
        const ticketNumber = $(this).data('ticket-number');
        const resultDate = $(this).data('result-date');
        const groupId = $(this).data('group-id');
        const modeId = $(this).data('mode-id');
        const superAgentId = $(this).data('super-agent-id');
        const agentId = $(this).data('agent-id');

        $.ajax({
            url: "{{ route('report.number.pdf') }}",
            method: 'GET',
            data: {
                ticketId,
                resultDate,
                ticketNumber,
                groupId,
                modeId,
                superAgentId,
                agentId
            },
            xhrFields: { responseType: 'blob' },
            beforeSend: function () {
                $('#downloadPdf').prop('disabled', true).html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span class="visually-hidden" role="status">Loading...</span>`);
            },
            success: function (blob) {
                let currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `number-wise-${resultDate}--${currentTime}.pdf`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            },
            error: function () {
                console.error('Download failed');
            },
            complete: function () {
                $('#downloadPdf').prop('disabled', false).html(`<i class="bi bi-filetype-pdf"></i>`);
            }
        });
    });

    $('#account_summary').on('submit', function (e) {

        e.preventDefault();

        const $form = $(this);
        const ticketId = $form.find('[name="ticket_id"]').val();
        const fromDate = $form.find('[name="from_date"]').val();
        const toDate = $form.find('[name="to_date"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        generateDates(fromDate, toDate);
        loadAccountSummary(`${fromDate}|${toDate}`, ticketId, groupId, modeId, superAgentId, agentId)
    });

    $(document).on('change', '#dates', function () {
        const $form = $('#account_summary');

        const date = $(this).val();
        const ticketId = $form.find('[name="ticket_id"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        loadAccountSummary(date, ticketId, groupId, modeId, superAgentId, agentId);
    });

    function loadAccountSummary(selectedDate, ticketId, groupId, modeId, superAgentId, agentId) {

      let fromDate = selectedDate;
      let toDate = selectedDate;

      if (selectedDate.includes('|')) {
        const parts = selectedDate.split('|');
        fromDate = parts[0];
        toDate = parts[1];
      }

      $.ajax({
        url: "{{ route('report.account.summary')}}",
        method: 'GET',
        data: {
          ticketId,
          fromDate,
          toDate,
          groupId,
          modeId,
          superAgentId,
          agentId
        },
        beforeSend:function(){
          $('#accountSummary .modal-body .users-table tbody tr').remove();
          $('#accountSummary .modal-body .total-table tbody tr').remove();
        },
        success: function (response) {

          let totalSales = 0;
          let totalPrize = 0;
          let tr = '';

          if (response.status) {

            if (response.data.length > 0) {

              $.each(response.data, function (index, result) {

                const sales = parseFloat(result.rate_total || 0);
                // corrected keys
                const prize = parseFloat(result.winner_prize || 0) + parseFloat(result.agent_prize || 0);
                const balance = sales - prize;
                totalSales += sales;
                totalPrize += prize;
                tr += ` <tr>
                      <td>${result.agent?.username || '-'}</td>
                      <td class="text-center">₹ ${sales.toFixed(2)}</td>
                      <td class="text-center">₹ ${prize.toFixed(2)}</td>
                      <td class="text-center fw-semibold ${balance < 0 ? 'text-danger' : 'text-success'}"> ₹ ${balance.toFixed(2)} </td>
                    </tr> `;
              });
              const totalBalance = totalSales - totalPrize;

              $('#accountSummary .modal-body table').removeClass('d-none');
              $('#accountSummary .modal-body .users-table tbody').html(tr);
              $('#accountSummary .modal-body .total-table tbody').html(`<tr class="table-primary fw-semibold">
                                            <td class="text-center">₹ ${totalSales.toFixed(2)}</td>
                                            <td class="text-center">₹ ${totalPrize.toFixed(2)}</td>
                                            <td class="text-center">₹ ${totalBalance.toFixed(2)}</td>
                                          </tr> `);
            }
            $('#accountSummary').modal('show');
          }
        },
        error: function (xhr) {
          console.error(xhr.responseJSON?.message || 'Something went wrong', 'Error!');
        }
      });
    }

    function generateDates(fdate, tdate) {

        const $dates = $('#accountSummary .modal-body #dates');

        // Clear existing options
        $dates.empty();

        // Create Date objects safely
        const fromDate = new Date(fdate + 'T00:00:00');
        const toDate = new Date(tdate + 'T00:00:00');

        // Always show the selected range first
        $dates.append(`
            <option value="${fdate}|${tdate}" selected>
                ${fdate} To ${tdate}
            </option>
        `);

        let currentDate = new Date(fromDate);

        while (currentDate <= toDate) {

            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');

            const date = `${year}-${month}-${day}`;

            $dates.append(`
                <option value="${date}">
                    ${date}
                </option>
            `);

            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);
        }
    }

    $('#net_pay').on('submit', function (e) {

        e.preventDefault();

        const $form = $(this);
        const ticketId = $form.find('[name="ticket_id"]').val();
        const fromDate = $form.find('[name="from_date"]').val();
        const toDate = $form.find('[name="to_date"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        generateNetDates(fromDate, toDate);
        loadNetPay(`${fromDate}|${toDate}`, ticketId, groupId, modeId, superAgentId, agentId)
    });

    $(document).on('change', '#netDates', function () {
        const $form = $('#account_summary');

        const date = $(this).val();
        const ticketId = $form.find('[name="ticket_id"]').val();
        const groupId = $form.find('[name="group_id"]').val();
        const modeId = $form.find('[name="mode_id"]').val();
        const superAgentId = $form.find('[name="super_agent_id"]').val();
        const agentId = $form.find('[name="agent_id"]').val();

        loadNetPay(date, ticketId, groupId, modeId, superAgentId, agentId);
    });

    function loadNetPay(selectedDate, ticketId, groupId, modeId, superAgentId, agentId) {

        let fromDate = selectedDate;
        let toDate = selectedDate;

        if (selectedDate.includes('|')) {
            const parts = selectedDate.split('|');
            fromDate = parts[0];
            toDate = parts[1];
        }

        $.ajax({
            url: "{{ route('report.net.pay')}}",
            method: 'GET',
            data: {
                ticketId,
                fromDate,
                toDate,
                groupId,
                modeId,
                superAgentId,
                agentId
            },
            beforeSend:function(){
                $('#netPay .modal-body .users-table tbody tr').remove();
                $('#netPay .modal-body .total-table tbody tr').remove();
            },
            success: function (response) {

                let totalSales = 0;
                let totalPrize = 0;
                let tr = '';

                if (response.status) {

                    if (response.data.length > 0) {

                        $.each(response.data, function (index, result) {

                            const sales = parseFloat(result.rate_total || 0);
                            // corrected keys
                            const prize = parseFloat(result.winner_prize || 0) + parseFloat(result.agent_prize || 0);
                            const balance = sales - prize;
                            totalSales += sales;
                            totalPrize += prize;
                            tr += ` <tr>
                                <td>${result.agent?.username || '-'}</td>
                                <td class="text-center">₹ ${sales.toFixed(2)}</td>
                                <td class="text-center">₹ ${prize.toFixed(2)}</td>
                                <td class="text-center fw-semibold ${balance < 0 ? 'text-danger' : 'text-success'}"> ₹ ${balance.toFixed(2)} </td>
                                </tr> `;
                        });

                    const totalBalance = totalSales - totalPrize;

                    $('#netPay .modal-body table').removeClass('d-none');
                    $('#netPay .modal-body .users-table tbody').html(tr);
                    $('#netPay .modal-body .total-table tbody').html(`<tr class="table-primary fw-semibold">
                                                    <td class="text-center">₹ ${totalSales.toFixed(2)}</td>
                                                    <td class="text-center">₹ ${totalPrize.toFixed(2)}</td>
                                                    <td class="text-center">₹ ${totalBalance.toFixed(2)}</td>
                                                </tr> `);
                    }
                    $('#netPay').modal('show');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON?.message || 'Something went wrong', 'Error!');
            }
        });
    }

    function generateNetDates(fdate, tdate) {

        const $dates = $('#netPay .modal-body #netDates');

        // Clear existing options
        $dates.empty();

        // Create Date objects safely
        const fromDate = new Date(fdate + 'T00:00:00');
        const toDate = new Date(tdate + 'T00:00:00');

        // Always show the selected range first
        $dates.append(`
            <option value="${fdate}|${tdate}" selected>
                ${fdate} To ${tdate}
            </option>
        `);

        let currentDate = new Date(fromDate);

        while (currentDate <= toDate) {

            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');

            const date = `${year}-${month}-${day}`;

            $dates.append(`
                <option value="${date}">
                    ${date}
                </option>
            `);

            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);
        }
    }

    </script>
@endsection
