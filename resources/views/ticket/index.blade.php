@extends('layouts.app')

@section('title', 'Tickets')

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
                    <h5 class="fw-bold mb-0">Tickets</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('ticket.index') }}" method="GET">
                        <div class="input-group mb-1 w-25">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search.." aria-label="Search">
                            <button class="btn btn-secondary btn-sm" type="submit"><i class="icon cil-search"></i></button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Result Time</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Is Active</th>
                                    <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $tickets->firstItem() + $loop->index }}</td>
                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->result_time->format('h:i A') }}</td>
                                    <td>{{ $ticket->sort_order }}</td>
                                    <td><span class="badge rounded-pill text-bg-{{ $ticket->is_active == 'Yes' ? 'success' : 'danger' }}">{{ $ticket->is_active }}</span></td>
                                    <td>{{ $ticket->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No tickets found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                       {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

@endsection
