@extends('layouts.app')

@section('title', 'Payment')

@section('breadcrumb')

@endsection

@section('content')

    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="payment-tab" data-coreui-toggle="tab" data-coreui-target="#payment"
                type="button" role="tab" aria-controls="home" aria-selected="true">Pending Payment</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="history-tab" data-coreui-toggle="tab" data-coreui-target="#history" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Payment History</button>
        </li>

    </ul>
    <div class="tab-content mb-2" id="myTabContent">

        <div class="tab-pane fade show active bg-white border border-top-0" id="payment" role="tabpanel"
            aria-labelledby="result-tab" tabindex="0">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('payment.pending') }}" method="GET" id="pendingPayment">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="from_date" id="from_date"
                                        placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                                <div class="invalid-feedback from_date_error"></div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="to_date" id="to_date" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                                <div class="invalid-feedback to_date_error"></div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id" id="super_agent_id">
                                        <option value="" selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                    <div class="invalid-feedback super_agent_id_error"></div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-secondary w-100 h-100" type="submit" id="search"><i
                                        class="icon cil-search"></i></button>
                            </div>
                        </div>
                    </form>


                    <div class="row mt-3 d-none net">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" id="sale" placeholder="Sales">
                                <label for="sale">Sales</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" id="winning" placeholder="Winning">
                                <label for="winning">Winning</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" id="commission" placeholder="commission">
                                <label for="commission">Commission</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" id="net" placeholder="Net Amount">
                                <label for="net">Net Amount</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100 h-100" type="button" id="settled">Settled</button>
                        </div>
                    </div>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered table-sm mb-0 pending-table">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Super Agent</th>
                                    <th scope="col">Agent</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Count</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Winning</th>
                                    <th scope="col">Agent Commission</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        Pending payments not found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade bg-white border border-top-0" id="history" role="tabpanel" aria-labelledby="history-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body pb-2">
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered table-sm mb-0 pending-table">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">From Date</th>
                                    <th scope="col">To Date</th>
                                    <th scope="col">Super Agent</th>
                                    <th scope="col">Sale</th>
                                    <th scope="col">Winning</th>
                                    <th scope="col">Commission</th>
                                    <th scope="col">Settled Amount</th>
                                    <th scope="col">Settled Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payments->firstItem() + $loop->index }}</td>
                                    <td>{{ $payment->from_date }}</td>
                                    <td>{{ $payment->to_date }}</td>
                                    <td>{{ $payment->superAgent->username }}</td>
                                    <td>{{ $payment->sale }}</td>
                                    <td>{{ $payment->winning }}</td>
                                    <td>{{ $payment->commission }}</td>
                                    <td>{{ $payment->net }}</td>
                                    <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm p-0 px-1 details" data-id="{{ $payment->id }}" >Details</button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            Pending history not found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-1">
                       {{ $payments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $('input[type="date"]').each(function () {
                this.valueAsDate = new Date();
            });

            $('#pendingPayment').on('submit', function (e) {
                e.preventDefault();

                const $form = $(this);
                const url = $form.attr('action');
                const method = ($form.attr('method') || 'GET').toUpperCase();
                const data = $form.serialize();

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    beforeSend: function () {
                        $('#search')
                            .prop('disabled', true)
                            .html(`
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                <span class="visually-hidden" role="status">Loading...</span>
                            `);
                        $form.find("div.invalid-feedback").text("");
                        $form.find("input.is-invalid").removeClass("is-invalid");
                    },

                    success: function (response) {
                        console.log(response);
                        let tr = ``;
                        let sale = 0;
                        let winning = 0;
                        let commission = 0;

                        if (response.status && response.data.length > 0) {
                            $.each(response.data, function (index, row) {

                                sale += Number(row.sa_rate);
                                winning += Number(row.winner_prize);
                                commission += Number(row.a_prize_commission);

                                tr += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${row.super_agent.username}</td>
                                        <td>${row.agent.username}</td>
                                        <td>${row.number}</td>
                                        <td>${row.count}</td>
                                        <td>${row.prize_position}</td>
                                        <td>${row.sa_rate}</td>
                                        <td>${row.winner_prize}</td>
                                        <td>${row.a_prize_commission}</td>
                                    </tr>`
                            });
                            $('.net').removeClass('d-none');
                            let net = sale - (winning + commission);
                            $('#sale').val(sale.toFixed(2));
                            $('#winning').val(winning.toFixed(2));
                            $('#commission').val(commission.toFixed(2));
                            $('#net').val(net.toFixed(2));
                        } else {
                            $('.net').addClass('d-none');
                            tr = `<tr>
                                        <td colspan="9" class="text-center">
                                            Pending payments not found.
                                        </td>
                                    </tr>`;
                        }

                        $('.pending-table tbody').html(tr);
                    },
                    error: function (xhr) {

                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function (field, messages) {
                                $("#" + field).addClass("is-invalid");
                                $("." + field + "_error").text(messages);
                            });
                        }
                        console.error(
                            xhr.responseJSON?.message || 'Something went wrong'
                        );
                    },
                    complete: function () {
                        $('#search')
                            .prop('disabled', false)
                            .html(`<i class="icon cil-search"></i>`);
                    }
                });
            });

            $('#settled').on('click', function (e) {

                let from_date = $('#from_date').val();
                let to_date = $('#to_date').val();
                let super_agent_id = $('#super_agent_id').val();
                let sale = $('#sale').val();
                let winning = $('#winning').val();
                let commission = $('#commission').val();
                let net = $('#net').val();

                $.ajax({
                    url: "{{ route('payment.settled') }}",
                    method: "POST",
                    data: {
                        from_date,
                        to_date,
                        super_agent_id,
                        sale,
                        winning,
                        commission,
                        net,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#settled')
                            .prop('disabled', true)
                            .html(`
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                <span class="visually-hidden" role="status">Loading...</span>
                            `);
                    },

                    success: function (response) {

                        if (response.status) {
                            $('.pending-table tbody').html(`<tr><td colspan="9">${response.message}</td><tr>`);
                        }
                    },
                    error: function (xhr) {

                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function (field, messages) {
                                $("#" + field).addClass("is-invalid");
                                $("." + field + "_error").text(messages);
                            });
                        }
                        console.error(
                            xhr.responseJSON?.message || 'Something went wrong'
                        );
                    },
                    complete: function () {
                        $('#settled')
                            .prop('disabled', false)
                            .text(`Settled`);
                    }
                });
            });
        });


    </script>
@endsection
