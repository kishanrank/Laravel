@extends('layouts.frontend')

@section('title')
<title>@if($news) {{ $news->title }} @endif </title>
@endsection

@section('meta')
    <!-- post meta tag -->
    <meta name="subject" content="{{ $news->meta_title }}">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($news->meta_description) ?? '',150,' ...') }}"/>
    <meta name="url" content="{{ route('news.single', ['slug' => $news->slug]) }}">
    <meta name="image" content="{{ asset($news->featured) }}">
    <meta name="category" content="Tech news">
    
    <!-- og meta tags -->
    <meta property="og:title" content="{{ $news->meta_title }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($news->meta_description) ?? '',150,' ...') }}">
    <meta property="og:url" content="{{ route('news.single', ['slug' => $news->slug]) }}">
    <meta property="og:image" content="{{ asset($news->featured) }}">
@endsection

@section('header')
<div id="post-header" class="page-header">
    <div class="background-img"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="post-meta">
                    <span class="post-date">Posted On {{ $news->created_at->toFormattedDateString() }}</span>
                </div>
                <h1 class="text-dark">{{ $news->title }}</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-8">
<div class="section-row sticky-container">
    <div class="main-post">
        <figure class="figure-img">
            <img class="img-responsive" src="{{ asset($news->featured) }}" alt="">
        </figure>
        {!! $news->content !!}
    </div>
    <!-- share post in social media -->
    <div class="post-shares sticky-shares">
        <a href="https://www.linkedin.com/in/" class="share-facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" class="share-twitter"><i class="fa fa-twitter"></i></a>
        <a href="#" class="share-google-plus"><i class="fa fa-google-plus"></i></a>
        <a href="#" class="share-linkedin"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-envelope"></i></a>
    </div>
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
                <img class="media-object" src="{{asset($news->user->profile->avatar)}}" alt="">
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <h3>{{$news->user->name }}</h3>
                </div>
                <p>{{ $news->user->profile->about}}</p>
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
</div>
@endsection

@section('rightsidebar')
<div class="col-md-4">
    @include('front.includes.rightsidebar')
</div>
@endsection