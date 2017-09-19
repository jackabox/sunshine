@extends('layouts.admin')

@section('title', 'Products - Add')

@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        <h5>Error</h5>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="" action="/admin/products" method="post">
        <div class="form-group">
            <input type="text" name="title" placeholder="Title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="form-group">
             <textarea name="description" placeholder="Description" rows="10" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <select name="public" class="form-control">
                <option value="1" {{ old('public') == 1 ? 'selected' : '' }}>Public</option>
                <option value="0" {{ old('public') == 0 ? 'selected' : '' }}>Hidden</option>
            </select>
        </div>

        {{ csrf_field() }}

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
