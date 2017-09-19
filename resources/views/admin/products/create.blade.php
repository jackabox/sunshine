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

        <hr>

        <h4>GitHub</h4>

        <div class="form-group">
            <select name="repo_name" id="github_repo" class="form-control">
                @if ($repos)
                    @foreach ($repos as $repo)
                        <option value="{{ $repo['name'] }}">{{ $repo['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <select name="repo_release" id="github_release" class="form-control">
                <option value="">Please select a repo first</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" name="github_folder" placeholder="folder-name" class="form-control" value="{{ old('github_folder') }}">
        </div>

        <div class="form-group">
            <button type="button" id="fetch_repo_files" class="btn btn-primary">fetch repo</button>
        </div>

        {{ csrf_field() }}

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
