@extends('layouts.pdf')

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
        }
    </style>
@endpush

@section('content')
    @foreach($recordStudentList as $data)
    <img src="{{ url('/storage/' . $data->ic_photo)}}" width="100%" height="100%">
    <img src="{{ url('/storage/' . $data->bank_account_photo)}}" width="100%" height="100%">
    @endforeach
@endsection



