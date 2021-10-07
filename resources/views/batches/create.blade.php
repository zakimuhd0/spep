@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create New Batch
                    <blockquote class="blockquote">
                        <footer class="blockquote-footer">New batch for managing student allowance of new batch.</footer>
                    </blockquote>
                </div>

                <div class="card-body">
                    @if(\Session::has('success'))
                        <div class="alert alert-success">
                            {{ \Session::get('success') }}
                        </div>
                    @endif
                    <form action="/b" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="batch">Batch</label>
                            <the-mask mask="#/XXXX" type="text" masked="true" id="batch" type="text" class="form-control @error('batches') is-invalid @enderror" name="batch" value="{{ old('batches') }}" required autofocus></the-mask>

                            @error('batches')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Step by Step</div>

                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>Enter batch according to the following format
                            <ul>
                                <li><code>1/{{$thisYear}}</code> or</li>
                                <li><code>2/{{$thisYear}}</code></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><strong>Important</strong></li>
                        <li><code>1</code> or <code>2</code>  in the batch represents when the batch will start and end</li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><code>1</code> starting from January {{$thisYear}} to June {{$nextYear}}</li>
                        <li><code>2</code> starting from July {{$thisYear}} to December {{$nextYear}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
