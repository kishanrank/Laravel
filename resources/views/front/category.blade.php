@extends('layouts.frontend')

@section('header')
<div class="page-header">
    <div class="container">
        <div class="row">
            @if($category)
            <div class="col-md-10">
                <ul class="page-header-breadcrumb">
                    <li><a href="{{route('front.home')}}">Home</a></li>
                    <li>{{ $category->name }}</li>
                </ul>
                <h1>Category : {{ $category->name }}</h1>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @if($posts)
    @foreach($posts as $post)
    <div class="col-md-12">
        <div class="post post-row">
            <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug]) }}"><img src="{{$post->featured}}" width="150px" height="150px" alt="{{ $post->title}}"></a>
            <div class="post-body">
                <div class="post-meta">
                    <a class="post-category cat-2" href="{{ route('posts.by.category', ['categoryslug' => $post->category->slug])}}">{{$post->category->name}}</a>
                    <span class="post-date">{{$post->created_at->toFormattedDateString()}}</span>
                </div>
                <h3 class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug]) }}">{{ $post->title}}</a></h3>
                <p>{!! \Illuminate\Support\Str::limit($post->content ?? '',165,' ...') !!}</p>
            </div>
        </div>
    </div>
    @endforeach
    <!-- if there is post found then ad displays -->
    <div class="col-md-12">
        <div class="section-row">
            <a href="#">
                <img class="img-responsive center-block" src="{{asset('app/img/ad-2.jpg')}}" alt="">
            </a>
        </div>
    </div>
    @else
    <div class="col-md-12 text-center">
        <strong>
            <h1>Sorry, No post found for this category</h1>
        </strong>
    </div>
    @endif
</div>
<!-- /post -->
<!-- <div class="col-md-12">
        <div class="section-row">
            <button class="primary-button center-block">Load More</button>
        </div>
    </div> -->
<!-- ad block below post list -->
@endsection