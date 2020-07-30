    <!-- post meta tag -->
    <meta name="subject" content="{{ $post->meta_title}}">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->meta_description) ?? '',150,' ...') }}" />
    <meta name="url" content="{{ route('post.single', ['slug' => $post->slug]) }}">
    <meta name="image" content="{{ $post->featured }}">
    <meta name="category" content="{{ $post->category->name}}">

    <!-- og meta tags -->
    <meta property="og:title" content="{{ $post->meta_title}}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->meta_description) ?? '',150,' ...') }}">
    <meta property="og:url" content="{{ route('post.single', ['slug' => $post->slug]) }}">
    <meta property="og:image" content="{{ $post->featured }}">

    <!-- twitter meta tag -->
    <meta name="twitter:title" content="{{ $post->meta_title}}">
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->meta_description) ?? '',150,' ...') }}">
    <meta name="twitter:url" content="{{ route('post.single', ['slug' => $post->slug]) }}">
    <meta name="twitter:image" content="{{ $post->featured }}">