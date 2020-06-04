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
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
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
                        <input class="typeahead form-control search-input" id="search" type="text" name="search" minlength="3" placeholder="Search Here" required>
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- /Main Nav -->
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