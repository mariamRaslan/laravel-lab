@extends('layouts.app')

@section('title') Create @endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container  ms-5">
    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" >
        </div>
        <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea name="description"  class="form-control"  rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label  class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control">
            @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
            </select>
        </div>

        <div class="mb-3">
                <label for="photo" class="form-label">Upload image</label>

                <div class="col-md-6">
                    <input id="photo" type="file" class="form-control" name="photo">
                </div>
            </div>

        <button class="btn btn-success">Create Post</button>
    </form>
</div>
@endsection
