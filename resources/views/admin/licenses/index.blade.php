@extends('layouts.admin')

@section('title', 'Licenses')

@section('content')
    @if (count($licenses) >= 1)
        <table width="100%">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Key</th>
                    <th>Valid Until</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($licenses as $license)
                    <tr>
                        <td>{{ $license->email }}</td>
                        <td>{{ $license->license_key }}</td>
                        <td>{{ $license->valid_until }}</td>
                        <td><a href="#" class="btn brn--small btn-primary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No Licenses Created</p>
    @endif
@endsection
