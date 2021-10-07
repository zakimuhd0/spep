@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Batch 1</div>

                <div class="card-body">
                    <table id="batchData1" class="table display nowrap table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Batch</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="p-2"></div>

            <div class="card">
                <div class="card-header">Batch 2</div>

                <div class="card-body">
                    <table id="batchData2" class="table display nowrap table-hover" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Batch</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-body">
                <h5 class="card-title">Create New Batch</h5>
                <div class="d-flex justify-content-between">
                    <p class="card-text">New batch for managing student allowance of new batch.</p>
                    <div class="pl-2">
                        <a href="{{ route('create_batch') }}" class="btn btn-primary">Go</a>
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
        var manageBatchData1, manageBatchData2;

        manageMemberTable = $("#batchData1").DataTable({
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
            ajax: "{{ route('batch_data1') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'batch', name: 'batch' },
                { data: 'action', name: 'action' },
            ]
        });

        manageBatchData2 = $("#batchData2").DataTable({
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
            ajax: "{{ route('batch_data2') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'batch', name: 'batch' },
                { data: 'action', name: 'action' },
            ]
        });
    </script>
@endpush
