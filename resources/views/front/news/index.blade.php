@extends('layouts.frontend')

@section('title')
<title>Tech News | K.M.R@NK's Blog</title>
@endsection

@section('meta')
    <!-- post meta tag -->
    <meta name="subject" content="Latest technicle news">
    <meta name="description" content="Latest technicle news, all technicle news"/>
    <meta name="image" content="">
    <meta name="category" content="Tech news">
    
    <!-- og meta tags -->
    <meta property="og:title" content="Latest technicle news">
    <meta property="og:description" content="Latest technicle news">
    <meta property="og:url" content="{{route('news')}}">
    <meta property="og:image" content="">
@endsection

@section('header')
<div class="page-header">
    <div class="container">
        <div class="row">
            @if($allNews)
            <div class="col-md-10">
                <ul class="page-header-breadcrumb">
                    <li><a href="{{route('front.home')}}">Home/News</a></li>
                </ul>
                <h1>All Technicle News</h1>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-8">
    <div class="row">
        @forelse($allNews as $news)
        <div class="col-md-12">
            <div class="post post-row">
                <a class="post-img" href="{{ route('news.single', ['slug' => $news->slug]) }}"><img src="{{asset($news->featured)}}" width="100px" height="150px" alt="{{ $news->title}}"></a>
                <div class="post-body">
                    <h2 class="post-title"><a href="{{ route('news.single', ['slug' => $news->slug]) }}">{{ $news->title}}</a></h2>
                    <div class="post-meta">
                        <span class="post-date">Posted On : {{$news->created_at->toFormattedDateString()}}</span>
                    </div>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($news->content) ?? '',185,' ...') }}</p>
                </div>
            </div>
        </div>
        @empty
        <!-- if there is post found then ad displays -->
        <div class="col-md-12">
            <div class="section-row">
                <a href="#">
                    <img class="img-responsive center-block" src="{{asset('app/img/ad-2.jpg')}}" alt="">
                </a>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <strong>
                <h3>Sorry, No News available right now, Once available we will post it here.</h3>
            </strong>
        </div>
        @endforelse
        {{ $allNews->links('front.includes.pagination') }}
    </div>
</div>
@endsection

@section('rightsidebar')
<div class="col-md-4">
    @include('front.includes.rightsidebar')
</div>
@endsection