@section('stylesheet')
@endsection
<header id="header">
    <!-- Nav -->
    <!-- Main Nav -->
    <div class="container">
        <div class="nav-logo">
            <h1><a href="/" class="logo" style="text-decoration: none">@if($setting) {{ $setting->site_name}} @else My Blog @endif</a></h1>
        </div>
    </div>
    <nav class="navbar navbar-default bg-primary">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('front.home') }}">Home</a></li>
                    @if($headerCategories)
                    @foreach($headerCategories as $category)
                    <li><a href="{{route('posts.by.category', ['categoryslug' => $category->slug])}}">{{$category->name}}</a></li>
                    @endforeach
                    @endif
                    <li><a href="{{ route('news') }}">Tech News</a></li>
                    <li><a href="{{ route('contactus') }}">Contact Us</a></li>
                    <li><a href="{{ route('aboutus') }}">About Us</a></li>
                </ul>
                <form class="navbar-form navbar-right" id="search_form" method="get" action="{{ route('search.result')}}">
                    <div class="form-group">
                        <input class="typeahead form-control search-input" id="search" type="text" name="search" minlength="3" placeholder="Search Here" required autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- /Main Nav -->
</header>