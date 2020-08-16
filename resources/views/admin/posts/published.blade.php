@extends('layouts.app')

@section('stylesheet')
@include('admin.includes.css.datatable')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Published Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                            / <a href="{{ route('posts') }}"> Posts</a>
                        </li>
                        <li class="breadcrumb-item">Published</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('post.create')}}"><i class="fa fa-sm fa-plus">&nbsp;</i>Create New Post</a>
                    </div>
                    <div class="card-body">
                        <table id="posts-table" class="table table-striped table-bordered responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th width="30%">Title</th>
                                    <th>Category</th>
                                    <th>Published At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@include('admin.posts.ajax.published')
@endsection