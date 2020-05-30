@extends('layouts.frontend')

@section('header')
<div id="post-header" class="page-header">
    <div class="background-img"></div>
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
<div class="section-row sticky-container">
    <div class="main-post">
        <figure class="figure-img">
            <img class="img-responsive" src="{{ $post->featured }}" alt="">
            <figcaption></figcaption>
        </figure>
        {!! $post->content !!}

        <!-- Tags releted to posts -->
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
        <a href="https://www.linkedin.com/in/savanihd" class="share-facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" class="share-twitter"><i class="fa fa-twitter"></i></a>
        <a href="#" class="share-google-plus"><i class="fa fa-google-plus"></i></a>
        <a href="#" class="share-linkedin"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-envelope"></i></a>
    </div>
</div>

<div class="section-row sticky-container">
    <ul class="pager">
        @if($previous_post)
        <li class="previous"><a href="{{ route('post.single', ['slug' => $previous_post->slug]) }}"><i class="fa fa-arrow-left"></i> &nbsp; Previous</a></li>
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
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection