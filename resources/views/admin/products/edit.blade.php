@extends('layouts.admin')

@section('title', 'Products - Edit')

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
            <input type="text" name="title" placeholder="Title" class="form-control" value="{{ $product->name }}">
        </div>

        <div class="form-group">
             <textarea name="description" placeholder="Description" rows="10" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <select name="public" class="form-control">
                <option value="1" {{ $product->public == 1 ? 'selected' : '' }}>Public</option>
                <option value="0" {{ $product->public == 0 ? 'selected' : '' }}>Hidden</option>
            </select>
        </div>

        <h4>GitHub</h4>

        <div class="form-group">
            <select name="repo_name" id="github_repo" class="form-control">
                @if ($repos)
                    @foreach ($repos as $repo)
                        <option value="{{ $repo['name'] }}" @if($repo['name'] == $latest_release->repo_name) selected @endif>{{ $repo['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <select name="repo_release" id="github_release" class="form-control">
                @if ($releases)
                    @foreach ($releases as $release)
                        <option value="{{ $release['tag_name'] }}" @if($release['tag_name'] == $latest_release->version) selected @endif>{{ $release['tag_name'] }}</option>
                    @endforeach
                @else
                    <option value="">Please select a repo first</option>
                @endif
            </select>
        </div>

        <div class="form-group">
            <input type="text" name="github_folder" placeholder="folder-name" class="form-control" value="{{ $latest_release->folder_name }}">
        </div>

        <div class="form-group">
            <button type="button" id="fetch_repo_files" class="btn btn-primary">fetch repo</button>
        </div>

        <input type="hidden" id="file_path" name="file_path">
        <input type="hidden" id="file_name" name="file_name">
        <input type="hidden" id="file_version" name="file_version">

        {{ csrf_field() }}

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
