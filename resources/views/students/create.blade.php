@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Add New Student
                    <blockquote class="blockquote">
                        <footer class="blockquote-footer">Add new for batch  {{$batchText}} and month {{$recordMonthText}}.</footer>
                    </blockquote>
                </div>

                <div class="card-body">
                    @if(\Session::has('success'))
                        <div class="alert alert-success">
                            {{ \Session::get('success') }}
                        </div>
                    @endif
                    <form action="/s" enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control text-uppercase @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ic_number">Identity Card Number</label>
                            <the-mask mask="#XXXXX-XX-XXXX" type="text" masked="true" id="ic_number" type="text" class="form-control @error('ic_number') is-invalid @enderror" name="ic_number" value="{{ old('ic_number') }}" required></the-mask>

                            @error('ic_number')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bank_account_number">Bank Account Number</label>
                            <the-mask mask="#XXXXXXXXXXX" type="text" masked="true" id="bank_account_number" type="text" class="form-control @error('bank_account_number') is-invalid @enderror" name="bank_account_number" value="{{ old('bank_account_number') }}" required></the-mask>

                            @error('bank_account_number')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="course">Course</label>
                            <select id="course" type="text" class="form-control @error('courses') is-invalid @enderror" name="course" value="{{ old('courses') }}" required>
                                @foreach($courseData as $data)
                                    <option value="{{ $data->id }}">{{ $data->code . '-' .  $data->name }}</option>
                                @endforeach
                            </select>

                            @error('courses')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ic_photo">Identity Card Photo</label>
                            <input id="ic_photo" type="file" class="form-control-file @error('ic_photo') is-invalid @enderror" name="ic_photo" value="{{ old('ic_photo') }}" required>

                            @error('ic_photo')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bank_account_photo">Bank Account Photo</label>
                            <input id="bank_account_photo" type="file" class="form-control-file @error('bank_account_photo') is-invalid @enderror" name="bank_account_photo" value="{{ old('bank_account_photo') }}" required>

                            @error('bank_account_photo')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="disabilities_status">Student with Disabilities (OKU)</label>
                            <select id="disabilities_status" class="form-control @error('disabilities_status') is-invalid @enderror" name="disabilities_status" value="{{ old('disabilities_status') }}" required>
                                <option value="1">Yes</option>
                                <option value="0" selected="selected">No</option>
                            </select>
                            <small id="disabilities_status" class="form-text text-muted">Default : No</small>

                            @error('disabilities_status')
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
                                <li><code>1/</code> or</li>
                                <li><code>2/</code></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><strong>Important</strong></li>
                        <li><code>1</code> or <code>2</code>  in the batch represents when the batch will start and end</li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><code>1</code> starting from January to June 2021</li>
                        <li><code>2</code> starting from July to December 2021</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
