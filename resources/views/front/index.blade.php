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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
    <!-- Header -->
    @include('includes.header')
    <!-- /Header -->

    <!-- section -->

    <div class="section">
    </div>
    <div class="section">
        <!-- container -->
        <div class="container-fluid">
            <!-- row -->
            <div class="row">
                <!-- post first post of page -->
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
                <!-- /post -->

                <!-- post -->
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
                <!-- /post -->
            </div>
            <!-- /row -->

            <!-- row  FIRST AND SECOND ROW OF RECENT POST -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>Recent Posts</h2>
                    </div>
                </div>

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-3.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-1" href="category.html">Web Design</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-4.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-2" href="category.html">JavaScript</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-5.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-3" href="category.html">Jquery</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <div class="clearfix visible-md visible-lg"></div>

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-6.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-2" href="category.html">JavaScript</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Why Node.js Is The Coolest Kid On The Backend Development Block!</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-1.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-4" href="category.html">Css</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">CSS Float: A Tutorial</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-1" href="category.html">Web Design</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->
            </div>
            <!-- /row -->

            <!-- row POST -->
            <div class="row">
                <!-- BIG POST -->
                <div class="col-md-8">
                    <div class="row">
                        <!-- post -->
                        <div class="col-md-12">
                            <div class="post post-thumb">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-3" href="category.html">Jquery</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <!-- post -->
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-3.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-4" href="category.html">Css</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">CSS Float: A Tutorial</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <!-- post -->
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-1" href="category.html">Web Design</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <div class="clearfix visible-md visible-lg"></div>

                        <!-- post -->
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-2" href="category.html">JavaScript</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <!-- post -->
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-5.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-3" href="category.html">Jquery</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <div class="clearfix visible-md visible-lg"></div>

                        <!-- post -->
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-3.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-1" href="category.html">Web Design</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <!-- post -->
                        <div class="col-md-6">
                            <div class="post">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-4.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-2" href="category.html">JavaScript</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->
                    </div>
                </div>

                <div class="col-md-4">
                    <!--  MOST READ POST-->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Most Read</h2>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-1.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-4.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Why Node.js Is The Coolest Kid On The Backend Development Block!</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-5.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /post widget -->

                    <!-- post widget -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Featured Posts</h2>
                        </div>
                        <div class="post post-thumb">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-1.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <a class="post-category cat-3" href="category.html">Jquery</a>
                                    <span class="post-date">March 27, 2018</span>
                                </div>
                                <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                            </div>
                        </div>

                        <div class="post post-thumb">
                            <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <a class="post-category cat-2" href="category.html">JavaScript</a>
                                    <span class="post-date">March 27, 2018</span>
                                </div>
                                <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                            </div>
                        </div>
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
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- FEATURED POST section -->
    <div class="section section-grey">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h2>Featured Posts</h2>
                    </div>
                </div>

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-4.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-2" href="category.html">JavaScript</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-5.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-3" href="category.html">Jquery</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->

                <!-- post -->
                <div class="col-md-4">
                    <div class="post">
                        <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-3.jpg')}}" alt=""></a>
                        <div class="post-body">
                            <div class="post-meta">
                                <a class="post-category cat-1" href="category.html">Web Design</a>
                                <span class="post-date">March 27, 2018</span>
                            </div>
                            <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                        </div>
                    </div>
                </div>
                <!-- /post -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- most read, category and tags  section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- most read  section -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2>Most Read</h2>
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

                        <!-- post -->
                        <div class="col-md-12">
                            <div class="post post-row">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-6.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-2" href="category.html">JavaScript</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Why Node.js Is The Coolest Kid On The Backend Development Block!</a></h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <!-- post -->
                        <div class="col-md-12">
                            <div class="post post-row">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-1.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-4" href="category.html">Css</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">CSS Float: A Tutorial</a></h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <!-- post -->
                        <div class="col-md-12">
                            <div class="post post-row">
                                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/post-2.jpg')}}" alt=""></a>
                                <div class="post-body">
                                    <div class="post-meta">
                                        <a class="post-category cat-3" href="category.html">Jquery</a>
                                        <span class="post-date">March 27, 2018</span>
                                    </div>
                                    <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
                                </div>
                            </div>
                        </div>
                        <!-- /post -->

                        <div class="col-md-12">
                            <div class="section-row">
                                <button class="primary-button center-block">Load More</button>
                            </div>
                        </div>
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
                        <div class="category-widget">
                            <ul>
                                <li><a href="#" class="cat-1">Web Design<span>340</span></a></li>
                                <li><a href="#" class="cat-2">JavaScript<span>74</span></a></li>
                                <li><a href="#" class="cat-4">JQuery<span>41</span></a></li>
                                <li><a href="#" class="cat-3">CSS<span>35</span></a></li>
                            </ul>
                        </div>
                    </div>


                    <!-- all tags -->
                    <div class="aside-widget">
                        <div class="tags-widget">
                            <ul>
                                <li><a href="#">Chrome</a></li>
                                <li><a href="#">CSS</a></li>
                                <li><a href="#">Tutorial</a></li>
                                <li><a href="#">Backend</a></li>
                                <li><a href="#">JQuery</a></li>
                                <li><a href="#">Design</a></li>
                                <li><a href="#">Development</a></li>
                                <li><a href="#">JavaScript</a></li>
                                <li><a href="#">Website</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- Footer -->
    @include('includes.footer')
    <!-- /Footer -->

    <!-- jQuery Plugins -->
    @yield('scripts')
    <script src="{{asset('app/js/jquery.min.js')}}"></script>
    <script src="{{asset('app/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/js/main.js')}}"></script>
</body>

</html>