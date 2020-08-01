<div class="aside-widget text-center">
    <a href="#" style="display: inline-block;margin: auto;">
        <img class="img-responsive" src="{{asset('app/img/ad-1.jpg')}}" alt="">
    </a>
</div>
<!-- /ad -->

<!-- post widget -->
<div class="most-read-aside-widget">
    <div class="text-center">
        <h2>Most Read</h2>
    </div>

    @forelse($mostReadPosts as $post)
    <div class="post-most-read post-widget">
        <!-- <a class="post-img" href="{{ route('post.single', ['slug' => $post->slug]) }}"><img src="{{ $post->featured }}" alt=""></a> -->
        <div class="post-body">
            <p class="post-title"><a href="{{ route('post.single', ['slug' => $post->slug]) }}"><i class="fa fa-chevron-right">&nbsp</i>{{$post->title}}</a></p>
        </div>
    </div>
    @empty
    <div>
        <strong>
            <h5 class="text-center">Sorry, No Post found.</h5>
        </strong>
    </div>
    @endforelse
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