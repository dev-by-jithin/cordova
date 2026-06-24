@extends('layouts.app')

@section('title', 'Edit Scheme')

@section('breadcrumb')
    <!-- <div class="container-fluid px-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb my-0">
                                <li class="breadcrumb-item"><span>Users</span></li>
                                <li class="breadcrumb-item active"><span>Create</span></li>
                            </ol>
                        </nav>
                    </div> -->
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="fw-bold mb-0">Edit Scheme</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('scheme.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('scheme.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" name="id" value="{{ $scheme->id }}">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $scheme->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
<script>
    $(document).on('change', '#role', function(){

        if($(this).val() === 'Agent'){
            $('.super-agent').removeClass('d-none');
        }else{
            $('.super-agent').addClass('d-none');
        }

    });
</script>
@endsection
