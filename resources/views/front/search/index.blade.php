@extends('layouts.frontend')

@section('header')
<div class="page-header">
    <div class="container">
        <div class="row">
            <h1>Following results matches to your search</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-9">
    <div class="row">
        @if($posts)
        @foreach($posts as $post)
        <div class="col-md-12">
            <div class="post post-row">
                <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug]) }}"><img src="{{$post->featured}}" width="150px" height="150px" alt="{{ $post->title}}"></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug]) }}">{{ $post->title}}</a></h3>
                    <div class="post-meta">
                        <a class="post-category cat-2" href="{{ route('posts.by.category', ['categoryslug' => $post->category->slug])}}">{{$post->category->name}}</a>
                        <span class="post-date">{{$post->created_at->toFormattedDateString()}}</span>
                    </div>

                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content) ?? '',165,' ...') }}</p>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <!-- if there is post found then ad displays -->
        <div class="col-md-12 text-center">
            <strong>
                <h1>Sorry, No data found for your search</h1>
            </strong>
        </div>
        @endif
        <div class="col-md-12">
            <div class="section-row">
                <a href="#">
                    <img class="img-responsive center-block" src="{{asset('app/img/ad-2.jpg')}}" alt="">
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /post -->
@endsection

@section('rightsidebar')
<div class="col-md-3">
    @include('includes.rightsidebar')
</div>
@endsection