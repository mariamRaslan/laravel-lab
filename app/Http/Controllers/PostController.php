<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Jobs\PruneOldPostsJob;
use Illuminate\Support\Facades\Queue;

Queue::push(new PruneOldPostsJob);

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
      //  dd($data);
        if($request->file('photo')){
            $file_extension=$request->photo->getClientOriginalExtension();
            $file_name=time().'.'.$file_extension;
            $path ='photos/posts';
            $request->file('photo')->move( $path,$file_name);
            Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'user_id' => $data['post_creator'],
                'photo'=>$file_name

            ]);
        }
        else{
            Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'user_id' => $data['post_creator'],

            ]);
        }

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
        $post = Post::find($id);
      //  dd($post->photo);
        if ($post) {
            $post->update($request->except('photo'));
            if ($request->hasFile('photo')) {
                $old_photo = $post->photo;
                $photo = $request->photo;
                $photo_new_name = time() .'.'. $photo->getClientOriginalExtension();
                if ($photo->move('photos/posts', $photo_new_name)) {
                    unlink('photos/posts/'.$old_photo);
                }
                $post->photo = $photo_new_name;
            }
        }

        $post->save();

        return to_route('posts.index');
    }

    public function destroy($id)
    {
        $postPhoto = Post::find($id)->photo;
      //  dd($postPhoto);
        if ($postPhoto) {
            $file_path = "photos/posts/".$postPhoto;
            unlink($file_path);
        }
        Post::destroy($id);
        return redirect()->route('posts.index');
    }
}
