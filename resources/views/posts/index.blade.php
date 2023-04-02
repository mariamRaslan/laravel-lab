@extends('layouts.app')

@section('title') Index @endsection

@section('content')
    <div class="text-center">
    <a href="{{route('posts.create')}}" class="mt-4 btn btn-success">Create Post</a>
    </div>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Posted By</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{$post['id']}}</td>
                <td>{{$post['title']}}</td>
                <td>{{ isset($post->user) ? $post->user->name : 'Not Found' }}</td>
                <td>{{ $post->created_at->format("Y-m-d")}}</td>
                <td>
                    <a href="{{route('posts.show',$post['id'])}}" class="btn btn-primary">View</a>
                    <a href="{{route('posts.edit',$post['id'])}}"  class="btn btn-success">Edit</a>
                    <form method="POST" action="{{route('posts.destroy',$post->id)}}"  style="display:inline">
                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                        <button type="submit" id='delete' class="btn btn-danger">Delete</button>
                                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
    {!! $posts->links() !!}
</div>

<script>
            const del=document.getElementById('delete');
            del.addEventListener('click',function(e){
                const c=confirm("You Sure Continue Deleted !");
                if(c == false){
                    e.preventDefault();
                }
            })
        </script>

@endsection
