@extends('layouts.app')

@section('title', 'Prizes')

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
                    <h5 class="fw-bold mb-0">Prizes</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('prize.index') }}" method="GET">
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
                                    <th scope="col">Mode</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Prize Amount</th>
                                    <th scope="col">Agent Commission</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prizes as $prize)
                                <tr>
                                    <td>{{ $prizes->firstItem() + $loop->index }}</td>
                                    <td>{{ $prize->mode->name }}</td>
                                    <td>{{ $prize->position }}</td>
                                    <td>{{ $prize->prize }}</td>
                                    <td>{{ $prize->agent_commission }}</td>
                                    <td>{{ $prize->created_at->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('prize.edit', $prize->id) }}" class="btn btn-secondary btn-sm py-0 px-1" title="Edit"><i class="icon cil-pencil"></i></a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No prizes found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                       {{ $prizes->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

@endsection
