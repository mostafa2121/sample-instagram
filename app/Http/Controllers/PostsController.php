<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');

    }
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);
        return view('posts.index',compact('posts'));

    }
    public function create()
    {
        return view('posts.creat');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $imagePath = $data['image']->store('upload', 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        Auth::user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);
//        dd($imagePath);
        return redirect('/profiles/' . Auth::user()->id);
    }

    public function show(Post $post)
    {
        return view('posts.show')->withPost($post);
    }

}
