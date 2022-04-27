@extends('layouts.app')

@section("css-head")
    <style>
        .cus-img{
            width:50px;
            height: 50px;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-top: 30px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                    <li class="breadcrumb-item">Article</li>
                @endcomponent
                @if(session("status"))
                    {{--                            {{ session("status") }}--}}
                    @component("component.toast")
                        <div class="d-flex bg-success" data-bs-autohide="true">
                            <div class="toast-body">
                                <h5 class="d-inline">{{ session("status") }}</h5>
                                Article is deleted.
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    @endcomponent
                @endif
                    <div class="card ">
                        <div class="card-header">Article List</div>
                            <div class="card-body table-responsive">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        {{ $articles->appends(Request::all())->links() }}
                                    </div>
                                    <div class="">
                                        <form action="{{ route("article.index") }}" method="get" class="d-flex">
                                            <input type="search" class="form-control" name="search">
                                            <button class="btn btn-primary ms-2">Search</button>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-hover table-responsive overflow-hidden">
                                    <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Title</td>
                                        <td class="text-nowrap">Description</td>

                                        @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
                                            <td>Owner</td>
                                        @endif

                                        <td>Control</td>
                                        <td>Created_at</td>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @inject("users","App\Models\User")--}}
{{--                                    @inject("photo","App\Models\Photo")--}}
                                    @foreach($articles as $article)
                                        <tr>
                                            <td>{{ $article->id }}</td>
                                            <td class="text-nowrap">{{ substr($article->title,0,25) }} ...</td>
                                            <td class="text-nowrap">
                                                {{ substr($article->description,0,50) }} ...
                                                <br>

                                                @foreach($article->getPhotos as $img)
                                                    <img class="cus-img" src="{{ asset("storage/article/".$img->location) }}" alt="{{ $img->location }}">
                                                @endforeach

                                            </td>

                                            @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
                                                <td>
                                                    {{--                                                {{ $users->find($article->user_id)->name }}--}}
                                                    @isset($article->getUser)
                                                        {{ $article->getUser->name }}
                                                    @else
                                                        unknown
                                                    @endisset
                                                </td>
                                            @endif

                                            <td class="text-nowrap">
                                                <a href="{{ route('article.show',$article->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                                <div class="btn-group rounded-0">
                                                    <button form="del{{$article->id}}" type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    <form method="post" id="del{{$article->id}}" action="{{ route("article.destroy",$article->id) }}">
                                                        @csrf
                                                        @method("delete")
                                                    </form>
                                                </div>
                                                <a href="{{ route('article.edit',$article->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            </td>
                                            <td class="text-nowrap">
                                                <small>
                                                    {{ $article->created_at->format("d M Y ")}}

                                                    {{ $article->created_at->format("h:i a" ) }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                    </div>
            </div>
        </div>
    </div>
@endsection
