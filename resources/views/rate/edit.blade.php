@extends('layouts.app')

@section('title', 'Edit Rate')

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
                    <h5 class="fw-bold mb-0">Edit Rate</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('rate.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('rate.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" name="id" value="{{ $rate->id }}">
                        <div class="col-md-6">
                            <label for="ticket" class="form-label">Ticket</label>
                            <input type="text" class="form-control" id="ticket" name="ticket"
                                value="{{ $rate->ticket->name }} - {{ $rate->mode->name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="scheme" class="form-label">Scheme</label>
                            <input type="text" class="form-control" id="scheme" name="scheme" value="{{ $rate->scheme->name }}"
                                disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="rate" class="form-label">Rate *</label>
                            <input type="text" class="form-control @error('rate') is-invalid @enderror" id="rate"
                                name="rate" value="{{ $rate->rate }}">
                            @error('rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="badge text-bg-secondary" style="margin-top:2.5rem">=</span>
                        </div>
                        <div class="col-md-2">
                            <label for="admin_amount" class="form-label text-primary">Admin Amount *</label>
                            <input type="text" class="form-control @error('admin_amount') is-invalid @enderror"
                                id="admin_amount" name="admin_amount" value="{{ $rate->admin_amount }}">
                            @error('admin_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-1 text-center">
                            <span class="badge text-bg-secondary" style="margin-top:2.5rem">+</span>
                        </div>
                        <div class="col-md-2">
                            <label for="super_agent_amount" class="form-label text-primary">Super Agent Amount *</label>
                            <input type="text" class="form-control @error('super_agent_amount') is-invalid @enderror"
                                id="super_agent_amount" name="super_agent_amount" value="{{ $rate->super_agent_amount }}">
                            @error('super_agent_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-1 text-center">
                            <span class="badge text-bg-secondary" style="margin-top:2.5rem">+</span>
                        </div>
                        <div class="col-md-2">
                            <label for="agent_amount" class="form-label text-primary">Agent Amount *</label>
                            <input type="text" class="form-control @error('agent_amount') is-invalid @enderror"
                                id="agent_amount" name="agent_amount" value="{{ $rate->agent_amount }}">
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
