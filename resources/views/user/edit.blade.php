@extends('layouts.app')

@section('title', 'Users')

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
                    <h5 class="fw-bold mb-0">Edit User</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('user.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('user.update') }}" method="POST" autocomplete="off">
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
                            <label for="username" class="form-label">User Name *</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" value="{{ $user->username }}">
                            @error('username')
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
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="Super Agent" {{ $user->role == 'Super Agent' ? 'selected' : '' }}>Super Agent
                                </option>
                                <option value="Agent" {{ $user->role == 'Agent' ? 'selected' : '' }}>Agent</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 super-agent {{ $user->role === 'Agent' ? '' : 'd-none' }}">
                            <label for="super_agent" class="form-label">Super Agent</label>
                            <select id="super_agent" name="super_agent" class="form-select @error('super_agent') is-invalid @enderror">
                                <option value="" selected>Select Super Agent</option>
                                 @foreach($superAgents as $id => $username)
                                    <option value="{{ $id }}" {{ $id == $user->super_agent_id ? 'selected' : '' }}>{{ $username }}</option>
                                @endforeach
                            </select>
                            @error('super_agent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Is Active</label>
                            <select id="is_active" name="is_active"
                                class="form-select @error('is_active') is-invalid @enderror">
                                <option value="Yes" {{ $user->is_active == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $user->is_active == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" placeholder="Description">{{ $user->description }}</textarea>
                            @error('description')
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
