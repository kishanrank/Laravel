@extends('layouts.frontend')

@section('title')
<title>{{ $setting->site_name }}</title>
@endsection

@section('meta')
<!-- post meta tag -->
<meta name="subject" content="K.M.R@NK">
<meta name="description" content="K.M.R@NK" />
@endsection
@section('content')

<div class="col-md-12">
    <div class="row">
        @if($first_post)
        <div class="col-md-6">
            <div class="post post-thumb">
                <a class="post-img" href="{{ route('post.single', ['slug' => $first_post->slug])}}"><img src="{{$first_post->featured}}" height="310px" alt="{{ $first_post->title }}"></a>
                <div class="post-body">
                    <div class="post-meta">
                        <a class="post-category cat-1" href="{{route('posts.by.category', ['categoryslug' => $first_post->category->slug])}}">{{ $first_post->category->name}}</a>
                        <span class="post-date">{{ $first_post->created_at->toFormattedDateString() }}</span>
                    </div>
                    <h3 class="post-title"><a href="{{ route('post.single', ['slug' => $first_post->slug])}}">{{ $first_post->title}}</a></h3>
                </div>
            </div>
        </div>
        @endif

        @if($second_post)
        <div class="col-md-6">
            <div class="post post-thumb">
                <a class="post-img" href="{{ route('post.single', ['slug' => $second_post->slug])}}"><img src="{{$second_post->featured}}" height="310px" alt="{{ $first_post->title }}"></a>
                <div class="post-body">
                    <div class="post-meta">
                        <a class="post-category cat-3" href="{{route('posts.by.category', ['categoryslug' => $second_post->category->slug])}}">{{ $second_post->category->name}}</a>
                        <span class="post-date">{{ $second_post->created_at->toFormattedDateString() }}</span>
                    </div>
                    <h3 class="post-title"><a href="{{ route('post.single', ['slug' => $second_post->slug])}}">{{ $second_post->title}}</a></h3>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>Recent Post</h2>
                    </div>
                </div>
                @forelse ($recent_posts as $post)
                <div class="post post-row">
                    <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug])}}"><img src="{{$post->featured}}" width="200px" height="180px" alt=""></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <a class="post-category cat-2" href="{{route('posts.by.category', ['categoryslug' => $post->category->slug])}}">{{ $post->category->name}}</a>
                            <span class="post-date">{{ $post->published_at->toFormattedDateString() }}</span>
                        </div>
                        <h3 class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug])}}">{{ $post->title }}</a></h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content) ?? '',180,' ...') }}</p>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center">
                    <strong>
                        <h2>Sorry, No Recent post found</h2>
                    </strong>
                </div>
                @endforelse
            </div>
        </div>
        <div class="col-md-4">
            <!--  MOST READ POST-->
            <div class="most-read-aside-widget">
                <div class="text-center">
                    <h2>Most Read</h2>
                </div>

                @foreach($mostReadPosts as $post)
                <div class="post-most-read post-widget">
                    <!-- <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug]) }}"><img src="{{ $post->featured }}" alt=""></a> -->
                    <div class="post-body">
                        <p class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug]) }}"><i class="fa fa-chevron-right">&nbsp;</i>{{$post->title}}</a></p>
                    </div>
                </div>
                @endforeach
            </div>
            <br>
            <!-- /post widget -->

            <!-- post widget -->
            <div class="most-read-aside-widget">
                <div class="text-center">
                    <h2>Latest News</h2>
                </div>
                @forelse($news_post as $news)
                <div class="post-most-read post-widget">
                    <!-- <a class="post-img" href="{{ route('news.single', ['slug' => $news->slug]) }}"><img src="{{asset($news->featured)}}" alt=""></a> -->
                    <div class="post-body">
                        <p class="post-title"><a href="{{ route('news.single', ['slug' => $news->slug]) }}"><i class="fa fa-chevron-right">&nbsp;</i>{{ $news->title }}</a></p>
                        <h5 class="">{{ $news->created_at->toFormattedDateString() }}</h5>
                    </div>
                </div>
                @empty
                <div>
                    <strong>
                        <h5>Sorry, No News found.</h5>
                    </strong>
                </div>
                @endforelse
            </div>
            <!-- /post widget -->

            <!-- ad -->
            <div class="aside-widget text-center">
                <a href="#" style="display: inline-block;margin: auto;">
                    <img class="img-responsive" src="{{asset('app/img/ad-1.jpg')}}" alt="">
                </a>
            </div>
            <!-- /ad -->
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="section-row container">
        <a href="#" style="display: inline-block;margin: auto;">
            <img class="img-responsive" src="{{asset('app/img/ad-2.jpg')}}" alt="">
        </a>
    </div>

    <div class="row">
        <!-- featured post  section -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>Featured Post</h2>
                    </div>
                </div>
                <!-- post -->
                <div class="col-md-12">
                    <div class="post post-row">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-4.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-2" href="category.html">JavaScript</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
                        </div>
                    </div>
                </div>
                <!-- /post -->
            </div>
        </div>

        <div class="col-md-4">
            <!-- ad  poster -->
            <div class="aside-widget text-center">
                <a href="#" style="display: inline-block;margin: auto;">
                    <img class="img-responsive" src="{{asset('app/img/ad-1.jpg')}}" alt="">
                </a>
            </div>
            <!-- /ad -->

            <!-- all catagories -->
            <div class="aside-widget">
                <div class="section-title">
                    <h2>Catagories</h2>
                </div>
                @if($sideWidgetCategory)
                <div class="category-widget">
                    <ul>
                        @foreach($sideWidgetCategory as $category)
                        <li><a href="{{ route('posts.by.category', ['categoryslug' => $category->slug])}}" class="cat-1">{{ $category->name}}<span>{{$category->posts->count()}}</span></a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection