@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                    <li class="breadcrumb-item">Article Detail</li>
                @endcomponent
                <div class="card">
                    <div class="card-header">Article Detail</div>

{{--                    @inject("users","App\Models\User")--}}

                    <div class="card-body">
                        {{ $article  }}
                        <h4 class="me-2">{{ $article->title }}</h4>
                        <div class="d-flex justify-content-sm-start align-items-center py-3">
                            <p class="me-2">
                                <small>{{ $article->created_at->diffForHumans()}}</small>
                            </p>
                            <p class="me-2">
                                <small>
                                    {{ $article->created_at->format("d M Y")}}
                                    {{ $article->created_at->format("h:i a")}}
                                </small>
                            </p>
                            <p class="">
                                {{$article->getUser->name}}
{{--                                {{ $users->find($article->user_id)->name }}--}}
                            </p>
                        </div>
                        <p class="mb-2">{{ $article->description }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
