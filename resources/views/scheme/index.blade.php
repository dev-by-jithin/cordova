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
                                            <button data-id="{{ $scheme->id }}"
                                                class="btn btn-secondary btn-sm py-0 px-1 view-scheme" title="View"><i
                                                    class="icon cil-zoom-in"></i></button>
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




<!-- Modal -->
<div class="modal fade" id="schemeDetailsModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#f8f8f9;">
        <h5 class="modal-title" id="schemeName"></h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2" id="tables">

        </div>
      </div>
    </div>
  </div>
</div>


    <script>


        $(document).on('click', '.view-scheme', function(){

            let button = $(this);
            let id = button.data('id');

            $.ajax({
                url: "{{ route('scheme.show') }}",
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                beforeSend: function () {
                    button.prop('disabled', true);
                },
                success: function (response) {

                    if(response){
                        $('#schemeName').text(response.scheme.name);
                        let table = '';

                        $.each(response.prices, function(key, mode){
                            let tr = '';
                            $.each(mode, function(index, price){
                                tr += `<tr>
                                        <td>${price.position}</td>
                                        <td>${price.count}</td>
                                        <td>${price.winnerAmount}</td>
                                        <td>${price.superAgentAmount}</td>
                                    </tr>`;
                            })
                            const [modeName, groupName] = key.split('@');
                            table += `<div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title">${modeName}</h5>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">${groupName}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-0 text-center">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Position</th>
                                                                <th scope="col">Count</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Super</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ${tr}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`

                        });
                        $('#tables').html(table);
                    }

                    $('#schemeDetailsModal').modal('show');

                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: xhr.responseJSON?.message ?? "Something went wrong."
                    });
                },
                complete: function () {
                    button.prop('disabled', false);
                }
            });

        });

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
