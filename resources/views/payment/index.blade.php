@extends('layouts.app')

@section('title', 'Payment')

@section('breadcrumb')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="fw-bold mb-0">Pending Payments</h5>
                </div>
                <div class="card-body pt-2 pb-1">
                    <form action="{{ route('user.index') }}" method="GET">
                        <div class="row mb-1 g-1">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="from_date" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="to_date" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-secondary w-100 h-100" type="submit"><i class="icon cil-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Super Agent</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Scheme</th>
                                    <th scope="col">Login Status</th>
                                    <th scope="col">Sale Status</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        No users found
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>



    <script>

    $(document).ready(function(){
        $('input[type="date"]').each(function () {
            this.valueAsDate = new Date();
        });
    });


    </script>
@endsection
