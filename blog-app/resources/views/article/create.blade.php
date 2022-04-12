@extends('layouts.app')

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
                    <li class="breadcrumb-item active" aria-current="page">Add Article</li>
                @endcomponent

                <div class="card">
                    <div class="card-header">Add Article</div>
                    <div class="card-body">

                        <form action="{{route("article.store")}}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="title" class="mb-2 ">Article Title</label>
                                <input type="text" value="{{ old('title') }}" name="title" id="title" class="form-control @error('title') is-invalid @enderror ">
                                @error('title')
                                <small class="font-weight-bold text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="mb-2">Description</label>
                                <textarea id="description" class="form-control @error('title') is-invalid @enderror " name="description" rows="10">{{ old('description') }}</textarea>
                                @error('description')
                                <small class="font-weight-bold text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary">Save Article</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
