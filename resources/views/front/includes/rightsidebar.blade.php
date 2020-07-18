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

    @foreach($mostReadPosts as $post)
    <div class="post post-widget">
        <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug]) }}"><img src="{{ $post->featured }}" alt=""></a>
        <div class="post-body">
            <h3 class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug]) }}">{{$post->title}}</a></h3>
        </div>
    </div>
    @endforeach
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