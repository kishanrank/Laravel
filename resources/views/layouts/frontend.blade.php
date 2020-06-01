<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>{{ $setting->site_name }}</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{asset('app/css/bootstrap.min.css')}}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{asset('app/css/font-awesome.min.css')}}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('app/css/style.css')}}" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    
    @yield('stylesheet')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
</head>

<body>

    <!-- Header -->
    @include('includes.header')
    <!-- /Header -->

    @yield('header')

    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-9">
                    @yield('content')
                </div>

                <div class="col-md-3">
                    <!-- ad -->
                    <div class="aside-widget text-center">
                        <a href="#" style="display: inline-block;margin: auto;">
                            <img class="img-responsive" src="{{asset('app/img/ad-1.jpg')}}" alt="">
                        </a>
                    </div>
                    <!-- /ad -->

                    <!-- post widget -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Most Read</h2>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/widget-1.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/widget-2.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/widget-3.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Why Node.js Is The Coolest Kid On The Backend Development Block!</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/widget-4.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /post widget -->

                    <!-- catagories -->
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
                    <!-- /catagories -->

                    <!-- tags -->
                    @if($sideWidgetTag)
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Tags</h2>
                        </div>
                        <div class="tags-widget">
                            <ul>
                                @foreach($sideWidgetTag as $tag)
                                <li><a href="{{route('posts.by.tag', ['tagslug' => $tag->slug])}}">{{ $tag->tag}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <!-- /tags -->

                    <!-- archive -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Archive</h2>
                        </div>
                        <div class="archive-widget">
                            <ul>
                                <li><a href="#">Jan 2018</a></li>
                                <li><a href="#">Feb 2018</a></li>
                                <li><a href="#">Mar 2018</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /archive -->
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- Footer -->
    @include('includes.footer')
    <!-- /Footer -->

    <!-- jQuery Plugins -->
    <script src="{{asset('app/js/jquery.min.js')}}"></script>
    <script src="{{asset('app/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/js/main.js')}}"></script>
    @yield('scripts')
</body>

</html>