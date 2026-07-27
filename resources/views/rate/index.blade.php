@extends('layouts.app')

@section('title', 'Rates')

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
                    <h5 class="fw-bold mb-0">Rates</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('rate.index') }}" method="GET">
                        <div class="row mb-1 g-1">
                            <div class="col-md-3">
                                <select class="form-select" name="user_id" aria-label="User">
                                    <option value=" " selected>Select User</option>
                                    @foreach ($users as $id => $username )
                                        <option value="{{ $id }}" {{ $id == request('user_id') ? 'selected' : '' }}>{{ $username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                        placeholder="Search.." aria-label="Search">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-secondary" type="submit"><i class="icon cil-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Ticket-Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Ticket Rate</th>
                                    <th scope="col">Commission Rate</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Updated</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rates as $rate)
                                    <tr>
                                        <td>{{ $rates->firstItem() + $loop->index }}</td>
                                        <td>{{ $rate->ticket->name }} - {{ $rate->mode->name }}</td>
                                        <td>{{ $rate->user->username }}</td>
                                        <td>{{ $rate->user->role }}</td>
                                        <td>{{ $rate->ticket_rate }}</td>
                                        <td>{{ $rate->rate }}</td>
                                        <td>{{ $rate->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $rate->updated_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('rate.edit', $rate->id) }}"
                                                class="btn btn-secondary btn-sm py-0 px-1" title="Edit"><i
                                                    class="icon cil-pencil"></i></a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No rates found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                        {{ $rates->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

@endsection
