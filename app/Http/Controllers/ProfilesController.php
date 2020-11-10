<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
    public function index(User $user)
    {

        $follows =(auth()->user())? auth()->user()->following->contains($user->id):false;
        $postCount =Cache::remember('count.posts.'.$user->id,now()->addSecond(30),function () use ($user){
            return $user->posts->count();
        });
        $followerCount = $user->profile->followers->count();
        $followingCount = $user->following->count();
        return view('profiles.index',compact('user','follows','postCount','followerCount','followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user->profile);
        return view('profiles.edit')->withUser($user);
    }

    public function update(Request $request,User $user)
    {

        $data = $request->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'nullable',
            'image'=>''
        ]);

        if ($request['image']){
            $imagePath = $request['image']->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = (['image' => $imagePath]);
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray??[]
        ));

        return redirect("/profiles/{$user->id}");

    }
}
