@extends('layouts.app')

@section('title', 'Prices')

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
                    <h5 class="fw-bold mb-0">Prices</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('price.index') }}" method="GET">
                        <div class="row mb-1 g-1">
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
                                    <th scope="col">Scheme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Winner Amount</th>
                                    <th scope="col">Super Agent Amount</th>
                                    <th scope="col">Agent Amount</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prices as $price)
                                <tr>
                                    <td>{{ $prices->firstItem() + $loop->index }}</td>
                                    <td>{{ $price->scheme->name }}</td>
                                    <td>{{ $price->mode->name }}</td>
                                    <td>{{ $price->position }}</td>
                                    <td>{{ $price->winner_amount }}</td>
                                    <td>{{ $price->super_agent_amount }}</td>
                                    <td>{{ $price->agent_amount }}</td>
                                    <td>{{ $price->created_at->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('price.edit', $price->id) }}" class="btn btn-secondary btn-sm py-0 px-1" title="Edit"><i class="icon cil-pencil"></i></a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No prices found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                       {{ $prices->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

@endsection
