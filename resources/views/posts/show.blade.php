@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{$post->image}}" class="w-100">
            </div>
            <div class="col-4">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="pr-3">
                            <img src="{{$post->user->profile->profileImage()}}" style="max-width: 50px" class="w-100 rounded-circle">
                        </div>
                        <div>
                            <p class="font-weight-bold">
                                <a href="/profiles/{{$post->user->id}}">
                                    {{$post->user->username}}
                                </a>
                                <a href="" class="pl-5">Follow</a>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <p><span class="font-weight-bold"><a href="/profiles/{{$post->user->id}}"> {{$post->user->username}}</a> </span>  {{$post->caption}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
