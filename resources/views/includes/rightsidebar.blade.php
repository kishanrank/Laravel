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