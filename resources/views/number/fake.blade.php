@extends('layouts.app')

@section('title', 'Numbers')

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
                    <h5 class="fw-bold mb-0">Find Fake</h5>
                </div>
                <div class="card-body pt-2 pb-1">

                    <div class="row mb-1 g-1">
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="created_at" placeholder="Date" aria-label="Date">
                        </div>
                        <div class="col">
                            <button class="btn btn-success" type="button" id="find_fake"><i class="icon cil-search"></i> Find Fake</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0" id="fake_table">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Ticket-Name</th>
                                    <th scope="col">Super Agent</th>
                                    <th scope="col">Agent</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Count</th>
                                    <!-- <th scope="col">Rate</th>
                                    <th scope="col">Collection</th>
                                    <th scope="col">Commission</th> -->
                                    <th scope="col">Amount</th>
                                    <th scope="col">Bill No</th>
                                    <th scope="col">Result Time</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="12" class="text-center">
                                        Fake Numbers not found
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
        $(document).on('click', '#find_fake', function(){
            const $btn = $(this);
            let createdAt = $('#created_at').val();
            if(createdAt == ''){
                Swal.fire({
                    icon: "error",
                    title: "Please select date",
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }

            $.ajax({
                url: "{{ route('number.find.fake') }}",
                method: "get",
                data:{createdAt},
                beforeSend:function(){
                    $btn.prop('disabled', true);
                },
                success:function(response){

                    let tr = '';

                    if(response.length > 0){

                        $.each(response, function(index, number){
                            tr += `<tr>
                                    <td class="s-no">${index+1}</td>
                                    <td>${number.group_id}</td>
                                    <td>${number.ticket.name} - ${number.mode.name}</td>
                                    <td>${number.super_agent.username}</td>
                                    <td>${number.agent.username}</td>
                                    <td>${number.number}</td>
                                    <td>${number.count}</td>
                                    <td>
                                        Rate:${number.rate}<br>
                                        Collection:${number.collection}<br>
                                        Commission:${number.commission}
                                    </td>
                                    <td>${number.bill_id}</td>
                                    <td>${number.ticket.result_time}</td>
                                    <td>${number.created}</td>
                                    <td><button class="btn btn-danger btn-sm delete" data-id="${number.id}" title="Delete"><i class="icon cil-trash"></i></button></td>
                                </tr>`;
                        });

                    }else{
                        tr =`<tr>
                                <td colspan="12" class="text-center">
                                    Fake Numbers not found on <strong>${createdAt}</strong>
                                </td>
                            </tr>`;
                    }

                    $('#fake_table tbody').html(tr);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: xhr.responseJSON?.message || "Something went wrong",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                complete: function () {
                    $btn.prop('disabled', false);
                }
            });

        });

        $(document).on('click', '.delete', function(){
            let $btn = $(this);
            let id = $btn.data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this number!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                if (result.isConfirmed){

                    $.ajax({
                        url: "{{ route('fake.delete') }}",
                        method: "delete",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function(){
                            $btn.prop('disabled', true);
                        },
                        success: function(response){
                            if(response.status){
                                Swal.fire({
                                    title: "Deleted!",
                                    text: `${response.message}`,
                                    icon: "success"
                                });
                                $btn.closest('tr').remove();
                                generateSno();
                            }
                        },
                        error:function(xhr){
                            Swal.fire({
                                icon: "error",
                                title: xhr.responseJSON?.message || "Something went wrong",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        complete:function(){
                            $btn.prop('disabled', false);
                        }
                    });
                };
            });


        });

        function generateSno()
        {
            let i = 1;
            $('#fake_table tbody tr').each(function () {
                $(this).find('.s-no').text(i++);
            });
        }
    </script>
@endsection
