@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Restore</th>
                                <th>Delete</th>
                            </tr>
                            @if(count($posts) > 0)
                            @foreach($posts as $post)
                            <tr>
                                <td><img src="{{$post->featured}}" alt="{{ $post->title}}" width="90px" height="50px"> </td>
                                <td>{{ $post->title}}</td>
                                <td><a class="btn btn-success btn-sm" href="{{ route('post.restore', ['post' => $post->id])}}">Restore</a></td>
                                <td><a class="btn btn-danger btn-sm" href="{{ route('post.kill', ['post' => $post->id])}}">Delete</a></td>
                            </tr>
                            @endforeach
                            @else
                            <div class="align-center">
                                <tr>
                                    <td colspan="4" class="text-center"><b>No posts available in Trash.</b></td>
                                </tr>
                            </div>
                            @endif

                            </tabel>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
@include('admin.includes.toastr')
@endsection