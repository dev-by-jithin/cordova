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
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-select form-select-md" name="scheme" aria-label="Scheme">
                                    <option selected>Select Scheme</option>
                                    @foreach ($schemes as $id => $scheme )
                                        <option value="{{ $id }}" {{ $id == request('scheme') ? 'selected' : '' }}>{{ $scheme }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                        placeholder="Search.." aria-label="Search">
                                    <button class="btn btn-secondary btn-sm" type="submit"><i class="icon cil-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Scheme</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">Admin Commission</th>
                                    <th scope="col">Super Agent Commission</th>
                                    <th scope="col">Agent Commission</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rates as $rate)
                                    <tr>
                                        <td>{{ $rates->firstItem() + $loop->index }}</td>
                                        <td>{{ $rate->ticket->name }} - {{ $rate->mode->name }}</td>
                                        <td>{{ $rate->scheme->name }}</td>
                                        <td>{{ $rate->rate }}</td>
                                        <td>{{ $rate->admin_amount }}</td>
                                        <td>{{ $rate->super_agent_amount }}</td>
                                        <td>{{ $rate->agent_amount }}</td>
                                        <td>{{ $rate->created_at->format('d-m-Y') }}</td>
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
