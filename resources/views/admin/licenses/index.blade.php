@extends('layouts.admin')

@section('title', 'Licenses')

@section('content')
    @if (count($licenses) >= 1)
        @foreach($licenses as $license)
            <div>
                {{ $license->email }} <br>
                {{ $license->license_key }} <br>
                {{ $license->valid_until }}
            </div>
        @endforeach
    @else
        <p>No Licenses Created</p>
    @endif
@endsection
