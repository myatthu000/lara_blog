@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route("article.index") }}">Article</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                @endcomponent
            </div>
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">Edit Profile</div>
                    <div class="card-body ">
                        <img class="w-100 rounded mb-3" style="width: 150px;height: 150px;object-fit: cover;object-position: top;" src="{{ asset("storage/profile/".\Illuminate\Support\Facades\Auth::user()->photo) }}" alt="">
                        <div class="">
                            <form action="{{route("profile.update")}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method("post")
                                <div class="mb-3">
                                    <label for="file">Choose Profile Photo</label>
{{--                                    accept="image/png,image/jpeg,image/png"--}}
                                    <input class="form-control" type="file" name="photo" >
                                    @error("photo")
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button class="btn btn-primary w-100" >Update profile picture</button>
                            </form>
                        </div>
                        <div>
                            @isset($arr)
                                <ul>
                                    @foreach($arr as $a)
                                        @if($a !=  "." && $a != "..")
                                            <li>{{$a}}</li>
                                            <img src="{{ asset("storage/profile/".$a) }}" style="width: 150px;" alt="">
                                        @endif
                                    @endforeach
                                </ul>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">Profile Photos</div>
                        @foreach(Auth::user()->getPhoto as $img)
                            <img class="cus-img" style="width: 150px;height: 150px;object-fit: cover;border-radius: 0.25rem;margin: 5px;" src="{{ asset("storage/profile/".$img->location) }}" alt="">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12 mt-3">
                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.changePassword') }}">
                            @csrf

                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">Current Password</label>
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                            </div>

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">New Password</label>
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                            </div>

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">New Confirm Password</label>
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 w-100">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
