@extends('layouts.app')

@section('title', 'Groups')

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
                    <h5 class="fw-bold mb-0">Groups</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('group.index') }}" method="GET">
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Is Active</th>
                                    <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groups as $group)
                                <tr>
                                    <td>{{ $groups->firstItem() + $loop->index }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td><span class="badge rounded-pill text-bg-{{ $group->is_active == 'Yes' ? 'success' : 'danger' }}">{{ $group->is_active }}</span></td>
                                    <td>{{ $group->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No groups found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                       {{ $groups->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

@endsection
