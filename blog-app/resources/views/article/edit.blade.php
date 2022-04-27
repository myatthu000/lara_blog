{{--<p>{{ $article }}</p>--}}

@extends('layouts.app')
@section("css-head")
    <style>
        .cus-img{
            width:150px;
            height: 150px;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-top: 30px;

        }
    </style>
@endsection

@section('content')
    <div class="container">
        @if(session("status"))
            {{--            {{ session("status") }}--}}
            @component("component.toast")
                <div class="d-flex bg-success" data-bs-autohide="true">
                    <div class="toast-body">
                        {{--                    <h5 class="d-inline">{{ session("status") }}</h5>--}}

                        Article is Added.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            @endcomponent
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route("article.index") }}">Article</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Article Update</li>
                @endcomponent

                <div class="card">
                    <div class="card-header">Add Article</div>
                    <div class="card-body">

                        <form action="{{route("article.update",$article->id)}}" id="article-form" method="post">
                            @method("PATCH")
                            @csrf
                            <div class="form-group mb-3">
                                <label for="title" class="mb-2 ">Article Title</label>
                                <input type="text" value="{{ $article->title }}" name="title" id="title" class="form-control @error('title') is-invalid @enderror ">
                                @error('title')
                                <small class="font-weight-bold text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="mb-2">Description</label>
                                <textarea id="description" class="form-control @error('title') is-invalid @enderror " name="description" rows="10">{{ $article->description}}</textarea>
                                @error('description')
                                <small class="font-weight-bold text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <hr>

                            <button class="btn btn-info text-center" for="article-form">Update Article</button>
                        </form>

{{--                        @inject("photo","App\Models\Photo")--}}
                        @foreach($article->getPhotos as $img)

                            <div class="d-inline-block">
                                <img class="cus-img" src="{{ asset("storage/article/".$img->location) }}" alt="{{ $img->location }}">

                                <form class="" action="{{ route("photo.destroy",$img->id) }}" method="post">
                                    @csrf
                                    @method("delete")
                                    <button style="margin-top: -80px;margin-left: 5px;" class="btn btn-sm btn-danger">Delete</button>
                                </form>

                            </div>
                        @endforeach

                        <div class="mt-2">
                            <form action="{{ route("photo.store") }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <div class="d-flex">
                                    <div class="col-6 me-3">
{{--                                        <label for="photo">Edit Photo</label>--}}
                                        <input required type="file" class="form-control" name="photo[]" id="photo" multiple>
                                        @error("photo.*")
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-info">Edit Article Photo</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
