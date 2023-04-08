@extends('layouts.app')

@section('title') Show @endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            Post Info
        </div>
        <div class="card-body">
    <h5 class="card-title">Title:</h5>
    <p class="card-text">{{$post->title}}:</p>
    <h5 class="card-title">Description:</h5>
    <p class="card-text">{{$post->description}}</p>
    </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Post Creator Info
        </div>
        <div class="card-body">
    <h5 class="card-title ">Name:-<small class="fw-normal">{{$user->name}}</small></h5>
    <h5 class="card-title">Email:- <small class="fw-normal">{{$user->email}}</small></h5>
    <h5 class="card-title">Created At:- <small class="fw-normal">{{ \Carbon\Carbon::parse($post->created_at)->isoFormat('MM dddd YYYY')}}</small></h5>

    </div>
    </div>
    @include('comments.index')
    @include('comments.create')
@endsection
