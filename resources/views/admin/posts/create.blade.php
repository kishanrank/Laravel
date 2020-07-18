@extends('layouts.app')

@section('stylesheet')
@endsection
@section ('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                             / <a href="{{ route('posts') }}"> Posts</a>
                        </li>
                        <li class="breadcrumb-item">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <strong> Create New Post</strong>
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('posts')}}">View Post</a>
                    </div>
                    <br>
                    <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header bg-gray">
                                    <strong>General Information</strong>
                                    <h6 class="float-right"><sup class="text-danger">*</sup> Required field</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Title <sup class="text-danger">*</sup></label>
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title')}}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="title">Category <sup class="text-danger">*</sup></label>
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
                                        <label for="tags"> Select Tags <sup class="text-danger">*</sup></label><br>
                                        @foreach($tags as $tag)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"> {{ $tag->tag }}
                                        </label>
                                        @endforeach

                                        @error('tags')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="featured">Featured Image <sup class="text-danger">*</sup> </label>
                                        <input type="file" name="featured" class="form-control @error('featured') is-invalid @enderror">
                                        <span class="text-danger">Note<sup >*</sup> : Please upload image files less then 200kb.</span>
                                        @error('featured')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="info"> Post Info <sup class="text-danger">*</sup> </label>
                                        <textarea class="textarea" name="info" id="info" cols="5" rows="5" class="form-control @error('info') is-invalid @enderror">{{ old('info')}}</textarea>
                                        @error('info')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="images"> Images  (Optional)</label>
                                        <input type="file" multiple name="images[]" class="form-control @error('images') is-invalid @enderror">
                                        <span class="text-danger">Note<sup >*</sup> : Please upload image files less then 200kb.</span>
                                        @error('images')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="content"> Content <sup class="text-danger">*</sup> </label>
                                        <textarea class="textarea" name="content" id="content" cols="5" rows="5" class="form-control @error('content') is-invalid @enderror">{{ old('content')}}</textarea>
                                        @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-gray">
                                    <strong>SEO Meta Information</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="meta-title">Meta Title <sup class="text-danger">*</sup></label>
                                        <input type="text" id="meta-title" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title')}}">
                                        @error('meta_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="meta-description">Meta Description <sup class="text-danger">*</sup></label>
                                        <input type="text" id="meta-description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" value="{{ old('meta_description') }}">
                                        @error('meta_description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-success">Save Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('content');
    CKEDITOR.replace('info');
</script>
@include('admin.includes.toastr')
@endsection