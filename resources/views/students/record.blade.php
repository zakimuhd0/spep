@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{--$batchId}} , {{$batchText}}, {{$record}} , {{$recordMonthId}}, {{$recordMonthText--}}

                    <table id="recordData" class="table display nowrap table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>IC Number</th>
                                <th>Course</th>
                                <th>Allowance</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>

                    <div class="modal fade" id="document_modal" tabindex="-1" role="dialog" aria-labelledby="document_modal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="document_modal_title"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="" id="document_photo" class="img-fluid" align="center"/>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-body">
                <h5 class="card-title">Add New Student</h5>
                <div class="d-flex justify-content-between">
                    <p class="card-text pr-4">Add new student for batch {{$batchText}} and month {{$recordMonthText}}.</p>
                    <div>
                        <a href="{{ route('create_record' )}}" class="btn btn-primary">Go</a>
                    </div>
                </div>

                @if($firstMonthBatch == 0)
                    <h5 class="card-title font-weight-bold">One-Click-Import</h5>
                    <div class="d-flex justify-content-between">
                        <p class="card-text pr-4">All data imported from the previous month to current month with just one click.</p>
                        <div>
                            <a href="{{ route('import_record' )}}" class="btn btn-primary">Go</a>
                        </div>
                    </div>
                @endif

                <h5 class="card-title font-weight-bold">One-Click-PDF</h5>
                <div class="d-flex justify-content-between">
                    <p class="card-text pr-4">Generate student list and document photo with just one click.</p>
                    <div>
                        <!--<a href="{{ route('create_list' )}}" target="_blank" class="btn btn-primary">Go</a>--!>
                        <a href="#pdf" onclick="window.open('{{ route('create_photo' )}}'); window.open('{{ route('create_list' )}}');" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready( function () {
            var table = $('#recordData').DataTable({
                processingprocessing: true,
                serverSide: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                ordering: false,
                info: false,
                iDisplayLength: 10,
                aLengthMenu: [
                    [10],
                    [10]
                ],
                ajax: "{{ route('record_data') }}",
                columns: [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "render": function () {
                            return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                        },
                        width:"15px"
                    },
                    { "data": "name" },
                    { "data": "ic_number" },
                    { "data": "code" },
                    { "data": "allowance" },
                    { "data": "action" },
                ]
            });

            /*$('#recordData tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                //alert( 'You clicked on '+data['id']+'\'s row' );
                document.location.href = "/s/record/student/" + +data['id'];
            } );*/

            // Add event listener for opening and closing details
            // Add event listener for opening and closing details
            $('#recordData tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var tdi = tr.find("i.fa");
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    tdi.first().removeClass('fas fa-minus-square');
                    tdi.first().addClass('fas fa-plus-square');
                }
                else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                    tdi.first().removeClass('fas fa-plus-square');
                    tdi.first().addClass('fas fa-minus-square');
                }
            });

            table.on("user-select", function (e, dt, type, cell, originalEvent) {
                if ($(cell.node()).hasClass("details-control")) {
                    e.preventDefault();
                }
            })
        } );

        function format(d){

            // `d` is the original data object for the row
            return '<table cellpadding="0" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Full Name</td>' +
                '<td>:</td>' +
                '<td colspan="2">' + d.name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Course</td>' +
                '<td>:</td>' +
                '<td colspan="2">' + d.code + '-' + d.courses + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Identity Card Number</td>' +
                '<td>:</td>' +
                '<td width="50px">' + d.ic_number + '</td>' +
                '<td><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#document_modal" data-img="' + '../storage/' + d.ic_photo  +'">View</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Bank Account Number</td>' +
                '<td>:</td>' +
                '<td>' + d.bank_account_number  +'</td>' +
                '<td><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#document_modal" data-img="' + '../storage/' + d.bank_account_photo  +'">View</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Allowance</td>' +
                '<td>:</td>' +
                '<td colspan="2">' + d.allowance + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Disabilities Status</td>' +
                '<td>:</td>' +
                '<td colspan="2">' + d.disabilities_status + '</td>' +
                '</tr>' +
                '</table>';
        }

        $('#document_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var img = button.data('img')
            document.getElementById('document_photo').src = img;
        })
    </script>
@endpush
