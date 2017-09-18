@extends('layouts.admin')

@section('title', 'Products - Add')

@section('content')
    <form class="" action="" method="post">
        <div class="form-group">
            <input type="text" name="title" placeholder="Title" class="form-control">
        </div>

        <div class="form-group">
             <textarea name="description" placeholder="Description" rows="10" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <select class="form-control">
                <option value="1">Public</option>
                <option value="0">Hidden</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
