@extends('layouts.app')

@section('title', 'Edit Price')

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
                    <h5 class="fw-bold mb-0">Edit Prize</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('prize.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('prize.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" name="id" value="{{ $prize->id }}">

                        <div class="col-md-6">
                            <label for="mode" class="form-label">Mode</label>
                            <select id="mode" name="mode_id" class="form-select" disabled>
                                @foreach($modes as $id => $mode)
                                    <option value="{{ $id }}" {{ $id == $prize->mode_id ? 'selected' : '' }}>{{ $mode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position"
                                value="{{ $prize->position }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="count" class="form-label">Count *</label>
                            <input type="text" class="form-control" id="count" name="count" value="{{ $prize->count }}"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="prize" class="form-label">Prize *</label>
                            <input type="text" class="form-control @error('prize') is-invalid @enderror"
                                id="prize" name="prize" value="{{ $prize->prize }}">
                            @error('prize')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="agent_commission" class="form-label">Agent Commission *</label>
                            <input type="text" class="form-control @error('agent_commission') is-invalid @enderror"
                                id="agent_commission" name="agent_commission" value="{{ $prize->agent_commission }}">
                            @error('agent_commission')
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
