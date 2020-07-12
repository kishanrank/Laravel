@extends('layouts.frontend')

@section('title')
<title>@if($post) {{ $post->title }} @endif</title>
@endsection
@section('meta')
<!-- post meta tag -->
<meta name="subject" content="{{ $post->title}}">
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->content) ?? '',150,' ...') }}" />
<meta name="url" content="{{ route('post.single', ['slug' => $post->slug]) }}">
<meta name="image" content="{{ $post->featured }}">
<meta name="category" content="{{ $post->category->name}}">

<!-- og meta tags -->
<meta property="og:title" content="{{ $post->title}}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->content) ?? '',150,' ...') }}">
<meta property="og:url" content="{{ route('post.single', ['slug' => $post->slug]) }}">
<meta property="og:image" content="{{ $post->featured }}">

<!-- twitter meta tag -->
<meta name="twitter:title" content="{{ $post->title}}">
<meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->content) ?? '',150,' ...') }}">
<meta name="twitter:url" content="{{ route('post.single', ['slug' => $post->slug]) }}">
<meta name="twitter:image" content="{{ $post->featured }}">
@endsection

@section('header')
<div id="post-header" class="page-header">
    <!--style="background-image: url('{{ asset('app/img/tital-banner-3.jpg')}}')" -->
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="post-meta">
                    <a class="post-category cat-2" href="category.html">{{ $post->category->name}}</a>
                    <span class="post-date">{{ $post->created_at->toFormattedDateString() }} By {{ $post->user->name}}</span>
                </div>
                <h1 class="text-dark">{{ $post->title}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-9">
    <div class="section-row">
        <div class="main-post">
            <figure class="figure-img">
                <img class="img-responsive" src="{{ $post->featured }}" alt="">
                <figcaption></figcaption>
            </figure>
            {!! $post->info !!}

            @if($post->images)
            @foreach($post->images as $image)
            <figure class="figure-img">
                <img class="img-responsive" src="{{ asset($image->image) }}" alt="">
            </figure>
            @endforeach

            @endif
            {!! $post->content !!}

            <!-- Tags releted to posts -->
            <br><br>
            <div class="aside-widget">
                <div class="tags-widget">
                    <ul>
                        <i class="fa fa-tags"></i>
                        @foreach($post->tags as $tag)
                        <li><a href="{{route('posts.by.tag', ['tagslug' => $tag->slug])}}">{{ $tag->tag}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <!-- share post in social media -->
        <div class="post-shares sticky-shares">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{route('post.single', ['slug' => $post->slug])}}" class="share-facebook" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{route('post.single', ['slug' => $post->slug])}}&text={{ $post->title}}" class="share-twitter" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{route('post.single', ['slug' => $post->slug])}}&title={{$post->title}}" class="share-linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
            <a href="mailto:info@example.com?&subject={{$post->title}}&body={{route('post.single', ['slug' => $post->slug])}}" class="share-envelope" target="_blank"><i class="fa fa-envelope"></i></a>
            <a href="https://pinterest.com/pin/create/button/?url={{route('post.single', ['slug' => $post->slug])}}&media={{$post->featured}}&description={{$post->title}}" class="share-pinterest" target="_blank"><i class="fa fa-pinterest"></i></a>
        </div>
    </div>

    <div class="section-row">
        <ul class="pager">
            @if($previous_post)
            <li class="previous"><a href="{{route('post.single', ['slug' => $previous_post->slug])}}"><i class="fa fa-arrow-left"></i> &nbsp; Previous</a></li>
            @endif
            @if($next_post)
            <li class="next"><a href="{{ route('post.single', ['slug' => $next_post->slug]) }}">Next &nbsp; <i class="fa fa-arrow-right"></i></a></li>
            @endif
        </ul>
    </div>
    <!-- ad -->
    <div class="section-row text-center">
        <a href="#" style="display: inline-block;margin: auto;">
            <img class="img-responsive" src="{{asset('app/img/ad-2.jpg')}}" alt="">
        </a>
    </div>
    <!-- ad -->
    <!-- author -->
    <div class="section-row">
        <div class="post-author">
            <div class="media">
                <div class="media-left">
                    <img class="media-object" src="{{asset($post->user->profile->avatar)}}" alt="">
                </div>
                <div class="media-body">
                    <div class="media-heading">
                        <h3>{{$post->user->name }}</h3>
                    </div>
                    <p>{{ $post->user->profile->about}}</p>
                    <ul class="author-social">
                        <li><a href="https://www.linkedin.com/in/kishanrank/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="https://github.com/kishanrank" target="_blank"><i class="fa fa-github"></i></a></li>
                        <li><a href="https://twitter.com/kishan__rank" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/___k._m._rank___/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('rightsidebar')
<div class="col-md-3">
    @include('includes.rightsidebar')
</div>
@endsection