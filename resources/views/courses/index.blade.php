@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Course</div>

                <div class="card-body">
                    <table id="courseData" class="table display nowrap table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-body">
                <h5 class="card-title">Create New Course</h5>
                <div class="d-flex justify-content-between">
                    <p class="card-text">New course for college.</p>
                    <div class="pl-2">
                        <a href="{{ route('create_course') }}" class="btn btn-primary">Go</a>
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
        var manageBatchData1;

        $(document).ready( function () {
            $('#courseData').DataTable({
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
                ajax: "{{ route('course_data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'code', name: 'code' },
                    { data: 'action', name: 'action' },
                ]
            });
        } );
    </script>
@endpush
