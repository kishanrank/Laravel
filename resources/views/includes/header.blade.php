@section('stylesheet')
@endsection
<header id="header">
    <!-- Nav -->
    <!-- Main Nav -->
    <div class="container">
        <div class="nav-logo">
            <h1><a href="/" class="logo" style="text-decoration: none">{{ $setting->site_name}}</a></h1>
        </div>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand text-dark" href="/"><b>{{ $setting->site_name}}</b></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if($headerCategories)
                    @foreach($headerCategories as $category)
                    <li><a href="{{route('posts.by.category', ['categoryslug' => $category->slug])}}">{{$category->name}}</a></li>
                    @endforeach
                    @endif
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
                <form class="navbar-form navbar-right" id="search_form" method="get" action="{{ route('search.result')}}">
                    <div class="form-group">
                        <input class="typeahead form-control search-input" id="search" type="text" name="search" minlength="3" placeholder="Search Here" required>
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- /Main Nav -->

    <!-- Aside Nav -->
    <div id="nav-aside">
        <!-- nav -->
        <div class="section-row">
            <ul class="nav-aside-menu">
                <li><a href="/">Home</a></li>
                <li><a href="{{route('about')}}">About Us</a></li>
                <li><a href="#">Advertisement</a></li>
                <li><a href="{{route('contact')}}">Contacts</a></li>
            </ul>
        </div>
        <!-- /nav -->

        <!-- widget posts -->
        <div class="section-row">
            <h3>Recent Posts</h3>
            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="{{asset('app/img/widget-2.jpg')}}" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                </div>
            </div>

            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="./img/widget-3.jpg" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Why Node.js Is The Coolest Kid On The Backend Development Block!</a></h3>
                </div>
            </div>

            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="./img/widget-4.jpg" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                </div>
            </div>
        </div>
        <!-- /widget posts -->

        <!-- social links -->
        <div class="section-row">
            <h3>Follow us</h3>
            <ul class="nav-aside-social">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
            </ul>
        </div>
        <!-- /social links -->

        <!-- aside nav close -->
        <button class="nav-aside-close"><i class="fa fa-times"></i></button>
        <!-- /aside nav close -->
    </div>
    <!-- Aside Nav -->
    </div>
    <!-- /Nav -->
</header>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        source: function(query, result) {
            $.ajax({
                url: path,
                method: "get",
                data: {
                    query: query
                },
                dataType: "json",
                success: function(data) {
                    result($.map(data, function(data) {
                        return data.title
                    }));

                }
            });
        },
        minLength: 3
    });
</script>
@endsection