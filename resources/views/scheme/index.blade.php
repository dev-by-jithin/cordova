@extends('layouts.app')

@section('title', 'Scheme')

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
                    <h5 class="fw-bold mb-0">Schemes</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('scheme.create') }}">Add</a>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('scheme.index') }}" method="GET">

                        <div class="input-group mb-1 w-25">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                placeholder="Search.." aria-label="Search">
                            <button class="btn btn-secondary btn-sm" type="submit"><i class="icon cil-search"></i></button>
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schemes as $scheme)
                                    <tr id="row-{{ $scheme->id }}">
                                        <td>{{ $schemes->firstItem() + $loop->index }}</td>
                                        <td>{{ $scheme->name }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input is-active" data-id="{{ $scheme->id }}"
                                                    type="checkbox" role="switch" id="switch-{{ $scheme->id }}" {{ $scheme->is_active == 'Yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="-{{ $scheme->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $scheme->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('scheme.edit', $scheme->id) }}"
                                                class="btn btn-secondary btn-sm py-0 px-1" title="Edit"><i
                                                    class="icon cil-pencil"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No schemes found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-1">
                        {{ $schemes->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

    <script>
        $(document).on('change', '.is-active', function () {

            let toggle = $(this);
            let id = toggle.data('id');
            let previousState = !toggle.is(':checked');

            $.ajax({
                url: "{{ route('scheme.status') }}",
                type: "PUT",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    isActive: toggle.is(':checked') ? 'Yes' : 'No'
                },

                beforeSend: function () {
                    // Prevent multiple clicks
                    toggle.prop('disabled', true);
                },

                success: function (response) {

                    if (!response.status) {

                        toggle.prop('checked', false);

                        Swal.fire({
                            icon: "error",
                            title: "Failed",
                            text: response.message
                        });
                    } else {
                        toggle.prop('checked', true);
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message
                        });
                    }
                },

                error: function (xhr) {

                    toggle.prop('checked', previousState);

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: xhr.responseJSON?.message ?? "Something went wrong."
                    });
                },

                complete: function () {
                    // Re-enable after request finishes
                    toggle.prop('disabled', false);
                }
            });

        });
    </script>

@endsection
