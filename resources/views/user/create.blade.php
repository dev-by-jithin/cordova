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
                    <h5 class="fw-bold mb-0">Create User</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('user.index') }}">Back</a>
                </div>
                <div class="card-body pt-3 pb-2">

                    <form class="row g-3" action="{{ route('user.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">User Name *</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="Super Agent" selected>Super Agent</option>
                                <option value="Agent">Agent</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 super-agent d-none">
                            <label for="super_agent" class="form-label">Super Agent</label>
                            <select id="super_agent" name="super_agent" class="form-select @error('super_agent') is-invalid @enderror">
                                <option value="" selected>Select Super Agent</option>
                                 @foreach($superAgents as $id => $username)
                                    <option value="{{ $id }}">{{ $username }}</option>
                                @endforeach
                            </select>
                            @error('super_agent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="scheme_id" class="form-label">Scheme</label>
                            <select id="scheme_id" name="scheme_id" class="form-select @error('scheme_id') is-invalid @enderror">
                                <option value="" selected>Select Scheme</option>
                                @foreach ($schemes as $id => $scheme)
                                    <option value="{{ $id }}">{{ $scheme }}</option>
                                @endforeach
                            </select>
                            @error('scheme_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="login_status" class="form-label">Login Status</label>
                            <select id="login_status" name="login_status"
                                class="form-select @error('login_status') is-invalid @enderror">
                                <option value="Active" selected>Active</option>
                                <option value="Blocked">Blocked</option>
                            </select>
                            @error('login_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sale_status" class="form-label">Sale Status</label>
                            <select id="sale_status" name="sale_status"
                                class="form-select @error('sale_status') is-invalid @enderror">
                                <option value="Active" selected>Active</option>
                                <option value="Blocked">Blocked</option>
                            </select>
                            @error('sale_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" placeholder="Description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save</button>
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
