@extends('layouts.app')

@section('title', 'Profile')

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
                    <h5 class="fw-bold mb-0">Profile</h5>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('profile.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" name="id" value="{{ $user->id }}">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $user->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
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
