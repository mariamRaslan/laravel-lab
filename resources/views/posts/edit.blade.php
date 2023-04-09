@extends('layouts.app')

@section('title') Edit @endsection
@foreach ($post as $post)

@php    $id=$post->id ;
        $title=$post->title;
        $description=$post->description;

@endphp

@endforeach
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
    <form action="{{route('posts.update',$id)}}" method="POST" enctype="multipart/form-data" >
    @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input  name="title" type="text" class="form-control" value="{{$title}}">
        </div>
        <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea name="description" class="form-control"  rows="3">{{ $description}}</textarea>
        </div>

        <div class="mb-3">
            <label  class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control">
            @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="my-3">
            <label class="col-sm-3 col-form-label">Image</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="photo" />
            </div>
        </div>

        <button  class="btn btn-success">Update Post</button>
    </form>
    </div>
@endsection
