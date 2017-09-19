@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    @if (count($products) >= 1)
        <table width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Public</th>
                    <th>Created</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->public }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td><a href="{{ route('admin.products.edit', $product->id) }}" class="btn brn--small btn-primary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No Products Created</p>
    @endif

    <a href="{{ route('admin.products.create') }}">Add New</a>
@endsection
