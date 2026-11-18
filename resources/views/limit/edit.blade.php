@extends('layouts.app')

@section('title', 'Edit Limit')

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
                    <h5 class="fw-bold mb-0">Edit Limit</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('limit.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('limit.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" name="id" value="{{ $limit->id }}">

                        <div class="col-md-6">
                            <label for="position" class="form-label">Mode</label>
                            <input type="text" class="form-control" value="{{ $mode->name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="limit" class="form-label">Limit *</label>
                            <input type="text" class="form-control @error('limit') is-invalid @enderror" id="limit" name="limit" value="{{ $limit->limit }}">
                            @error('limit')
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
@endsection
