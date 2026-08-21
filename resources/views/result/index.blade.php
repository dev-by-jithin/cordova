@extends('layouts.app')

@section('title', 'Result')

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
            <button class="nav-link fw-bold active" id="result-tab" data-coreui-toggle="tab" data-coreui-target="#result"
                type="button" role="tab" aria-controls="home" aria-selected="true">Result Publish</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="history-tab" data-coreui-toggle="tab" data-coreui-target="#history" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Result History</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="cancel-tab" data-coreui-toggle="tab" data-coreui-target="#cancel" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Result Cancel</button>
        </li>
    </ul>
    <div class="tab-content mb-2" id="myTabContent">

        <div class="tab-pane fade show active bg-white border border-top-0" id="result" role="tabpanel"
            aria-labelledby="result-tab" tabindex="0">
            <div class="card border border-0 rounded-0">
                <div class="card-body">
                    <form id="resultForm" action="{{ route('result.publish') }}" method="POST" autocomplete="off">
                        <div class="row g-2 g-md-auto">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="ticket_id" name="ticket_id">
                                        <option value="" selected>All</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="ticket_id">Ticket</label>
                                    <div class="invalid-feedback error-ticket_id"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="result_date" name="result_date">
                                    <label for="floatingInput">Date</label>
                                    <div class="invalid-feedback error-result_date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 g-1 gx-md-4">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="super_position_1" name="super_position_1">
                                    <label for="super_position_1">Super Position 1</label>
                                    <div class="invalid-feedback error-super_position_1"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="super_position_2" name="super_position_2">
                                    <label for="super_position_2">Super Position 2</label>
                                    <div class="invalid-feedback error-super_position_2"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="super_position_3" name="super_position_3">
                                    <label for="super_position_3">Super Position 3</label>
                                    <div class="invalid-feedback error-super_position_3"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="super_position_4" name="super_position_4">
                                    <label for="super_position_4">Super Position 4</label>
                                    <div class="invalid-feedback error-super_position_4"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="super_position_5" name="super_position_5">
                                    <label for="super_position_5">Super Position 5</label>
                                    <div class="invalid-feedback error-super_position_5"></div>
                                </div>
                            </div>
                        </div>

                        <h3 class="mt-3">Encouragement Prizes</h3>
                        <div class="row g-1">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_1"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_1">1</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_2"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_2">2</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_3"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_3">3</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_4"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_4">4</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_5"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_5">5</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_6"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_6">6</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_7"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_7">7</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_8"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_8">8</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_9"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_9">9</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_10"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_10">10</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_11"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_11">11</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_12"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_12">12</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_13"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_13">13</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_14"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_14">14</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_15"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_15">15</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-1 mt-1">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_16"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_16">16</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_17"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_17">17</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_18"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_18">18</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_19"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_19">19</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_20"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_20">20</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_21"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_21">21</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_22"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_22">22</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_23"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_23">23</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_24"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_24">24</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_25"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_25">25</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_26"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_26">26</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_27"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_27">27</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_28"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_28">28</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_29"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_29">29</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="encouragement_prize_30"
                                        name="encouragement_prizes[]">
                                    <label for="encouragement_prize_30">30</label>
                                </div>
                            </div>

                            <div class="invalid-feedback d-block error-encouragement_prizes"></div>
                        </div>

                        <div class="row mt-3 g-1 gx-md-4">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="box_position_1" name="box_position_1">
                                    <label for="box_position_1">Box Position 1</label>
                                    <div class="invalid-feedback error-box_position_1"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="box_position_2" name="box_position_2">
                                    <label for="box_position_2">Box Position 2</label>
                                    <div class="invalid-feedback error-box_position_2"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="box_position_3" name="box_position_3">
                                    <label for="box_position_3">Box Position 3</label>
                                    <div class="invalid-feedback error-box_position_3"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="box_position_4" name="box_position_4">
                                    <label for="box_position_4">Box Position 4</label>
                                    <div class="invalid-feedback error-box_position_4"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="box_position_5" name="box_position_5">
                                    <label for="box_position_5">Box Position 5</label>
                                    <div class="invalid-feedback error-box_position_5"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="box_position_6" name="box_position_6">
                                    <label for="box_position_6">Box Position 6</label>
                                    <div class="invalid-feedback error-box_position_6"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 g-1 gx-md-4">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="ab" name="ab">
                                    <label for="ab">AB</label>
                                    <div class="invalid-feedback error-ab"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="bc" name="bc">
                                    <label for="bc">BC</label>
                                    <div class="invalid-feedback error-bc"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="ac" name="ac">
                                    <label for="ac">AC</label>
                                    <div class="invalid-feedback error-ac"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="a" name="a">
                                    <label for="a">A</label>
                                    <div class="invalid-feedback error-a"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="b" name="b">
                                    <label for="b">B</label>
                                    <div class="invalid-feedback error-b"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="c" name="c">
                                    <label for="c">C</label>
                                    <div class="invalid-feedback error-c"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="tab-pane fade bg-white border border-top-0" id="history" role="tabpanel" aria-labelledby="history-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body pb-2">
                    <div class="row g-2 g-md-auto">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="history_ticket_id" aria-label="ticket">
                                    <option value="" selected>Select Ticket</option>
                                    @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                    @endforeach
                                </select>
                                <label for="history_ticket_id">Ticket</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="history_mode_id" aria-label="mode">
                                    <option value="" selected>Select Mode</option>
                                    @foreach ($modes as $mode)
                                    <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                    @endforeach
                                </select>
                                <label for="history_mode_id">Mode</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="history_result_date">
                                <label for="history_result_date">Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary h-100 w-100" onclick="result()"><i class="icon cil-search me-1"></i>
                                Search</button>
                        </div>
                    </div>


                    <div class="result mt-5">

                    </div>




                </div>
            </div>
        </div>

        <div class="tab-pane fade bg-white border border-top-0" id="cancel" role="tabpanel" aria-labelledby="cancel-tab"
            tabindex="1">
            <div class="card border border-0 rounded-0">
                <div class="card-body pb-2">
                    <div class="row g-2 g-md-auto">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="cancel_ticket_id" aria-label="ticket">
                                    <option value="" selected>Select Ticket</option>
                                    @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                    @endforeach
                                </select>
                                <label for="cancel_ticket_id">Ticket</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="cancel_result_date">
                                <label for="cancel_result_date">Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary h-100 w-100" onclick="resultCancel()"><i class="icon cil-x-circle me-1"></i>
                                Cancel Result</button>
                        </div>
                    </div>

                    <div class="result-cancel mt-5">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card.shadow.border-primary:hover {
            background: var(--cui-primary);
            color: white !important;
            cursor: default;
        }

        .card.shadow.border-primary {
            transition: all 400ms ease-in;
        }
    </style>
    <script>
        $(document).ready(function () {
            const today = new Date().toISOString().split('T')[0];
            $('#result_date').val(today);
            $('#history_result_date').val(today);
        });

        $(document).on('input', '#super_position_1, #super_position_2, #super_position_3, #super_position_4, #super_position_5, input[name="encouragement_prizes[]"]', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 3);
        });

        $(document).on('input', '#box_position_1, #box_position_2, #box_position_3, #box_position_4, #box_position_5', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 3);
        });

        $(document).on('input', '#ab, #bc, #ac', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 2);
        });

        $(document).on('input', '#a, #b, #c', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 1);
        });

        function permutations(str) {
            const result = new Set();
            function permute(remaining, prefix = '') {
                if (remaining.length === 0) {
                    result.add(prefix); return;
                }

                for (let i = 0; i < remaining.length; i++) {
                    const next = remaining.slice(0, i) + remaining.slice(i + 1);
                    permute(next, prefix + remaining[i]);
                }
            }
            permute(str);
            return Array.from(result);
        }

        $(document).on('keyup', '#super_position_1', function () {
            let value = $(this).val().replace(/\D/g, '').substring(0, 3);
            $(this).val(value);

            // Clear if less than 3 digits
            if (value.length !== 3) {
                $('#ab, #bc, #ac, #a, #b, #c').val('');
                $('#box_position_1, #box_position_2, #box_position_3, #box_position_4, #box_position_5').val('');
                return;
            }

            // ABC values
            const a = value[0];
            const b = value[1];
            const c = value[2];
            $('#a').val(a);
            $('#b').val(b);
            $('#c').val(c);
            $('#ab').val(a + b);
            $('#bc').val(b + c);
            $('#ac').val(a + c);

            // Permutations
            const perms = permutations(value);
            // Fill box positions (first 5)
            $('#box_position_1').val(perms[0] || '');
            $('#box_position_2').val(perms[1] || '');
            $('#box_position_3').val(perms[2] || '');
            $('#box_position_4').val(perms[3] || '');
            $('#box_position_5').val(perms[4] || '');
            $('#box_position_6').val(perms[5] || '');
        });

        $(document).on('submit', '#resultForm', function (e) {
            e.preventDefault();
            const $form = $(this);
            const $btn = $form.find('button[type="submit"]');
            // clear old errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $btn.prop('disabled', true).text('Saving...');
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: "Published!",
                            text: `${response.message}`,
                            icon: "success"
                        });

                        $form[0].reset();
                    }else{
                        Swal.fire({
                                icon: "error",
                                title: response.message || "Something went wrong",
                                showConfirmButton: false,
                                timer: 2500
                            });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, messages) {
                            // for array fields like encouragement_prizes.0
                            let field = key.split('.')[0];
                            const $input = $('[name="' + field + '"]');
                            $input.addClass('is-invalid');
                            $('.error-' + field).text(messages[0]);
                        });
                    } else {
                        console.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                },
                complete: function () {
                    $btn.prop('disabled', false).text('Save');
                }
            });
        });

        $(document).on('change', '#history_ticket_id, #history_result_date, #history_mode_id', function(){
            result();
        });

        function result() {
            let ticketId = $('#history_ticket_id').val();
            let resultDate = $('#history_result_date').val();
            let modeId = $('#history_mode_id').val();
            $.ajax({
            url: '{{ route('result.history') }}',
            method: 'get',
            data: { ticketId, resultDate, modeId },
            beforeSend: function () {
                $('.result').html(`<div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            </div>`);
                $('.search-btn').prop('disabled', true);
            },
            success: function (response) {
                if (response.status) {
                let result = '';
                if (modeId == 8) {
                    let eprize = '';
                    const prizes = JSON.parse(response.result.super_encouragement_prize || '[]');
                    $.each(prizes, function (index, number) {
                    eprize += `<div class="col-2 rounded border border-primary py-2">
                               ${number}
                            </div>`;
                    });
                    result = `<div class="row justify-content-center">
                            ${positionCard(1, response.result.super_position_1)}
                            ${positionCard(2, response.result.super_position_2)}
                            ${positionCard(3, response.result.super_position_3)}
                            ${positionCard(4, response.result.super_position_4)}
                            ${positionCard(5, response.result.super_position_5)}
                            </div>
                            <div class="row text-center mt-4 mb-3 mx-2">
                            ${eprize}
                            </div>`;
                }

                if (modeId == 7) {

                    let box_position_4 = '';
                    let box_position_5 = '';
                    let box_position_6 = '';

                    if (response.result.box_position_4 != null) {
                    box_position_4 = positionCard(4, response.result.box_position_4);
                    }

                    if (response.result.box_position_5 != null) {
                    box_position_5 = positionCard(5, response.result.box_position_5);
                    }

                    if (response.result.box_position_6 != null) {
                    box_position_6 = positionCard(6, response.result.box_position_6);
                    }
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.box_position_1)}
                                ${positionCard(2, response.result.box_position_2)}
                                ${positionCard(3, response.result.box_position_3)}
                                ${box_position_4}
                                ${box_position_5}
                                ${box_position_6}
                            </div>`;
                }

                if (modeId == 6) {
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.ac)}
                            </div>`;
                }

                if (modeId == 5) {
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.bc)}
                            </div>`;
                }

                if (modeId == 4) {
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.ab)}
                            </div>`;
                }

                if (modeId == 3) {
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.c)}
                            </div>`;
                }

                if (modeId == 2) {
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.b)}
                            </div>`;
                }

                if (modeId == 1) {
                    result = `<div class="row justify-content-center">
                                ${positionCard(1, response.result.a)}
                            </div>`;
                }


                $('.result').html(result);
                }
            },
            error: function (xhr) {
                $('.result').html(`<div class="alert alert-danger" role="alert">
                                ${xhr.responseJSON?.message || 'Something went wrong'}
                                </div>`);
            },
            complete: function () {
                $('.search-btn').prop('disabled', false);
            }
            });
        }

        function resultCancel() {

            let ticketId = $('#cancel_ticket_id').val();
            let resultDate = $('#cancel_result_date').val();

            $.ajax({
                url: '{{ route('result.cancel') }}',
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    ticketId,
                    resultDate
                },
                beforeSend: function () {
                    $('.result-cancel').html(`<div class="text-center">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>`);
                    $('.search-btn').prop('disabled', true);
                },
                success: function (response) {
                    if (response.status) {
                        $('.result-cancel').html(`<div class="alert alert-success" role="alert">
                                                    ${response.message}
                                                </div>`);
                    }
                },
                error: function (xhr) {
                    $('.result-cancel').html(`<div class="alert alert-danger" role="alert">
                                    ${xhr.responseJSON?.message || 'Something went wrong'}
                                    </div>`);
                },
                complete: function () {
                    $('.search-btn').prop('disabled', false);
                }
            });
        }

        function positionCard(position, value) {
            return `<div class="col-md-2">
                            <div class="card shadow border-primary">
                                <div class="card-body text-center">
                                    <h2 class="card-title fw-bold">${position}</h2>
                                    <h5 class="card-subtitle my-2 text-body-secondary fw-semibold">${value}</h5>
                                </div>
                            </div>
                        </div>`;
        }
    </script>
@endsection
