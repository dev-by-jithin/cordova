@extends('layouts.app')

@section('title', 'Users')

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
                    <h5 class="fw-bold mb-0">Users</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('user.create') }}">Add</a>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('user.index') }}" method="GET">
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
                                    <th scope="col">User Name</th>
                                    <th scope="col">Super Agent</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Scheme</th>
                                    <th scope="col">Login Status</th>
                                    <th scope="col">Sale Status</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr id="row-{{ $user->id }}">
                                    <td>{{ $users->firstItem() + $loop->index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->superAgent?->username ?? '-' }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->scheme->name }}</td>
                                    <td><span class="badge rounded-pill text-bg-{{ $user->login_status == 'Active' ? 'success' : 'danger' }}">{{ $user->login_status }}</span></td>
                                    <td><span class="badge rounded-pill text-bg-{{ $user->sale_status == 'Active' ? 'success' : 'danger' }}">{{ $user->sale_status }}</span></td>
                                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-secondary btn-sm py-0 px-1" title="Edit"><i class="icon cil-pencil"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm p-0 px-1 delete-user" data-id="{{ $user->id }}" data-url="{{ route('user.destroy', $user->id) }}" title="Delete"><i class="icon cil-trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            No users found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                       {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

    <script>
        $(document).on('click', '.delete-user', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {

                if (result.isConfirmed){

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if(response.status == true)
                            {
                                $(`#row-${id}`).remove();

                                Swal.fire({
                                    title: "Deleted!",
                                    text: `${response.message}`,
                                    icon: "success"
                                });
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: `${xhr.responseJSON.message}`
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
