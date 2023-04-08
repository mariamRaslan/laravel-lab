<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    { $posts = Post::paginate(3); //to retrieve all records

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        $post = Post::find($id);  //query in db select * from posts where id = $postId
        $user_id=$post->user_id;
        $user =User::find($user_id);
        $comments = Comment::where('commentable_id',$id)->get();
        foreach ($comments as $comment) {
            if ($comment['user_id'])
                $comment['user_id'] = User::find($comment['user_id'])['name'];
        }
        return view('posts.show', ['post' => $post , 'user'=>$user , 'comments'=>$comments]);
    }

    public function create()
    {
        $users = User::all();

        return view('posts.create',[
            'users' => $users
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->all();


        Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],

        ]);
        return redirect()->route('posts.index');
    }

    public function edit($id)
    {
        $post=Post::all()->where('id',$id);
        //query in db select * from posts where id = $postId
        $users = User::all();
        return view('posts.edit',[
            'post' => $post,'users' => $users
        ]);
    }

    public function update($id,StorePostRequest $request)
    {
        $data = $request->all();
        Post::where('id',$id)
        ->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
            ]);
        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $deleted = Post::where('id', $id)->delete();
        return redirect()->route('posts.index');
    }
}
