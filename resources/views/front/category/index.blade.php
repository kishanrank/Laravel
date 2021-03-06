@extends('layouts.frontend')

@section('title')
<title>@if($category) {{ $category->name }} @endif Category | K.M.R@NK'S Blog</title>
@endsection

@section('meta')
<!-- post meta tag -->
<meta name="subject" content="{{ $category->meta_name }}">
<meta name="description" content="{{ $category->meta_description }}" />
<meta name="url" content="{{route('posts.by.category', ['categoryslug' => $category->slug])}}">
<meta name="image" content="">
<meta name="category" content="{{ $category->name}}">

<!-- og meta tags -->
<meta property="og:title" content="{{ $category->meta_title }}">
<meta property="og:description" content="{{ $category->meta_description }}">
<meta property="og:url" content="{{route('posts.by.category', ['categoryslug' => $category->slug])}}">
<meta property="og:image" content="">
@endsection

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
<div class="col-md-8">
    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-12">
            <div class="post post-row">
                <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug]) }}"><img src="{{$post->featured}}" width="200px" height="180px" alt="{{ $post->title}}"></a>
                <div class="post-body">
                    <h2 class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug]) }}">{{ $post->title}}</a></h2>
                    <div class="post-meta">
                        <a class="post-category cat-2" href="{{ route('posts.by.category', ['categoryslug' => $post->category->slug])}}">{{$post->category->name}}</a>
                        <span class="post-date">{{$post->created_at->toFormattedDateString()}}</span>
                    </div>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content) ?? '',165,' ...') }}</p>
                </div>
            </div>
        </div>
        @empty
        <!-- if there is post found then ad displays -->
        <div class="col-md-12 text-center">
            <strong>
                <h2>Sorry, No post found for this category</h2>
            </strong>
        </div>
        @endforelse
        <div class="col-md-12">
            <div class="section-row">
                <a href="#">
                    <img class="img-responsive center-block" src="{{asset('app/img/ad-2.jpg')}}" alt="">
                </a>
            </div>
        </div>

        {{ $posts->links('front.includes.pagination') }}
    </div>
</div>
@endsection

@section('rightsidebar')
<div class="col-md-4">
    @include('front.includes.rightsidebar')
</div>
@endsection