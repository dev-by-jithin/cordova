@extends('layouts.app')

@section('title', 'Report')

@section('breadcrumb')
    <!-- <div class="container-fluid px-4">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb my-0">
                                            <li class="breadcrumb-item active"><span>Dashboard</span></li>
                                        </ol>
                                    </nav>
                                </div> -->
@endsection

@section('content')

    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="sales-tab" data-coreui-toggle="tab" data-coreui-target="#sales"
                type="button" role="tab" aria-controls="home" aria-selected="true">Sales Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="winning-tab" data-coreui-toggle="tab" data-coreui-target="#winning" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Winning Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="number-wise-tab" data-coreui-toggle="tab" data-coreui-target="#number-wise"
                type="button" role="tab" aria-controls="number-wise" aria-selected="false">Number Wise Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="account-tab" data-coreui-toggle="tab" data-coreui-target="#account" type="button"
                role="tab" aria-controls="account" aria-selected="false">A/c Summary Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="net-pay-tab" data-coreui-toggle="tab" data-coreui-target="#net-pay" type="button"
                role="tab" aria-controls="net-pay" aria-selected="false">Net Pay Report</button>
        </li>
    </ul>
    <div class="tab-content mb-2" id="myTabContent">

        <div class="tab-pane fade show active bg-white border border-top-0" id="sales" role="tabpanel"
            aria-labelledby="sales-tab" tabindex="0">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.sales.summary') }}" method="GET" id="sales_summary" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticketId">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="ticketNumber" placeholder="Ticket Number">
                                    <label for="ticketNumber">Ticket Numer</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="fromDate" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="toDate" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="GroupId">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="modeId">
                                        <option selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent" name="agent_id">
                                        <option selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="winning" role="tabpanel" aria-labelledby="winning-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.winning.summary') }}" method="post" id="winning_summary" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticketId">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="ticketNumber" placeholder="Ticket Number">
                                    <label for="ticketNumber">Ticket Numer</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="fromDate" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="toDate" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="GroupId">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="modeId">
                                        <option selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent" name="agent_id">
                                        <option selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="number-wise" role="tabpanel"
            aria-labelledby="number-wise-tab" tabindex="2">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.number.wise') }}" method="post" id="number_wise" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticketId">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="ticketNumber" placeholder="Ticket Number">
                                    <label for="ticketNumber">Ticket Numer</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="date" placeholder="">
                                    <label for="date">Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="GroupId">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="modeId">
                                        <option selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent" name="agent_id">
                                        <option selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-check mt-4 ms-4">
                                    <input class="form-check-input" type="checkbox" value="" id="column">
                                    <label class="form-check-label" for="column">
                                        Group without ticket name
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="account" role="tabpanel" aria-labelledby="account-tab"
            tabindex="3">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.account.summary') }}" method="post" id="account_summary" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticketId">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="fromDate" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="toDate" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="GroupId">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="modeId">
                                        <option selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent" name="agent_id">
                                        <option selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="net-pay" role="tabpanel" aria-labelledby="net-pay-tab"
            tabindex="4">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form action="{{ route('report.net.pay') }}" method="post" id="net_pay" autocomplete="off">
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="ticketId">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticketId">Ticket</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="fromDate" placeholder="">
                                    <label for="fromDate">From Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="toDate" placeholder="">
                                    <label for="toDate">To Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="GroupId">
                                        <option value="" selected>Group</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="GroupId">Group</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select" name="modeId">
                                        <option selected>Mode</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modeId">Mode</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select super-agent" name="super_agent_id">
                                        <option selected>Super Agent</option>
                                        @foreach ($superAgents as $superAgent)
                                            <option value="{{ $superAgent->id }}">{{ $superAgent->username }}</option>
                                        @endforeach
                                    </select>
                                    <label for="super_agent_id">Super Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select agent" name="agent_id">
                                        <option selected>Agent</option>
                                    </select>
                                    <label for="agent_id">Agent</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100"><i class="icon cil-description me-1"></i> Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>

        $('#sales_summary').on('submit', function (e) {

            e.preventDefault();

            const $form = $(this);

            $.ajax({
                url: $form.attr('action'),
                method: $form.attr('method'),
                data: $form.serialize(),

                beforeSend: function () {
                    $form.find('button[type="submit"]').prop('disabled', true);
                },

                success: function (response) {
                    console.log(response);
                },

                error: function (xhr) {
                    console.error(
                        xhr.responseJSON?.message || 'Something went wrong'
                    );
                },

                complete: function () {
                    $form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        });

//         apiRequest({
//       url: `${API}/sales-summary`,
//       method: 'get',
//       data: { ticketId,
//               fromDate,
//               toDate,
//               ticketNumber,
//               groupId,
//               modeId,
//               agentId
//             },
//       success: function (response) {
//         let dates = '';
//         let totalCount = 0;
//         let totalAmount = 0;

//         if (response.status) {

//           $.each(response.data, function (index, result) {

//             totalCount += Number(result.total_count || 0);
//             totalAmount += parseFloat(result.total_amount || 0);

//             const detailUrl = `sales-users.html?` + `ticket_id=${encodeURIComponent(ticketId || '')}&`
//                             + `ticket_number=${encodeURIComponent(ticketNumber || '')}&`
//                             + `group_id=${encodeURIComponent(groupId || '')}&`
//                             + `mode_id=${encodeURIComponent(modeId || '')}&`
//                             + `agent_id=${encodeURIComponent(agentId || '')}&`
//                             + `sale_date=${encodeURIComponent(result.sale_date)}`;

//             dates += ` <div class="card shadow-sm mt-2">
//                         <div class="card-body text-center">
//                           <div class="fw-bold mb-1">${result.sale_date}</div>
//                             <div class="mb-1"> Sales Amount : ₹ ${parseFloat(result.total_amount || 0).toFixed(2)} </div>
//                             <div class="mb-1"> Count : ${result.total_count} </div>
//                             <button class="btn btn-primary btn-sm shadow mt-1" onclick="window.location.href='${detailUrl}'"> View Details </button>
//                         </div>
//                       </div> `;
//           });

//           $('#result').html(` <div class="card shadow-sm">
//                                 <div class="card-body">
//                                   <div class="row text-center">
//                                     <div class="col border-end">
//                                       <div class="fw-bold">Total Count</div> ${totalCount}
//                                     </div>
//                                     <div class="col">
//                                       <div class="fw-bold">Total Amount</div> ₹ ${totalAmount.toFixed(2)}
//                                     </div>
//                                   </div>
//                                 </div>
//                               </div>
//                               ${dates}`
//                             );
//           }
//       },
//       error: function (xhr) {
//         toastr.error( xhr.responseJSON?.message || 'Something went wrong', 'Error!' );
//       }
//   });
    </script>
@endsection
