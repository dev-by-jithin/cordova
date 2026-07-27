@extends('layouts.app')

@section('title', 'Numbers')

@section('breadcrumb')
    <!-- <div class="container-fluid px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item active"><span>Users</span></li>
                    </ol>
                </nav>
            </div> -->
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="fw-bold mb-0">Numbers</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('number.index') }}" method="GET">
                        <div class="row mb-1 g-1">
                            <div class="col">
                                <select class="form-select" name="group_id" aria-label="Group">
                                    <option value=" " selected>Select Group</option>
                                    @foreach ($groups as $id => $group )
                                        <option value="{{ $id }}" {{ $id == request('group_id') ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" name="ticket_id" aria-label="Ticket">
                                    <option value=" " selected>Select Ticket</option>
                                    @foreach ($tickets as $id => $ticket )
                                        <option value="{{ $id }}" {{ $id == request('ticket_id') ? 'selected' : '' }}>{{ $ticket }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" name="mode_id" aria-label="Mode">
                                    <option value=" " selected>Select Mode</option>
                                    @foreach ($modes as $id => $mode )
                                        <option value="{{ $id }}" {{ $id == request('mode_id') ? 'selected' : '' }}>{{ $mode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" name="super_agent_id" aria-label="Super Agent">
                                    <option value=" " selected>Select Super Agent</option>
                                    @foreach ($superAgents as $id => $superAgent )
                                        <option value="{{ $id }}" {{ $id == request('super_agent_id') ? 'selected' : '' }}>{{ $superAgent }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" name="agent_id" aria-label="Agent">
                                    <option value=" " selected>Select Agent</option>
                                    @foreach ($agents as $id => $agent )
                                        <option value="{{ $id }}" {{ $id == request('agent_id') ? 'selected' : '' }}>{{ $agent }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                    <input type="date" class="form-control" name="created_at" value="{{ request('created_at') }}"
                                        placeholder="Date" aria-label="Date">
                            </div>
                            <div class="col">
                                    <input type="text" class="form-control" name="bill_no" value="{{ request('bill_no') }}"
                                        placeholder="Bill No.." aria-label="Bill No">
                            </div>
                            <div class="col">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                        placeholder="Search.." aria-label="Search">
                            </div>
                            <div class="col">
                                <button class="btn btn-success" type="submit"><i class="icon cil-search"></i></button>
                                <button class="btn btn-danger" type="button" onclick="window.location.href = '{{ route('number.index') }}'"><i class="icon cil-sync"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Ticket-Name</th>
                                    <th scope="col">Super Agent</th>
                                    <th scope="col">Agent</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Count</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">Collection</th>
                                    <th scope="col">Commission</th>
                                    <th scope="col">Bill No</th>
                                    <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($numbers as $number)
                                    <tr>
                                        <td>{{ $numbers->firstItem() + $loop->index }}</td>
                                        <td>{{ $number->group_id }}</td>
                                        <td>{{ $number->ticket->name }} - {{ $number->mode->name }}</td>
                                        <td>{{ $number->superAgent->username }}</td>
                                        <td>{{ $number->agent->username }}</td>
                                        <td>{{ $number->number }}</td>
                                        <td>{{ $number->count }}</td>
                                        <td>{{ $number->rate }}</td>
                                        <td>{{ $number->collection }}</td>
                                        <td>{{ $number->commission }}</td>
                                        <td>#{{ $number->bill_id }}</td>
                                        <td>{{ $number->created_at->format('d-m-Y h:i:s A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            Numbers not found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                        {{ $numbers->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection
