@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css')}}">
@endsection
@section ('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Posts</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Create new post
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('posts')}}">View Post</a>
                    </div>

                    <div class="card-body">
                        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title">Title :</label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Category :</label>
                                <select name="category_id" id="category" class="form-control @error('category_id') is-invalid @enderror">
                                    <option disabled selected>Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tags"> Select Tags :</label>
                                @foreach($tags as $tag)
                                <div class="checkbox">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"> {{ $tag->tag }}
                                </div>
                                @endforeach
                                @error('tags')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="featured">Featured Image : </label>
                                <input type="file" name="featured" class="form-control @error('featured') is-invalid @enderror">
                                <span>Note* : Please upload image files less then 200kb.</span>
                                @error('featured')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="info"> Post Info : </label>
                                <textarea class="textarea" name="info" id="info" cols="5" rows="5" class="form-control @error('info') is-invalid @enderror"></textarea>
                                @error('info')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="images"> Images : (Optional)</label>
                                <input type="file" multiple name="images[]" class="form-control @error('images') is-invalid @enderror">
                                <span>Note* : Please upload image files less then 100kb.</span>
                                @error('images')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content"> Content : </label>
                                <textarea class="textarea" name="content" id="content" cols="5" rows="5" class="form-control @error('content') is-invalid @enderror"></textarea>
                                @error('content')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <button class="btn btn-success" type="submit">
                                        Save Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
    $(function() {
        $('.textarea').summernote()
    })
</script>
@include('admin.includes.toastr')
@endsection
