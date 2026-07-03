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
                    <h5 class="fw-bold mb-0">Edit Price</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('price.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('price.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" name="id" value="{{ $price->id }}">
                        <div class="col-md-6">
                            <label for="scheme_id" class="form-label">Scheme</label>
                            <select id="scheme_id" name="scheme_id" class="form-select" disabled>
                                @foreach($schemes as $id => $scheme)
                                    <option value="{{ $id }}" {{ $id == $price->scheme_id ? 'selected' : '' }}>{{ $scheme }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="mode" class="form-label">Mode</label>
                            <select id="mode" name="mode_id" class="form-select" disabled>
                                @foreach($modes as $id => $mode)
                                    <option value="{{ $id }}" {{ $id == $price->mode_id ? 'selected' : '' }}>{{ $mode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position"
                                value="{{ $price->position }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="count" class="form-label">Count *</label>
                            <input type="text" class="form-control" id="count" name="count" value="{{ $price->count }}"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="winner_amount" class="form-label">Winner Amount *</label>
                            <input type="text" class="form-control @error('winner_amount') is-invalid @enderror"
                                id="winner_amount" name="winner_amount" value="{{ $price->winner_amount }}">
                            @error('winner_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="super_agent_amount" class="form-label">Super Agent Amount *</label>
                            <input type="text" class="form-control @error('super_agent_amount') is-invalid @enderror"
                                id="super_agent_amount" name="super_agent_amount" value="{{ $price->super_agent_amount }}">
                            @error('super_agent_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="agent_amount" class="form-label">Agent Amount *</label>
                            <input type="text" class="form-control @error('agent_amount') is-invalid @enderror"
                                id="agent_amount" name="agent_amount" value="{{ $price->agent_amount }}">
                            @error('agent_amount')
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
