@extends('layouts.frontend')

@section('title')
<title>@if($post) {{ $post->title }} @endif</title>
@endsection
@section('meta')
@include('front.includes.meta.postmeta')
@endsection

@section('header')
<div id="post-header" class="page-header">
    <!--style="background-image: url('{{ asset('app/img/tital-banner-3.jpg')}}')" -->
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="post-meta">
                    <a class="post-category cat-2" href="{{ route('posts.by.category', ['categoryslug' => $post->category->slug])}}">{{ $post->category->name}}</a>
                    <span class="post-date">{{ $post->created_at->toFormattedDateString() }} By {{ $post->admin->name}}</span>
                </div>
                <h1 class="text-dark">{{ $post->title}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="col-md-8">
    <div class="text-center">
        <div>
            <strong>
                <p>Share this post</p>
            </strong>
        </div>
        <div class="addthis_inline_share_toolbox"></div>
    </div>
    <br />
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
                <img class="img-responsive" src="{{ asset($image->image) }}" width="640" height="380" alt="">
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
        <!-- share post in social media
        <div class="post-shares sticky-shares">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{route('post.single', ['slug' => $post->slug])}}" class="share-facebook" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{route('post.single', ['slug' => $post->slug])}}&text={{ $post->title}}" class="share-twitter" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{route('post.single', ['slug' => $post->slug])}}&title={{$post->title}}" class="share-linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
            <a href="mailto:info@example.com?&subject={{$post->title}}&body={{route('post.single', ['slug' => $post->slug])}}" class="share-envelope" target="_blank"><i class="fa fa-envelope"></i></a>
            <a href="https://pinterest.com/pin/create/button/?url={{route('post.single', ['slug' => $post->slug])}}&media={{$post->featured}}&description={{$post->title}}" class="share-pinterest" target="_blank"><i class="fa fa-pinterest"></i></a>
        </div> -->
    </div>

    <div class="text-center">
        <div>
            <strong>
                <p>Share this post</p>
            </strong>
        </div>
        <div class="addthis_inline_share_toolbox"></div>
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
                    <img class="media-object" src="{{asset($post->admin->profile->avatar)}}" alt="{{ $post->admin->name }}">
                </div>
                <div class="media-body">
                    <div class="media-heading">
                        <h3>{{ $post->admin->name }}</h3>
                    </div>
                    <p>{{ $post->admin->profile->about}}</p>
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
<div class="col-md-4">
    @include('front.includes.rightsidebar')
</div>
@endsection